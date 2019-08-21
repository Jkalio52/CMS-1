<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\PageBuilder;
use _MODULE\RoutingSystem;
use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _BLOG_POST_DELETE
 * @package _MODULE\Blog\Admin
 */
class _BLOG_POST_DELETE
{

    /**
     * Blog Post Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $bpid      = $variables['bpid'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'blog_post'         => [
                'key'   => 'bpid',
                'value' => $bpid
            ],
            'blog_post_details' => [
                'key'   => 'bpd_bpid',
                'value' => $bpid
            ],
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        /**
         * Delete the route
         */
        RoutingSystem::delete($bpid, 'Blog', 'Blog\PublicPost', 'View', 'static');

        _MESSAGE::set($_TRANSLATION['blog']['removed'], 'success');

        /**
         * PageBuilder Data Remove
         */
        PageBuilder::delete($bpid);

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/blog'
            ]);
    }

}