<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User;

use _MODULE\_DB;
use _WKNT\_REQUEST;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _USER_LOGIN
 * @package _MODULE\User
 */
class _USER_LOGIN
{

    /**
     * User Login Validation
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'username' => ['not_empty'],
                'password' => ['not_empty']
            ], $variables);

        if (empty($errors)):

            $auth = self::auth($variables['username'], _ACCOUNT::_passwordHash($variables['password']));
            if ($auth):
                return json_encode(
                    [
                        'errors'   => false,
                        'message'  => [
                            'type' => 'success',
                            'text' => $_TRANSLATION['user']['dashboard_redirect']
                        ],
                        'action'   => [
                            'function'  => 'clearAll',
                            'arguments' => ''
                        ],
                        'redirect' => _ACCOUNT::_isAdmin() ? '/admin' : '/dashboard'
                    ]);
            else:
                return json_encode(
                    [
                        'errors'   => true,
                        'message'  => [
                            'type' => 'danger',
                            'text' => $_TRANSLATION['user']['invalid_login']
                        ],
                        'action'   => [
                            'function'  => 'clearAll',
                            'arguments' => ''
                        ],
                        'redirect' => ''
                    ]);
            endif;

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['user']['errors']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

    /**
     * @param $username
     * @param $password
     * @param bool $sli
     *
     * @return bool
     */
    public static function auth($username, $password, $sli = false)
    {

        $user               = new _DB\User();
        $user->connSettings = [
            'key' => 'uid',
        ];
        if ($sli):
            $fields = [
                'uid' => [
                    'type'  => '=',
                    'value' => $sli
                ]
            ];
        else:
            $fields = [
                'username'  => [
                    'type'  => '=',
                    'value' => $username
                ],
                'condition' => [
                    'value' => 'and'
                ],
                'password'  => [
                    'type'  => '=',
                    'value' => $password
                ]
            ];
        endif;
        $validate = $user->search(
            [
                'fields' => $fields,
                'join'   => [
                    'user_profile' => [
                        'mode'    => 'left join',
                        'table'   => 'user_profile',
                        'conn_id' => 'p_uid',
                        'as'      => 'up'
                    ]
                ]
            ]);

        if (empty($validate)):
            return false;
        else:
            $ssid = 'ssid_' . session_id();

            /**
             * Current Roles
             */
            $roles     = new _DB\UserRoles();
            $rolesList = $roles->search(
                [
                    'fields' => [
                        'ur_uid' => [
                            'type'  => '=',
                            'value' => $validate[0]['uid']
                        ]
                    ]
                ]);
            $rolesOnly = [];
            foreach ($rolesList as $value):
                array_push($rolesOnly, $value['ur_role']);
            endforeach;

            /**
             * Set the current session
             */
            $account = $validate['0'];
            unset($account['password']);
            _ACCOUNT::_setSession(
                [
                    'current_user'             => $account,
                    'user'                     => $ssid,
                    'roles'                    => $rolesOnly,
                    'password_update_required' => $sli
                ]
            );

            $user->session_id = $ssid;
            $user->logins     = $validate['0']['logins'] + 1;
            $user->date_login = _TIME::_DATE_TIME()['_NOW'];
            $user->save($validate['0']['uid']);

            return true;
        endif;
    }
}