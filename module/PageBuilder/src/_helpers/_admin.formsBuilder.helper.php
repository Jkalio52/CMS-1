<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\FormsBuilder;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;

/**
 * Class Admin
 * @package _MODULE\FormsBuilder
 */
class Admin extends _INIT
{
    private static $module = 'FormsBuilder\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'PageBuilder';

    /**
     * Add a new form
     */
    public static function getAddObjectAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;


        self::$_VIEW->menu             = 'forms_management';
        self::$_VIEW->sMenu            = 'forms_add';
        self::$_VIEW->page_title       = $_TRANSLATION['forms']['add']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['forms']['add']['seo_description'];

        self::template('admin/form.php');
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
     * Return a list with all Widgets
     */
    public static function getListObjectsAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['name']) && !empty($_GET_VARIABLES['name'])):
            $filter['pbf_name'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['name'] . '%'
            ];
        endif;

        $objects     = new _DB\PageBuilderForm();
        $objectsList = $objects->search(
            [
                'fields' => $filter,
                'sort'   => [
                    'pbf_id' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms',
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
            $object               = new _DB\PageBuilderForm();
            $object->connSettings = [
                'key' => 'pbf_pbid',
            ];
            $delete               = $object->search(
                [
                    'fields' => [
                        'pbf_id' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'forms_management';
        self::$_VIEW->sMenu            = 'forms';
        self::$_VIEW->page_title       = $_TRANSLATION['forms']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['forms']['list']['seo_description'];

        self::template('admin/forms.php');
    }


    /**
     * Form Update
     */
    public static function getEditObjectAction()
    {
        global $_TRANSLATION;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_PBO_ID     = $_REQUEST_ID[0];

        $object        = new _DB\PageBuilderForm();
        $objectDetails = $object->search(
            [
                'fields' => [
                    'pbf_id' => [
                        'type'  => '=',
                        'value' => $_PBO_ID
                    ]
                ]
            ]);

        if (empty($objectDetails)):
            _ROUTE::_REDIRECT('admin/forms');
        endif;
        self::$_VIEW->object = $objectDetails[0];

        /**
         * PageBuilder Items
         */
        $items     = new _DB\PageBuilderFormFields();
        $itemsList = $items->search(
            [
                'fields' => [
                    'pbff_pbf_id' => [
                        'type'  => '=',
                        'value' => $_PBO_ID
                    ]
                ],
                'sort'   => [
                    'pbff_weight' => 'asc'
                ]
            ]);
        $itemsHtml = [];
        foreach ($itemsList as $item):
            $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbff_type'];
            if (method_exists($_OBJECT_METHOD, 'html')):
                $_GENERATE_HTML = new $_OBJECT_METHOD;
                $itemsHtml[]    = $_GENERATE_HTML->html($item);
            endif;
        endforeach;

        self::$_VIEW->menu             = 'forms_management';
        self::$_VIEW->sMenu            = 'forms_add';
        self::$_VIEW->itemsHtml        = implode('', $itemsHtml);
        self::$_VIEW->page_title       = $_TRANSLATION['pagebuilder']['edit_group']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['pagebuilder']['edit_group']['seo_description'];

        self::template('admin/form.php');
    }


    public function getFormDataAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;
        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $_REQUEST_ID    = _REQUEST::_REQUEST_ID();
        $_ID            = $_REQUEST_ID[0];

        /**
         * Headings
         */
        $form     = new _DB\PageBuilderForm();
        $headings = $form->search(
            [
                'fields' => [
                    'pbf_id' => [
                        'type'  => '=',
                        'value' => $_ID
                    ]
                ],
                'join'   => [
                    'page_builder_forms_fields' => [
                        'mode'    => 'left join',
                        'table'   => 'page_builder_forms_fields',
                        'conn_id' => 'pbff_pbf_id',
                        'as'      => 'pbff'
                    ]
                ],
                'sort'   => [
                    'pbff_weight' => 'asc'
                ]
            ]);

        $headingsList = [];
        $emptyRow     = [];
        foreach ($headings as $heading):
            $headingsList[$heading['pbff_id']] = $heading['pbff_name'];
            $emptyRow[$heading['pbff_id']]     = '';
        endforeach;
        self::$_VIEW->headingsList = $headingsList;

        $recordsFilter = [];
        if (!empty($headings)):
            $objects     = new _DB\PageBuilderFormsData();
            $objectsList = $objects->search(
                [
                    'fields' => [
                        'pbfd_pbf_id' => [
                            'type'  => '=',
                            'value' => $_ID
                        ]
                    ],
                    'join'   => [
                        'page_builder_forms_data_values' => [
                            'mode'    => 'left join',
                            'table'   => 'page_builder_forms_data_values',
                            'conn_id' => 'pbfdv_pbf_id',
                            'as'      => 'pbfdv'
                        ]
                    ],
                    'sort'   => [
                        'pbfd_pbf_id' => 'desc'
                    ]
                ]);

            foreach ($objectsList as $record):
                $recordsFilter[$record['pbfd_id']][] = [
                    'pbfd_id'          => $record['pbfd_id'],
                    'pbfdv_pbff_id'    => $record['pbfdv_pbff_id'],
                    'pbfdv_pbff_value' => $record['pbfdv_pbff_value'],
                    'pbfd_created'     => $record['pbfd_created'],
                ];
            endforeach;

            $finalList = [];
            foreach ($recordsFilter as $key => $item):
                $newItem            = $emptyRow;
                $newItem['created'] = '';
                foreach ($item as $data):
                    $newItem[$data['pbfdv_pbff_id']] = $data['pbfdv_pbff_value'];
                    $newItem['created']              = $data['pbfd_created'];
                    $newItem['record_id']            = $data['pbfd_id'];
                endforeach;
                $finalList[$key] = $newItem;
            endforeach;
        endif;

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms/records/' . $_ID,
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms/records/' . $_ID,
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($finalList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $finalList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object               = new _DB\PageBuilderForm();
            $object->connSettings = [
                'key' => 'pbf_pbid',
            ];
            $delete               = $object->search(
                [
                    'fields' => [
                        'pbf_id' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object               = new _DB\PageBuilderFormsData();
            $object->connSettings = [
                'key' => 'pbfd_id',
            ];
            $delete               = $object->search(
                [
                    'fields' => [
                        'pbfd_id' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'forms_management';
        self::$_VIEW->sMenu            = 'forms';
        self::$_VIEW->formId           = $_ID;
        self::$_VIEW->page_title       = $_TRANSLATION['forms']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['forms']['list']['seo_description'];

        self::template('admin/records.php');
    }
}