<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User;


use _MODULE\_DB;
use _MODULE\SMTP;
use _WKNT\_ENCRYPT;
use _WKNT\_REQUEST;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _USER_RECOVER
 * @package _MODULE\User
 */
class _USER_RECOVER
{

    /**
     * User Recover Validation
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $errors    = _REQUEST::_VALIDATE(
            [
                'email' => ['email'],
            ], $variables);

        if (empty($errors)):

            /**
             * Search for the user account
             */

            $user               = new _DB\User();
            $user->connSettings = [
                'key' => 'uid',
            ];
            $validate           = $user->search(
                [
                    'fields' => [
                        'email' => [
                            'type'  => '=',
                            'value' => $variables['email']
                        ]
                    ]
                ]);
            if (!empty($validate)):
                /**
                 * Generate the unique login link
                 */
                $code_1          = _ENCRYPT::_HASH_CODE(['length' => 3, 'parts' => 1]);
                $code_2          = _ENCRYPT::_HASH_CODE(['length' => 2, 'parts' => 4]);
                $recover         = new _DB\UserRecover();
                $recover->r_uid  = $validate['0']['uid'];
                $recover->code_1 = $code_1;
                $recover->code_2 = $code_2;
                $recover->date   = _TIME::_DATE_TIME()['_NOW'];
                $recover->create();

                /**
                 * Send the email
                 */

                $body = str_replace(
                    [
                        '{SINGLE_LOGIN}',
                        '{WEBSITE_URL}'
                    ], [
                        $_APP_CONFIG['_DOMAIN_ROOT'] . 'login/sli/' . $code_1 . '/' . $code_2,
                        $_APP_CONFIG['_DOMAIN_ROOT']
                    ], $_TRANSLATION['user']['account_recovery_user']['body']);

                SMTP::_SEND(
                    [
                        'to'        => $validate['0']['email'],
                        'subject'   => $_TRANSLATION['user']['account_recovery_user']['subject'],
                        'body'      => $body,
                        'text_body' => $_TRANSLATION['user']['account_recovery_user']['preview'],
                    ]);

            endif;


            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['user']['recovery_ok']
                    ],
                    'action'   => [
                        'function'  => 'clearAll',
                        'arguments' => ''
                    ],
                    'redirect' => false
                ]);
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