<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class Admin
 * @package _MODULE\User
 */
class Admin extends _INIT
{
    private static $module = 'User\Admin';
    private static $moduleTemplate = 'Dashboard';

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

    /**
     * Return a list with all users
     */
    public static function getListAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [
            'status' => [
                'type'  => '=',
                'value' => 1
            ]
        ];

        if (isset($_GET_VARIABLES['first_name']) && !empty($_GET_VARIABLES['first_name'])):
            $filter['condition_first_name'] = [
                'value' => 'and'
            ];
            $filter['p_first_name']         = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['first_name'] . '%'
            ];
        endif;

        if (isset($_GET_VARIABLES['last_name']) && !empty($_GET_VARIABLES['last_name'])):
            $filter['condition_last_name'] = [
                'value' => 'and'
            ];
            $filter['p_last_name']         = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['last_name'] . '%'
            ];
        endif;

        if (isset($_GET_VARIABLES['email']) && !empty($_GET_VARIABLES['email'])):
            $filter['condition_email'] = [
                'value' => 'and'
            ];
            $filter['email']           = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['email'] . '%'
            ];
        endif;

        if (isset($_GET_VARIABLES['username']) && !empty($_GET_VARIABLES['username'])):
            $filter['condition_username'] = [
                'value' => 'and'
            ];
            $filter['username']           = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['username'] . '%'
            ];
        endif;


        $users     = new _DB\User();
        $usersList = $users->search(
            [
                'fields' => $filter,
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
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/users',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/users',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($usersList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $usersList
            ]
        );

        self::$_VIEW->menu             = 'users_management';
        self::$_VIEW->sMenu            = 'users';
        self::$_VIEW->page_title       = $_TRANSLATION['user']['admin_list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['admin_list']['seo_description'];

        self::template('admin/users.php');
    }

    /**
     * Generate the dashboard template
     *
     * @param $page
     */
    private static function template($page)
    {
        self::$_VRS = [
            'header'  => selfRender(self::$moduleTemplate, 'partials/header.php'),
            'footer'  => selfRender(self::$moduleTemplate, 'partials/footer.php'),
            'content' => selfRender('User', $page)
        ];
    }

    /**
     * Add a new user
     */
    public static function getAddAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;


        self::$_VIEW->menu             = 'users_management';
        self::$_VIEW->sMenu            = 'users_add';
        self::$_VIEW->page_title       = $_TRANSLATION['user']['admin_list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['admin_list']['seo_description'];

        self::template('admin/user.php');
    }

    /**
     * Add a new user
     */
    public static function getEditAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_UID        = $_REQUEST_ID[0];

        $user   = new _DB\User();
        $object = $user->search(
            [
                'fields' => [
                    'uid' => [
                        'type'  => '=',
                        'value' => $_UID
                    ]
                ],
                'join'   => [
                    'user_profile' => [
                        'mode'    => 'left join',
                        'table'   => 'user_profile',
                        'conn_id' => 'p_uid',
                        'as'      => 'up'
                    ]
                ]
            ]);
        if (empty($object)):
            _ROUTE::_REDIRECT('admin/users');
        endif;

        /**
         * Get the user current roles
         */
        $roles       = new _DB\UserRoles();
        $rolesSearch = $roles->search(
            [
                'fields' => [
                    'ur_uid' => [
                        'type'  => '=',
                        'value' => $_UID
                    ]
                ]
            ]);

        $currentRoles = [];
        if (!empty($rolesSearch)):
            foreach ($rolesSearch as $role):
                array_push($currentRoles, $role['ur_role']);
            endforeach;
        endif;


        self::$_VIEW->object = $object[0];

        self::$_VIEW->currentRoles     = $currentRoles;
        self::$_VIEW->menu             = 'users_management';
        self::$_VIEW->sMenu            = 'users_update';
        self::$_VIEW->page_title       = $_TRANSLATION['user']['admin_list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['admin_list']['seo_description'];

        self::template('admin/user.php');
    }

    /**
     * User Delete
     */
    public static function getDeleteAction()
    {

        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_UID        = $_REQUEST_ID[0];

        $user   = new _DB\User();
        $object = $user->search(
            [
                'fields' => [
                    'uid' => [
                        'type'  => '=',
                        'value' => $_UID
                    ]
                ],
                'join'   => [
                    'user_profile' => [
                        'mode'    => 'left join',
                        'table'   => 'user_profile',
                        'conn_id' => 'p_uid',
                        'as'      => 'up'
                    ]
                ]
            ]);
        if (empty($object)):
            _ROUTE::_REDIRECT('admin/users');
        endif;
        self::$_VIEW->object = $object[0];


        self::$_VIEW->menu             = 'users_management';
        self::$_VIEW->sMenu            = 'users_update';
        self::$_VIEW->page_title       = $_TRANSLATION['user']['admin_list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['user']['admin_list']['seo_description'];

        self::template('admin/user-delete.php');
    }


}