<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Pages\Admin;

use _MODULE\_DB;
use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _PAGE_CREATE
 * @package _MODULE\Pages\Admin
 */
class _PAGE_CREATE
{

    /**
     * Create a new page
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'page_name' => ['not_empty'],
                'page_slug' => ['not_empty']
            ], $variables);

        if (empty($errors)):

            /**
             * Create a new page
             */
            $variables['page_slug'] = _SANITIZE::slug($variables['page_slug']);
            $slugCount              = self::slugCount($variables['page_slug']);

            $slug = ($slugCount > 0) ? $variables['page_slug'] . '-' . ($slugCount - 1) : $variables['page_slug'];
            // Store the details into the pages table
            $new_page             = new _DB\Pages();
            $new_page->page_title = $variables['page_name'];
            $new_page->page_slug  = $slug;
            $new_page->page_body  = $variables['page_body'];
            $page_id              = $new_page->create();

            // Set the page extra details
            $page_details                     = new _DB\PagesDetails();
            $page_details->pd_pid             = $page_id['id'];
            $page_details->pd_seo_title       = $variables['page_seo_name'];
            $page_details->pd_seo_description = $variables['page_seo_description'];
            $page_details->pd_status          = empty($variables['page_status']) ? 'DRAFT' : $variables['page_status'];
            $page_details->pd_template        = $variables['page_template'];
            $page_details->pd_date_created    = _TIME::_DATE_TIME()['_NOW'];
            $page_details->pd_date_updated    = _TIME::_DATE_TIME()['_NOW'];
            $page_details->create();

            // Add the current page url into the routing system
            $route                 = new _DB\RoutingSystem();
            $route->object_id      = $page_id['id'];
            $route->route          = $slug;
            $route->module         = 'Pages';
            $route->namespace      = 'Pages\PublicPages';
            $route->action         = 'View';
            $route->type           = 'static';
            $route->methods        = 'get';
            $route->required_roles = '';
            $route->local_template = 1;
            $route->created_date   = _TIME::_DATE_TIME()['_NOW'];
            $route->create();

            /**
             * PageBuilder Data Record
             */
            PageBuilder::store($page_id['id']);

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['pages']['created']
                    ],
                    'action'  => [
                        'function'  => 'clearAll',
                        'arguments' => ''
                    ],
                ]
            );

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['pages']['errors']
                    ],
                    'redirect' => false
                ]
            );
        endif;
    }

    /**
     * @param $slug
     *
     * @return int
     */
    private static function slugCount($slug)
    {

        /**
         * Validate the page slug
         */
        $page         = new _DB\Pages();
        $slugValidate = $page->search(
            [
                'fields' => [
                    'page_slug' => [
                        'type'  => '=',
                        'value' => $slug
                    ]
                ]
            ]
        );

        $pageNumber = 0;
        while (!empty($slugValidate)) {
            $page         = new _DB\Pages();
            $slugValidate = $page->search(
                [
                    'fields' => [
                        'page_slug' => [
                            'type'  => '=',
                            'value' => $slug . '-' . $pageNumber
                        ]
                    ]
                ]
            );
            $pageNumber++;
        }

        return $pageNumber;
    }
}