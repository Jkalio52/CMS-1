<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\RoutingSystem;
use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _BLOG_CATEGORY_DELETE
 * @package _MODULE\Blog\Admin
 */
class _BLOG_CATEGORY_DELETE
{

    /**
     * Category Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $bcid      = $variables['bcid'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'blog_categories'         => [
                'key'   => 'bcid',
                'value' => $bcid
            ],
            'blog_categories_details' => [
                'key'   => 'bcd_bcid',
                'value' => $bcid
            ],
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        /**
         * Delete the route
         */
        RoutingSystem::delete($bcid, 'Blog', 'Blog\PublicCategory', 'View', 'static');

        _MESSAGE::set($_TRANSLATION['blog']['category_removed'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/blog/categories'
            ]);

    }

}