<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;

/**
 * Class Admin
 * @package _MODULE\PageBuilder
 */
class Admin extends _INIT
{
    private static $module = 'PageBuilder\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'PageBuilder';

    /**
     * Return a list with all groups
     */
    public static function getObjectsAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['group_name']) && !empty($_GET_VARIABLES['group_name'])):
            $filter['pbg_name'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['group_name'] . '%'
            ];
        endif;


        $objects     = new _DB\PageBuilderGroup();
        $objectsList = $objects->search(
            [
                'fields' => $filter,
                'sort'   => [
                    'pbid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectsList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectsList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object = new _DB\PageBuilderGroup();
            $delete = $object->search(
                [
                    'fields' => [
                        'pbid' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'groups';
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['list_group']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['list_group']['seo_description'];

        self::template('admin/groups.php');
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
            'content' => selfRender('PageBuilder', $page)
        ];
    }

    /**
     * Add a new group
     */
    public static function getAddGroupAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;


        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'groups';
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['add_group']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['add_group']['seo_description'];

        self::template('admin/group.php');
    }

    /**
     * Group Update
     */
    public static function getEditGroupAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PBID       = $_REQUEST_ID[0];

        $object        = new _DB\PageBuilderGroup();
        $objectDetails = $object->search(
            [
                'fields' => [
                    'pbid' => [
                        'type'  => '=',
                        'value' => $_PBID
                    ]
                ]
            ]);

        if (empty($objectDetails)):
            _ROUTE::_REDIRECT('admin/page-builder');
        endif;
        self::$_VIEW->object = $objectDetails[0];


        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'groups';
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['edit_group']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['edit_group']['seo_description'];

        self::template('admin/group.php');
    }


    /**
     * Group Export
     */
    public static function getExportGroupAction()
    {
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PBID       = $_REQUEST_ID[0];

        $object               = new _DB\PageBuilderGroup();
        $object->connSettings = [
            'select' => '`pbg_name`, `pbg_machine_name`, `pbg_description`',
        ];
        $objectDetails        = $object->find($_PBID);


        if (empty($objectDetails)):
            _ROUTE::_REDIRECT('admin/page-builder');
        endif;

        header('Content-disposition: attachment; filename=' . $objectDetails['pbg_machine_name'] . '.json');
        header('Content-type: application/json');

        /**
         * Widgets List
         */
        $widgetsObject               = new _DB\PageBuilderWidget();
        $widgetsObject->connSettings = [
            'select' => '`pbo_id`, `pbo_name`, `pbo_description`, `pbo_machine_name`, `pbo_repeater`',
        ];
        $widgetsList                 = $widgetsObject->search(
            [
                'fields' => [
                    'pbo_pbid' => [
                        'type'  => '=',
                        'value' => $_PBID
                    ]
                ]
            ]);
        $widgets                     = [];
        foreach ($widgetsList as $widget):
            /**
             * Fields List
             */
            $fieldsObject               = new _DB\PageBuilderField();
            $fieldsObject->connSettings = [
                'select' => '`pbol_type`, `pbol_name`, `pbol_machine_name`, `pbol_values`, `pbol_default_value`, `pbol_json`, `pbol_weight`',
            ];
            $fieldsList                 = $fieldsObject->search(
                [
                    'fields' => [
                        'pbol_pbo_id' => [
                            'type'  => '=',
                            'value' => $widget['pbo_id']
                        ]
                    ]
                ]);

            /**
             * Data Cleanup
             */
            unset($widget['pbo_id']);

            $widgets[$widget['pbo_machine_name']] = [
                'details' => $widget,
                'fields'  => $fieldsList
            ];
        endforeach;


        $json = [
            'group'   => $objectDetails,
            'widgets' => $widgets
        ];
        return json_encode($json, JSON_PRETTY_PRINT);
        exit(0);
    }


    /**
     * Add a new widget
     */
    public static function getAddObjectAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        /**
         * Load the current active groups
         */

        $objects     = new _DB\PageBuilderGroup();
        $objectsList = $objects->search(
            [
                'fields' => [
                    'pbg_status' => [
                        'type'  => '=',
                        'value' => 1
                    ]
                ],
                'sort'   => [
                    'pbid' => 'desc'
                ]
            ]);


        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'object';
        self::$_VIEW->objectsList      = $objectsList;
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['add_object']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['add_object']['seo_description'];

        self::template('admin/object.php');
    }


    /**
     * Return a list with all Widgets
     */
    public static function getListObjectsAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['name']) && !empty($_GET_VARIABLES['name'])):
            $filter['pbo_name'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['name'] . '%'
            ];
        endif;

        if (isset($_GET_VARIABLES['group']) && !empty($_GET_VARIABLES['group'])):
            if (isset($filter['pbo_name'])):
                $filter['condition'] = [
                    'value' => 'and'
                ];
            endif;

            $filter['pbo_pbid'] = [
                'type'  => '=',
                'value' => $_GET_VARIABLES['group']
            ];
        endif;


        $objects               = new _DB\PageBuilderWidget();
        $objects->connSettings = [
            'key' => 'pbo_pbid',
        ];
        $objectsList           = $objects->search(
            [
                'fields' => $filter,
                'join'   => [
                    'page_builder_group' => [
                        'mode'    => 'left join',
                        'table'   => 'page_builder_group',
                        'conn_id' => 'pbid',
                        'as'      => 'pbg'
                    ]
                ],
                'sort'   => [
                    'pbo_id' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder/objects',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder/objects',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectsList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectsList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object               = new _DB\PageBuilderWidget();
            $object->connSettings = [
                'key' => 'pbo_pbid',
            ];
            $delete               = $object->search(
                [
                    'fields' => [
                        'pbo_id' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        $groups     = new _DB\PageBuilderGroup();
        $groupsList = $groups->search(
            [
                'fields' => [
                    'pbg_status' => [
                        'type'  => '=',
                        'value' => 1
                    ]
                ],
                'sort'   => [
                    'pbg_name' => 'asc'
                ]
            ]);


        self::$_VIEW->groupsList       = $groupsList;
        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'objects';
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['list_widget']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['list_widget']['seo_description'];

        self::template('admin/objects.php');
    }

    /**
     * Object Update
     */
    public static function getEditObjectAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PBO_ID     = $_REQUEST_ID[0];

        $object        = new _DB\PageBuilderWidget();
        $objectDetails = $object->search(
            [
                'fields' => [
                    'pbo_id' => [
                        'type'  => '=',
                        'value' => $_PBO_ID
                    ]
                ]
            ]);

        if (empty($objectDetails)):
            _ROUTE::_REDIRECT('admin/page-builder');
        endif;
        self::$_VIEW->object = $objectDetails[0];

        /**
         * Load the current active groups
         */
        $objects     = new _DB\PageBuilderGroup();
        $objectsList = $objects->search(
            [
                'fields' => [
                    'pbg_status' => [
                        'type'  => '=',
                        'value' => 1
                    ]
                ],
                'sort'   => [
                    'pbid' => 'desc'
                ]
            ]);

        /**
         * PageBuilder Items
         */
        $items     = new _DB\PageBuilderField();
        $itemsList = $items->search(
            [
                'fields' => [
                    'pbol_pbo_id' => [
                        'type'  => '=',
                        'value' => $_PBO_ID
                    ]
                ],
                'sort'   => [
                    'pbol_weight' => 'asc'
                ]
            ]);
        $itemsHtml = [];
        foreach ($itemsList as $item):
            $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbol_type'];
            if (method_exists($_OBJECT_METHOD, 'html')):
                $_GENERATE_HTML = new $_OBJECT_METHOD;
                $itemsHtml[]    = $_GENERATE_HTML->html($item);
            endif;
        endforeach;

        self::$_VIEW->menu             = 'page_builder_management';
        self::$_VIEW->sMenu            = 'object';
        self::$_VIEW->objectsList      = $objectsList;
        self::$_VIEW->itemsHtml        = implode('', $itemsHtml);
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['edit_group']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['edit_group']['seo_description'];

        self::template('admin/object.php');
    }

}