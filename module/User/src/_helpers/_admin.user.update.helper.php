<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User\Admin;

use _MODULE\_DB;
use _MODULE\User\_ACCOUNT;
use _WKNT\_CRUD;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _USER_UPDATE
 * @package _MODULE\User\Admin
 */
class _USER_UPDATE
{

    /**
     * User Update
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $uid       = $variables['uid'];

        $errors = _REQUEST::_VALIDATE(
            [
                'username' => ['not_empty'],
                'email'    => ['email']
            ], $variables);

        if (empty($errors)):
            /**
             * Validation #2
             * In case they will decide to change the email or username
             */
            $user       = new _DB\User();
            $user_check = $user->search(
                [
                    'fields' => [
                        'username_1'      => [
                            'field_name' => 'username',
                            'type'       => '=',
                            'value'      => $variables['username']
                        ],
                        'condition_and_1' => [
                            'value' => 'and'
                        ],
                        'uid_1'           => [
                            'field_name' => 'uid',
                            'type'       => '!=',
                            'value'      => $uid
                        ],
                        'condition'       => [
                            'value' => 'or'
                        ],
                        'email_1'         => [
                            'field_name' => 'email',
                            'type'       => '=',
                            'value'      => $variables['email']
                        ],
                        'condition_and_2' => [
                            'value' => 'and'
                        ],
                        'uid_2'           => [
                            'field_name' => 'uid',
                            'type'       => '!=',
                            'value'      => $uid
                        ],
                    ]
                ]);

            if (empty($user_check)):
                /**
                 * Update this account with the new details
                 */
                // user table
                $user           = new _DB\User();
                $user->username = $variables['username'];
                $user->email    = $variables['email'];
                if (!empty($variables['password'])):
                    $user->password = _ACCOUNT::_passwordHash($variables['password']);
                endif;
                $user->date_updated = time();
                $user->save($uid);

                // user_profile
                $user_profile               = new _DB\UserProfile();
                $user_profile->p_first_name = $variables['first_name'];
                $user_profile->p_last_name  = $variables['last_name'];
                $user_profile->save($uid);


                /**
                 * Remove the old ids
                 */
                $del = new _CRUD();
                $del->deleteFrom('user_roles', 'ur_uid', $uid);

                /**
                 * Roles Update
                 */
                $roles = isset($variables['roles']) ? $variables['roles'] : [];
                if (!empty($roles)):
                    foreach ($roles as $roleID => $status):
                        $obj          = new _DB\UserRoles();
                        $obj->ur_uid  = $uid;
                        $obj->ur_role = $roleID;
                        $obj->create();
                    endforeach;
                endif;


                return json_encode(
                    [
                        'errors'  => false,
                        'message' => [
                            'type' => 'success',
                            'text' => $_TRANSLATION['user']['updated']
                        ],
                        'action'  => [
                            'function'  => 'clearPassword',
                            'arguments' => ''
                        ]
                    ]);
            /**
             * Account already there
             */
            else:
                $errors = [];
                if ($user_check[0]['username'] == $variables['username']):
                    $errors['username'][] = $_TRANSLATION['user']['username_used'];
                endif;

                if ($user_check[0]['email'] == $variables['email']):
                    $errors['email'][] = $_TRANSLATION['user']['email_used'];
                endif;

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
}