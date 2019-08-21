<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Website;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class Admin
 * @package _MODULE\Website
 */
class Admin extends _INIT
{
    public static
        $module = 'Website\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'website',
        $websiteTemplate = 'Website',
        $defaultStatus = 1;

    /**
     * Settings
     */
    public static function getSettingsAction()
    {
        global $_TRANSLATION;

        $object               = new _DB\WebsiteSettings();
        $object->connSettings = [
            'key' => 'sw_status'
        ];

        $objectDetails = $object->find(self::$defaultStatus);
        if (empty($objectDetails)):
            $newObject                         = new _DB\WebsiteSettings();
            $newObject->sw_title               = '';
            $newObject->sw_description         = '';
            $newObject->sw_page_builder_config = '';
            $newObject->sw_page_builder_data   = '';
            $newObject->sw_status              = 1;
            $newObject->create();
        endif;

        /**
         * Pages List
         */
        $pages     = new _DB\Pages();
        $pagesList = $pages->search(
            [
                'fields' => [
                    'pd_status' => [
                        'type'  => '=',
                        'value' => 'PUBLISHED'
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

        self::$_VIEW->object           = $objectDetails;
        self::$_VIEW->menu             = 'settings';
        self::$_VIEW->sMenu            = 'website_settings';
        self::$_VIEW->pages            = $pagesList;
        self::$_VIEW->page_title       = $_TRANSLATION['website']['settings']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['website']['settings']['seo_description'];

        self::template('admin/website.php');
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
            'content' => selfRender('Website', $page)
        ];
    }

    /**
     * SMTP
     */
    public static function getSMTPAction()
    {
        global $_TRANSLATION;

        $object               = new _DB\SMTPSettings();
        $object->connSettings = [
            'key' => 'status'
        ];

        $objectDetails = $object->find(self::$defaultStatus);
        if (empty($objectDetails)):
            $newObject                = new _DB\SMTPSettings();
            $newObject->hostname      = '';
            $newObject->port          = 0;
            $newObject->username      = '';
            $newObject->password      = '';
            $newObject->noreply_email = '';
            $newObject->noreply_name  = '';
            $newObject->tls           = 0;
            $newObject->status        = 1;
            $newObject->create();
        endif;

        self::$_VIEW->object           = $objectDetails;
        self::$_VIEW->menu             = 'settings';
        self::$_VIEW->sMenu            = 'smtp_settings';
        self::$_VIEW->page_title       = $_TRANSLATION['website']['settings_smtp']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['website']['settings_smtp']['seo_description'];

        self::template('admin/smtp.php');
    }


    /**
     * Current Links
     */
    public static function getRoutingAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['route']) && !empty($_GET_VARIABLES['route'])):
            $filter['route'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['route'] . '%'
            ];
        endif;


        $objects     = new _DB\RoutingSystem();
        $objectsList = $objects->search([
                                            'fields' => $filter,
                                            'sort'   => [
                                                'rid' => 'desc'
                                            ]
                                        ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/settings/routing',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/settings/routing',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectsList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectsList
            ]
        );


        self::$_VIEW->menu             = 'settings';
        self::$_VIEW->sMenu            = 'routing_settings';
        self::$_VIEW->page_title       = $_TRANSLATION['website']['settings_routing']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['website']['settings_routing']['seo_description'];

        self::template('admin/routing.php');
    }

    /**
     * Post Management
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
                        'text' => $_TRANSLATION['website']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }


}