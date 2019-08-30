<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_INIT;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class Blog
 * @package _MODULE
 */
class Blog extends _INIT
{

    private static $module = 'Blog';

    /**
     * @return string
     */
    public static function blogSlug()
    {
        return 'blog' . DIRECTORY_SEPARATOR;
    }

    /**
     * Admin Widget - Top
     * @param array $object
     */
    public static function Blog_admin_dashboard_index_top($object = [])
    {
        $objects            = new _DB\BlogPost();
        self::$_VIEW->count = $objects->count('bpid');
        echo selfRender(self::$module, 'widgets/posts.stats.php');
    }

    /**
     * Admin Widget - Bottom
     * @param array $object
     */
    public static function Blog_admin_dashboard_index_bottom($object = [])
    {
        $objects     = new _DB\BlogPost();
        $objectsList = $objects->search(
            [
                'fields' => [],
                'join'   => [
                    'blog_post_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_post_details',
                        'conn_id' => 'bpd_bpid',
                        'as'      => 'bpd'
                    ]
                ],
                'sort'   => [
                    'bpid' => 'desc'
                ],
                'limit'  => isset($object['limit']) ? $object['limit'] : 10
            ]);

        self::$_VIEW->objects = $objectsList;
        echo selfRender(self::$module, 'widgets/posts.list.php');
    }

    /**
     * Blog Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;

        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'];
        if (method_exists('\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'], 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['blog']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}