<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\_DB;
use _MODULE\Blog;
use _MODULE\PageBuilder;
use _MODULE\RoutingSystem;
use _WKNT\_CRUD;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _POST_UPDATE
 * @package _MODULE\Blog\Admin
 */
class _POST_UPDATE
{

    /**
     * Post Update
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
             * Update your post
             */
            $variables['object_slug'] = _SANITIZE::slug($variables['object_slug']);
            $slugCount                = self::slugCount($variables['object_slug'], $variables['bpid']);
            $slug                     = ($slugCount > 0) ? $variables['object_slug'] . '-' . ($slugCount - 1) : $variables['object_slug'];

            // Update the details into the posts table
            $objectUpdate             = new _DB\BlogPost();
            $objectUpdate->bp_title   = $variables['object_name'];
            $objectUpdate->bp_slug    = $slug;
            $objectUpdate->bp_preview = $variables['object_preview'];
            $objectUpdate->bp_body    = $variables['object_body'];
            $objectUpdate->bp_cover   = $variables['cover'];
            $objectUpdate->save($variables['bpid']);

            // Set the post extra details
            $ObjectDetails                      = new _DB\BlogPostDetails();
            $ObjectDetails->bpd_seo_title       = $variables['object_seo_name'];
            $ObjectDetails->bpd_seo_description = $variables['object_seo_description'];
            $ObjectDetails->bpd_status          = empty($variables['object_status']) ? 'DRAFT' : $variables['object_status'];
            $ObjectDetails->bpd_template        = $variables['object_template'];
            $ObjectDetails->bpd_date_updated    = _TIME::_DATE_TIME()['_NOW'];
            $ObjectDetails->save($variables['bpid']);


            /**
             * Remove the old ids
             */
            $del = new _CRUD();
            $del->deleteFrom('blog_post_categories', 'pbc_bpid', $variables['bpid']);

            // Store the selected categories
            $category = isset($variables['category']) ? $variables['category'] : [];
            if (!empty($category)):
                foreach ($category as $categoryId => $status):
                    $catDb           = new _DB\BlogPostCategories();
                    $catDb->pbc_bcid = $categoryId;
                    $catDb->pbc_bpid = $variables['bpid'];
                    $catDb->create();
                endforeach;
            endif;

            // Set the new route
            RoutingSystem::update($variables['bpid'], Blog::blogSlug() . $slug, 'Blog', 'Blog\PublicPost', 'View', 'static');

            /**
             * PageBuilder Data Update
             */
            PageBuilder::store($variables['bpid']);

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['blog']['updated']
                    ]
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
     * @param $id
     *
     * @return int
     */
    private static function slugCount($slug, $id)
    {

        /**
         * Validate the post slug
         */
        $object       = new _DB\BlogPost();
        $slugValidate = $object->search(
            [
                'fields' => [
                    'bp_slug'   => [
                        'type'  => '=',
                        'value' => $slug
                    ],
                    'condition' => [
                        'value' => 'and'
                    ],
                    'bpid'      => [
                        'type'  => '!=',
                        'value' => $id
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($slugValidate)) {
            $slugValidate = $object->search(
                [
                    'fields' => [
                        'bp_slug'   => [
                            'type'  => '=',
                            'value' => $slug
                        ],
                        'condition' => [
                            'value' => 'and'
                        ],
                        'bpid'      => [
                            'type'  => '!=',
                            'value' => $id
                        ]
                    ]
                ]);
            $objectNumber++;
        }

        return $objectNumber;
    }

}