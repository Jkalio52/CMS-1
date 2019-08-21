<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Pages;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class Admin
 * @package _MODULE\Pages
 */
class Admin extends _INIT
{
    private static $module = 'Pages\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'Pages';

    /**
     * Return a list with all pages
     */
    public static function getListAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['page_title']) && !empty($_GET_VARIABLES['page_title'])):
            $filter['page_title'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['page_title'] . '%'
            ];
        endif;


        $pages     = new _DB\Pages();
        $pagesList = $pages->search(
            [
                'fields' => $filter,
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'pd'
                    ]
                ],
                'sort'   => [
                    'pid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/pages',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/pages',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($pagesList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $pagesList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object = new _DB\Pages();
            $delete = $object->search(
                [
                    'fields' => [
                        'pid' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'pages_management';
        self::$_VIEW->sMenu            = 'pages';
        self::$_VIEW->page_title       = $_TRANSLATION['pages']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pages']['list']['seo_description'];

        self::template('admin/pages.php');
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
            'content' => selfRender('Pages', $page)
        ];
    }

    /**
     * Add a new page
     */
    public static function getAddAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;


        self::$_VIEW->menu             = 'pages_management';
        self::$_VIEW->sMenu            = 'pages_add';
        self::$_VIEW->pageTemplates    = self::availableTemplates();
        self::$_VIEW->page_title       = $_TRANSLATION['pages']['add']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pages']['add']['seo_description'];

        self::template('admin/page.php');
    }

    /**
     * @return array
     */
    private static function availableTemplates()
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        $templatesList = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . self::$templatesDirectory . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $_TEMPLATES    = [];
        foreach (glob($templatesList . "*.php") as $template):
            $templateName              = str_replace(
                [
                    '.php',
                    '-'
                ], [
                    '',
                    ' '
                ], $template);
            $templateName              = preg_replace('/[^A-Za-z0-9\-]/', ' ', basename($templateName));
            $_TEMPLATES[$templateName] = basename($template);
        endforeach;

        return $_TEMPLATES;
    }

    /**
     * Page update
     */
    public static function getEditAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PID        = $_REQUEST_ID[0];

        $page   = new _DB\Pages();
        $object = $page->search(
            [
                'fields' => [
                    'pid' => [
                        'type'  => '=',
                        'value' => $_PID
                    ]
                ],
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'up'
                    ]
                ]
            ]);

        if (empty($object)):
            _ROUTE::_REDIRECT('admin/pages');
        endif;
        self::$_VIEW->object = $object[0];


        self::$_VIEW->menu             = 'pages_management';
        self::$_VIEW->sMenu            = 'pages_update';
        self::$_VIEW->pageTemplates    = self::availableTemplates();
        self::$_VIEW->page_title       = $_TRANSLATION['pages']['edit']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pages']['edit']['seo_description'];

        self::template('admin/page.php');
    }

    /**
     * Page Delete
     */
    public static function getDeleteAction()
    {

        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PID        = $_REQUEST_ID[0];

        $page   = new _DB\Pages();
        $object = $page->search(
            [
                'fields' => [
                    'pid' => [
                        'type'  => '=',
                        'value' => $_PID
                    ]
                ],
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'up'
                    ]
                ]
            ]);
        if (empty($object)):
            _ROUTE::_REDIRECT('admin/pages');
        endif;
        self::$_VIEW->object = $object[0];


        self::$_VIEW->menu             = 'pages_management';
        self::$_VIEW->sMenu            = 'pages_update';
        self::$_VIEW->page_title       = $_TRANSLATION['pages']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pages']['list']['seo_description'];

        self::template('admin/page-delete.php');
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
                        'text' => $_TRANSLATION['pages']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}