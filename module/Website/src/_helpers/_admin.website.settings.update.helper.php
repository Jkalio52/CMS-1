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
 * Class _SETTINGS_MANAGE
 * @package _MODULE\Website\Admin
 */
class _SETTINGS_MANAGE
{

    /**
     * Settings Update
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
            $object                 = new _DB\WebsiteSettings();
            $object->connSettings   = [
                'key' => 'sw_status'
            ];
            $object->sw_title       = $variables['object_seo_name'];
            $object->sw_description = $variables['object_seo_description'];
            $object->sw_front       = empty($variables['object_front']) ? 0 : $variables['object_front'];
            $object->save(Admin::$defaultStatus);

            /**
             * Set the front status on the page
             */
            // Reset
            $pageReset             = new _DB\Pages();
            $pageReset->page_front = 0;
            $pageReset->save();

            // Set
            if (!empty($variables['object_front'])):
                $pageUpdate             = new _DB\Pages();
                $pageUpdate->page_front = 1;
                $pageUpdate->save($variables['object_front']);
            endif;

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