<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Website\Admin;

use _MODULE\_DB;
use _MODULE\Website\Admin;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _SMTP_MANAGE
 * @package _MODULE\Website\Admin
 */
class _SMTP_MANAGE
{

    /**
     * SMTP
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $errors    = _REQUEST::_VALIDATE([], $variables);

        if (empty($errors)):

            /**
             * Update your object
             */
            $object                = new _DB\SMTPSettings();
            $object->connSettings  = [
                'key' => 'status'
            ];
            $object->hostname      = $variables['object_hostname'];
            $object->port          = $variables['object_port'];
            $object->username      = $variables['object_username'];
            $object->password      = $variables['object_password'];
            $object->noreply_email = $variables['object_noreply_email'];
            $object->noreply_name  = $variables['object_noreply_name'];
            $object->tls           = isset($variables['object_tls']) ? 1 : 0;
            $object->save(Admin::$defaultStatus);


            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['website']['updated']
                    ]
                ]);

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['website']['errors']
                    ],
                    'redirect' => false
                ]);
        endif;
    }
}