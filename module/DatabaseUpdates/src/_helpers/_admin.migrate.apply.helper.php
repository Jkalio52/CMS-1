<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\DatabaseUpdates\Admin;

use _MODULE\_DB;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use function json_encode;

/**
 * Class _MIGRATE_APPLY
 * @package _MODULE\DatabaseUpdates\Admin
 */
class _MIGRATE_APPLY
{

    /**
     * Create a new page
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $errors    = _REQUEST::_VALIDATE(
            [
                'sitemap_name'    => ['not_empty'],
                'sitemap_machine' => ['not_empty'],
                'namespace'       => ['not_empty']
            ], $variables);

        if (empty($errors)):

            /**
             * Create a new page
             */
            $variables['sitemap_machine'] = _SANITIZE::slug($variables['sitemap_machine']);
            $slugCount                    = self::slugCount($variables['sitemap_machine']);
            $slug                         = ($slugCount > 0) ? $variables['sitemap_machine'] . '-' . ($slugCount - 1) : $variables['sitemap_machine'];
            $newObject                    = new _DB\Sitemaps();
            $newObject->sitemap_name      = $variables['sitemap_name'];
            $newObject->sitemap_machine   = $slug;
            $newObject->sitemap_namespace = $variables['namespace'];
            $newObject->create();


            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['sitemap']['created']
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
                        'text' => $_TRANSLATION['sitemap']['errors']
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
        $page         = new _DB\Sitemaps();
        $slugValidate = $page->search(
            [
                'fields' => [
                    'sitemap_machine' => [
                        'type'  => '=',
                        'value' => $slug
                    ]
                ]
            ]
        );

        $pageNumber = 0;
        while (!empty($slugValidate)) {
            $page         = new _DB\Sitemaps();
            $slugValidate = $page->search(
                [
                    'fields' => [
                        'sitemap_machine' => [
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