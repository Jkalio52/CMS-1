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
 * Class _USER_REGISTER
 * @package _MODULE\User
 */
class _USER_REGISTER
{

    /**
     * Create a new account
     */
    public static function execute()
    {
        global $_TRANSLATION;
        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'username' => ['not_empty'],
                'password' => ['not_empty'],
                'email'    => ['email']
            ], $variables);

        if (empty($errors)):

            /**
             * Validate the username and email
             */
            $user       = new _DB\User();
            $user_check = $user->search(
                [
                    'fields' => [
                        'username'  => [
                            'type'  => '=',
                            'value' => $variables['username']
                        ],
                        'condition' => [
                            'value' => 'or'
                        ],
                        'email'     => [
                            'type'  => '=',
                            'value' => $variables['email']
                        ]
                    ]
                ]);
            if (empty($user_check)):
                /**
                 * Create a new account
                 */
                // Store the details into user table
                $new_user               = new _DB\User();
                $new_user->username     = $variables['username'];
                $new_user->email        = $variables['email'];
                $new_user->password     = _ACCOUNT::_passwordHash($variables['password']);
                $new_user->logins       = 0;
                $new_user->date_created = _TIME::_DATE_TIME()['_NOW'];
                $new_user->date_updated = _TIME::_DATE_TIME()['_NOW'];
                $new_user->date_login   = 0;
                $new_user->session_id   = '';
                $new_user->status       = 1;
                $user_id                = $new_user->create();

                // Create the user profile
                $new_profile               = new _DB\UserProfile();
                $new_profile->p_uid        = $user_id['id'];
                $new_profile->p_first_name = '';
                $new_profile->p_last_name  = '';
                $new_profile->create();

                // Set the default role
                $new_role          = new _DB\UserRoles();
                $new_role->ur_uid  = $user_id['id'];
                $new_role->ur_role = 'authenticated';
                $new_role->create();

                // Auth
                _USER_LOGIN::auth($variables['username'], _ACCOUNT::_passwordHash($variables['password']));

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
                        'redirect' => '/dashboard'
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