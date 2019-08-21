<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog\Admin;

use _MODULE\_DB;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _BLOG_SETTINGS
 * @package _MODULE\Blog\Admin
 */
class _BLOG_SETTINGS
{

    /**
     * Settings Update
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'object_name' => ['not_empty']
            ], $variables);

        if (empty($errors)):

            /**
             * Update your object
             */
            $newObject                     = new _DB\BlogSettings();
            $newObject->bs_name            = $variables['object_name'];
            $newObject->bs_body            = $variables['object_body'];
            $newObject->bs_seo_name        = $variables['object_seo_name'];
            $newObject->bs_seo_description = $variables['object_seo_description'];
            $newObject->bs_cover           = $variables['cover'];
            $newObject->bs_template        = '';
            $newObject->save(1);


            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['blog']['settings_updated']
                    ]
                ]);

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['blog']['errors']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}