<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Pages\Admin;

use _MODULE\_DB;
use _MODULE\PageBuilder;
use _MODULE\RoutingSystem;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _PAGE_UPDATE
 * @package _MODULE\Pages\Admin
 */
class _PAGE_UPDATE
{

    /**
     * Page Update
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
             * Update your page
             */
            $variables['page_slug'] = _SANITIZE::slug($variables['page_slug']);
            $slugCount              = self::slugCount($variables['page_slug'], $variables['pid']);
            $slug                   = ($slugCount > 0) ? $variables['page_slug'] . '-' . ($slugCount - 1) : $variables['page_slug'];

            // Update the details into the pages table
            $page_update             = new _DB\Pages();
            $page_update->page_title = $variables['page_name'];
            $page_update->page_slug  = $slug;
            $page_update->page_body  = $variables['page_body'];
            $page_update->save($variables['pid']);

            // Set the page extra details
            $page_details                     = new _DB\PagesDetails();
            $page_details->pd_seo_title       = $variables['page_seo_name'];
            $page_details->pd_seo_description = $variables['page_seo_description'];
            $page_details->pd_status          = empty($variables['page_status']) ? 'DRAFT' : $variables['page_status'];
            $page_details->pd_template        = $variables['page_template'];
            $page_details->pd_date_updated    = _TIME::_DATE_TIME()['_NOW'];
            $page_details->save($variables['pid']);

            // Set the new route
            RoutingSystem::update($variables['pid'], $slug, 'Pages', 'Pages\PublicPages', 'View', 'static');

            /**
             * PageBuilder Data Update
             */
            PageBuilder::store($variables['pid']);

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['pages']['updated']
                    ]
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
     * @param $id
     *
     * @return int
     */
    private static function slugCount($slug, $id)
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
                    ],
                    'condition' => [
                        'value' => 'and'
                    ],
                    'pid'       => [
                        'type'  => '!=',
                        'value' => $id
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
                        ],
                        'condition' => [
                            'value' => 'and'
                        ],
                        'pid'       => [
                            'type'  => '!=',
                            'value' => $id
                        ]
                    ]
                ]
            );
            $pageNumber++;
        }

        return $pageNumber;
    }
}