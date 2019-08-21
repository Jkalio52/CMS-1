<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\_DB;
use _MODULE\Blog;
use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _POST_CREATE
 * @package _MODULE\Blog\Admin
 */
class _POST_CREATE
{

    /**
     * Create a new post
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'object_name' => ['not_empty'],
                'object_slug' => ['not_empty']
            ], $variables);

        if (empty($errors)):

            /**
             * Create a new post
             */
            $variables['object_slug'] = _SANITIZE::slug($variables['object_slug']);
            $slugCount                = self::slugCount($variables['object_slug']);


            $slug = ($slugCount > 0) ? $variables['object_slug'] . '-' . ($slugCount - 1) : $variables['object_slug'];

            // Store the details into the post table
            $newObject             = new _DB\BlogPost();
            $newObject->bp_title   = $variables['object_name'];
            $newObject->bp_slug    = $slug;
            $newObject->bp_preview = $variables['object_preview'];
            $newObject->bp_cover   = $variables['cover'];
            $newObject->bp_body    = $variables['object_body'];
            $objectDb              = $newObject->create();

            // Set the post extra details
            $newObjectDetails                      = new _DB\BlogPostDetails();
            $newObjectDetails->bpd_bpid            = $objectDb['id'];
            $newObjectDetails->bpd_seo_title       = $variables['object_seo_name'];
            $newObjectDetails->bpd_seo_description = $variables['object_seo_description'];
            $newObjectDetails->bpd_status          = empty($variables['object_status']) ? 'DRAFT' : $variables['object_status'];
            $newObjectDetails->bpd_template        = $variables['object_template'];
            $newObjectDetails->bpd_date_created    = _TIME::_DATE_TIME()['_NOW'];
            $newObjectDetails->bpd_date_updated    = _TIME::_DATE_TIME()['_NOW'];
            $newObjectDetails->create();

            // Store the selected categories
            $category = isset($variables['category']) ? $variables['category'] : [];
            if (!empty($category)):
                foreach ($category as $categoryId => $status):
                    $catDb           = new _DB\BlogPostCategories();
                    $catDb->pbc_bcid = $categoryId;
                    $catDb->pbc_bpid = $objectDb['id'];
                    $catDb->create();
                endforeach;
            endif;

            // Add the current post url into the routing system
            $route                 = new _DB\RoutingSystem();
            $route->object_id      = $objectDb['id'];
            $route->route          = Blog::blogSlug() . $slug;
            $route->module         = 'Blog';
            $route->namespace      = 'Blog\PublicPost';
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
            PageBuilder::store($objectDb['id']);

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['blog']['created']
                    ],
                    'action'  => [
                        'function'  => 'clearAll',
                        'arguments' => ''
                    ],
                ]);

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['blog']['errors']
                    ],
                    'redirect' => false
                ]);
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
         * Validate the post slug
         */
        $object       = new _DB\BlogPost();
        $slugValidate = $object->search(
            [
                'fields' => [
                    'bp_slug' => [
                        'type'  => '=',
                        'value' => $slug
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($slugValidate)) {
            $slugValidate = $object->search(
                [
                    'fields' => [
                        'bp_slug' => [
                            'type'  => '=',
                            'value' => $slug . '-' . $objectNumber
                        ]
                    ]
                ]);
            $objectNumber++;
        }

        return $objectNumber;
    }

}