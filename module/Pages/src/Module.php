<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _MODULE\User\_ACCOUNT;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class Pages
 * @package _MODULE
 */
class Pages extends _INIT
{

    public static $module = 'Pages';

    /**
     * Pages Management
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
                        'text' => $_TRANSLATION['pages']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

    /**
     * Set the current template file
     *
     * @param $page
     * @param bool $loggedOutOnly
     */
    private static function template($page, $loggedOutOnly = false)
    {
        if ($loggedOutOnly):
            if (_ACCOUNT::_loggedIn('user')):
                self::$_VIEW->content = selfRender(self::$module, 'loggedin.php');
            else:
                self::$_VIEW->content = selfRender(self::$module, $page);
            endif;
        else:
            self::$_VIEW->content = selfRender(self::$module, $page);
        endif;
    }

    /**
     * Admin Widget - Top
     * @param array $object
     */
    public static function Pages_admin_dashboard_index_top($object = [])
    {
        $objects            = new _DB\Pages();
        self::$_VIEW->count = $objects->count('pid');
        echo selfRender(self::$module, 'widgets/pages.stats.php');
    }

    /**
     * Admin Widget - Bottom
     * @param array $object
     */
    public static function Pages_admin_dashboard_index_bottom($object = [])
    {
        $objects              = new _DB\Pages();
        $objectsList          = $objects->search(
            [
                'fields' => [],
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'pd'
                    ]
                ],
                'sort'   => [
                    'pid' => 'desc'
                ],
                'limit'  => isset($object['limit']) ? $object['limit'] : 10
            ]);
        self::$_VIEW->objects = $objectsList;
        echo selfRender(self::$module, 'widgets/pages.list.php');
    }

}