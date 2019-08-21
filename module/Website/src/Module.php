<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_INIT;

/**
 * Class Website
 * @package _MODULE
 */
class Website extends _INIT
{

    /**
     * Alter the homepage variables
     */
    public static function Website_front_page()
    {
        $objectDetails = self::FrontPage();

        $object               = new _DB\WebsiteSettings();
        $object->connSettings = [
            'key' => 'sw_status'
        ];
        $settings             = $object->find(Website\Admin::$defaultStatus);
        if (!empty($objectDetails)):
            $pageDetails                   = $objectDetails[0];
            self::$_VIEW->page_title       = $settings['sw_title'];
            self::$_VIEW->page_description = $settings['sw_description'];
            self::$_VIEW->object           = $pageDetails;
            echo selfRender(Pages::$module, (empty($pageDetails['pd_template']) ? 'public' . DIRECTORY_SEPARATOR . 'page.php' : 'templates' . DIRECTORY_SEPARATOR . $pageDetails['pd_template']));
            exit();

        /**
         * No page used as a front page
         * Try and find the static file
         */
        else:
            self::$_VIEW->page_title       = isset($settings['sw_title']) ? $settings['sw_title'] : '';
            self::$_VIEW->page_description = isset($settings['sw_description']) ? $settings['sw_description'] : '';
            self::$_VIEW->pageBody         = selfRender(Website\Admin::$websiteTemplate, 'public' . DIRECTORY_SEPARATOR . 'homepage.php');

            echo selfRender(Website\Admin::$websiteTemplate, 'public' . DIRECTORY_SEPARATOR . 'homepage.php');
            exit();
        endif;
    }

    public static function FrontPage()
    {
        /**
         * Pages List
         */
        $object = new _DB\Pages();
        return $object->search(
            [
                'fields' => [
                    'pd_status'  => [
                        'type'  => '=',
                        'value' => 'PUBLISHED'
                    ],
                    'condition'  => [
                        'value' => 'and'
                    ],
                    'page_front' => [
                        'type'  => '=',
                        'value' => 1
                    ]
                ],
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'pd'
                    ]
                ],
                'sort'   => [
                    'page_title' => 'asc'
                ]
            ]
        );
    }

    /**
     * Set the 404 page
     */
    public static function Website_page_not_found()
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        header("HTTP/1.0 404 Not Found");

        self::$_VIEW->page_title       = 'Page not found';
        self::$_VIEW->page_description = '';
        echo self::$_VIEW->render($__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . '404.php');
        exit();
    }
}