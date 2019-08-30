<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _MODULE\User\_ACCOUNT;
use _MODULE\User\_USER_LOGIN;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class User
 * @package _MODULE
 */
class User extends _INIT
{

    public static  $roles
                           = [
            'moderator'     => 'Moderator',
            'authenticated' => 'Authenticated',
            'administrator' => 'Administrator'
        ];
    private static $module = 'User';

    /**
     * Register
     */
    public static function getRegisterAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        if (!isset($_APP_CONFIG['_USER']['REGISTER']) || !$_APP_CONFIG['_USER']['REGISTER']):
            _ROUTE::_REDIRECT('');
        endif;

        self::$_VIEW->page_title       = $_TRANSLATION['user']['register']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['register']['seo_description'];

        /**
         * Generate the signup content
         */
        self::template('register.php', true);
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
     * Login
     */
    public static function getLoginAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        if (!isset($_APP_CONFIG['_USER']['LOGIN']) || !$_APP_CONFIG['_USER']['LOGIN']):
            _ROUTE::_REDIRECT('');
        endif;

        self::$_VIEW->page_title       = $_TRANSLATION['user']['login']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['login']['seo_description'];

        /**
         * Generate the login content
         */
        self::template('login.php', true);
    }

    /**
     * Recover
     */
    public static function getRecoverAction()
    {
        global $_TRANSLATION;

        self::$_VIEW->page_title       = $_TRANSLATION['user']['recover']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['recover']['seo_description'];

        /**
         * Generate the recover content
         */
        self::template('recover.php', true);
    }

    /**
     * Logout
     */
    public static function getLogoutAction()
    {
        _ACCOUNT::_destroySession();
        _ROUTE::_REDIRECT(_ROUTE::$_CURRENT_ROUTE['redirect_page']);
    }

    /**
     * Single Login Validation
     */
    public static function getSliAction()
    {
        global $_TRANSLATION;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_ID         = $_REQUEST_ID[0];
        $_AUTH       = $_REQUEST_ID[1];

        $user_recover = new _DB\UserRecover();
        $validate     = $user_recover->search(
            [
                'fields' => [
                    'code_1'      => [
                        'type'  => '=',
                        'value' => $_ID
                    ],
                    'condition'   => [
                        'value' => 'and'
                    ],
                    'code_2'      => [
                        'type'  => '=',
                        'value' => $_AUTH
                    ],
                    'condition_2' => [
                        'value' => 'and'
                    ],
                    'date'        => [
                        'type'  => '>',
                        'value' => strtotime("-1 day")
                    ],
                ]
            ]);

        self::$_VIEW->page_title       = $_TRANSLATION['user']['recover_sli']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['recover_sli']['seo_description'];

        if (_ACCOUNT::_loggedIn('user')):
            self::template('loggedin.php');
        else:
            /**
             * Generate the recover content
             */
            if (empty($validate)):
                self::template('recover-sli-error.php');
            else:
                /**
                 * User Auth
                 */
                $del               = new _DB\UserRecover();
                $del->connSettings = [
                    'delete_key'   => 'r_uid',
                    'delete_value' => $validate[0]['r_uid']
                ];
                $del->delete();

                _USER_LOGIN::auth('', '', $validate[0]['r_uid']);
                self::template('recover-sli.php');
            endif;
        endif;
    }

    /**
     * Route secure by checking the current roles
     */
    public static function User_route_load()
    {
        $_CURRENT_ROLES = _ACCOUNT::_getRoles();
        $_CURRENT_ROUTE = _ROUTE::$_CURRENT_ROUTE;
        if (isset($_CURRENT_ROUTE['required_roles']) && !empty($_CURRENT_ROUTE['required_roles'])):
            foreach ($_CURRENT_ROUTE['required_roles'] as $role):
                if (!in_array($role, $_CURRENT_ROLES)):
                    _ROUTE::_REDIRECT($_CURRENT_ROUTE['redirect_page']);
                    exit(0);
                endif;
            endforeach;
        endif;
    }

    /**
     * Admin Widget - Top
     * @param array $object
     */
    public static function User_admin_dashboard_index_top($object = [])
    {
        $objects            = new _DB\User();
        self::$_VIEW->count = $objects->count('uid');
        echo selfRender(self::$module, 'widgets/users.stats.php');
    }


    /**
     * Admin Widget - Bottom
     * @param array $object
     */
    public static function User_admin_dashboard_index_bottom($object = [])
    {
        $objects              = new _DB\User();
        $objectsList          = $objects->search(
            [
                'fields' => [],
                'join'   => [
                    'user_profile' => [
                        'mode'    => 'left join',
                        'table'   => 'user_profile',
                        'conn_id' => 'p_uid',
                        'as'      => 'up'
                    ]
                ],
                'sort'   => [
                    'uid' => 'desc'
                ],
                'limit'  => isset($object['limit']) ? $object['limit'] : 10
            ]);
        self::$_VIEW->objects = $objectsList;
        echo selfRender(self::$module, 'widgets/users.list.php');
    }

    /**
     * User Management
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
                        'text' => $_TRANSLATION['user']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }
}