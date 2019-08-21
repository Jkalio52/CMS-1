<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\_DB;
use _MODULE\Blog;
use _MODULE\RoutingSystem;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _BLOG_CATEGORY_UPDATE
 * @package _MODULE\Blog\Admin
 */
class _BLOG_CATEGORY_UPDATE
{

    /**
     * Category Update
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
             * Update your object
             */
            $variables['object_slug'] = _SANITIZE::slug($variables['object_slug']);
            $slugCount                = self::slugCount($variables['object_slug'], $variables['bcid']);

            $slug = ($slugCount > 0) ? $variables['object_slug'] . '-' . ($slugCount - 1) : $variables['object_slug'];

            $newObject           = new _DB\BlogCategories();
            $newObject->bc_title = $variables['object_name'];
            $newObject->bc_slug  = $slug;
            $newObject->bc_body  = $variables['object_body'];
            $newObject->bc_cover = $variables['cover'];
            $newObject->save($variables['bcid']);

            $newObjectDetails                      = new _DB\BlogCategoriesDetails();
            $newObjectDetails->bcd_seo_title       = $variables['object_seo_name'];
            $newObjectDetails->bcd_seo_description = $variables['object_seo_description'];
            $newObjectDetails->bcd_parent          = empty($variables['object_parent']) ? 0 : $variables['object_parent'];
            $newObjectDetails->bcd_template        = $variables['object_template'];
            $newObjectDetails->bcd_status          = empty($variables['object_status']) ? 'DRAFT' : $variables['object_status'];
            $newObjectDetails->bcd_date_created    = _TIME::_DATE_TIME()['_NOW'];
            $newObjectDetails->bcd_date_updated    = _TIME::_DATE_TIME()['_NOW'];
            $newObjectDetails->save($variables['bcid']);


            // Set the new route
            RoutingSystem::update($variables['bcid'], Blog::blogSlug() . $slug, 'Blog', 'Blog\PublicCategory', 'View', 'static');

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['blog']['category_updated']
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
         * Validate the object slug
         */
        $object       = new _DB\BlogCategories();
        $slugValidate = $object->search(
            [
                'fields' => [
                    'bc_slug'   => [
                        'type'  => '=',
                        'value' => $slug
                    ],
                    'condition' => [
                        'value' => 'and'
                    ],
                    'bcid'      => [
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
                        'bc_slug' => [
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