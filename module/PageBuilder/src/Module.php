<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;


use _MODULE\PageBuilder\Admin\_LOAD_OBJECT;
use _MODULE\PageBuilder\DataStorage;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class PageBuilder
 * @package _MODULE
 */
class PageBuilder extends _INIT
{

    public static $module = 'PageBuilder',
        $moduleAdmin = 'PageBuilder\Admin',
        $_HTML_FIELDS = [];

    /**
     * @return mixed
     */
    public static function modal()
    {

        /**
         * Load the current active groups
         */
        $objects                  = new _DB\PageBuilderGroup();
        $objectsList              = $objects->search(
            [
                'fields' => [
                    'pbg_status' => [
                        'type'  => '=',
                        'value' => 1
                    ]
                ],
                'sort'   => [
                    'pbid' => 'asc'
                ]
            ]);
        self::$_VIEW->objectsList = $objectsList;

        return selfRender(self::$module, 'modal.php');
    }

    /**
     * @param bool $contentBuilder
     * @return mixed
     */
    public static function objectBuilderModal($contentBuilder = true)
    {

        self::$_VIEW->widgets = $contentBuilder ? self::fields() : self::fieldsForm();
        return selfRender(self::$module, 'objectBuilderModal.php');
    }

    /**
     * @return array
     */
    public static function fields()
    {
        return [
            '_INPUT'       => [
                'name'  => 'Input',
                'class' => 'widget'
            ],
            '_SELECT'      => [
                'name'  => 'Select',
                'class' => 'widget'
            ],
            '_TEXTAREA'    => [
                'name'  => 'Textarea',
                'class' => 'widget'
            ],
            '_TEXT_EDITOR' => [
                'name'  => 'Text Editor',
                'class' => 'widget'
            ],
            '_LINK'        => [
                'name'  => 'Link',
                'class' => 'widget'
            ],
            '_IMAGE'       => [
                'name'  => 'Image',
                'class' => 'widget'
            ],
            '_GALLERY'     => [
                'name'  => 'Gallery',
                'class' => 'widget'
            ],
            '_FILE'        => [
                'name'  => 'File',
                'class' => 'widget'
            ],
            '_CHECKBOX'    => [
                'name'  => 'Checkbox',
                'class' => 'widget'
            ],
            '_RADIO'       => [
                'name'  => 'Radio',
                'class' => 'widget'
            ],
        ];
    }

    /**
     * @return array
     */
    public static function fieldsForm()
    {
        return [
            '_INPUT'       => [
                'name'  => 'Input',
                'class' => 'widget'
            ],
            '_SELECT'      => [
                'name'  => 'Select',
                'class' => 'widget'
            ],
            '_TEXTAREA'    => [
                'name'  => 'Textarea',
                'class' => 'widget'
            ],
            '_TEXT_EDITOR' => [
                'name'  => 'Text Editor',
                'class' => 'widget'
            ],
            '_LINK'        => [
                'name'  => 'Link',
                'class' => 'widget'
            ],
            '_CHECKBOX'    => [
                'name'  => 'Checkbox',
                'class' => 'widget'
            ],
            '_RADIO'       => [
                'name'  => 'Radio',
                'class' => 'widget'
            ],
        ];
    }

    /**
     * @param $_DATA
     * @return mixed
     */
    public static function widget($_DATA)
    {
        $_GROUP           = isset($_DATA['group']) ? $_DATA['group'] : 'default';
        $_REQUEST_ID      = _REQUEST::_REQUEST_ID();
        $_OBJECT_ID       = isset($_REQUEST_ID['0']) ? $_REQUEST_ID['0'] : false;
        $_MODULE          = _ROUTE::$_CURRENT_ROUTE['module'];
        $_CURRENT_WIDGETS = [];
        if ($_OBJECT_ID):
            /**
             * Based on this id, we'll generate the widgets
             */

            $widgets               = new _DB\PageBuilderData();
            $widgets->connSettings = [
                'key' => 'pbd_pbo_id',
            ];
            $widgetsList           = $widgets->search(
                [
                    'fields' => [
                        'pbd_module'    => [
                            'type'  => '=',
                            'value' => $_MODULE
                        ],
                        'condition_1'   => [
                            'value' => 'and'
                        ],
                        'pbd_object_id' => [
                            'type'  => '=',
                            'value' => $_OBJECT_ID
                        ],
                        'condition_2'   => [
                            'value' => 'and'
                        ],
                        'pbd_group'     => [
                            'type'  => '=',
                            'value' => $_GROUP
                        ]
                    ],
                    'join'   => [
                        'page_builder_object' => [
                            'mode'    => 'left join',
                            'table'   => 'page_builder_object',
                            'conn_id' => 'pbo_id',
                            'as'      => 'pbo'
                        ]
                    ],
                    'sort'   => [
                        'pbd_weight' => 'asc'
                    ]
                ]);

            if (!empty($widgetsList)):
                foreach ($widgetsList as $widget):
                    $itemsHtml = [];
                    /**
                     * Generate a list with the fields based on the widget id and also add the value
                     */
                    $fields               = new _DB\PageBuilderField();
                    $fields->connSettings = [
                        'key' => 'pbol_id',
                    ];
                    $fieldsList           = $fields->search(
                        [
                            'fields' => [
                                'pbol_pbo_id'    => [
                                    'type'  => '=',
                                    'value' => $widget['pbo_id']
                                ],
                                'condition_1'    => [
                                    'value' => 'and'
                                ],
                                'pbdv_pbd_id'    => [
                                    'type'  => '=',
                                    'value' => $widget['pbd_id']
                                ],
                                'condition_2'    => [
                                    'value' => 'and'
                                ],
                                'pbdv_module'    => [
                                    'type'  => '=',
                                    'value' => $_MODULE
                                ],
                                'condition_3'    => [
                                    'value' => 'and'
                                ],
                                'pbdv_object_id' => [
                                    'type'  => '=',
                                    'value' => $_OBJECT_ID
                                ],
                            ],
                            'join'   => [
                                'page_builder_data_values' => [
                                    'mode'    => 'left join',
                                    'table'   => 'page_builder_data_values',
                                    'conn_id' => 'pbdv_pbol_id',
                                    'as'      => 'pbdv'
                                ]
                            ],
                            'sort'   => [
                                'pbol_weight' => 'asc'
                            ]
                        ]);

                    if ($widget['pbo_repeater']):
                        /**
                         * Group the items by using their widget parent id
                         * pbdv_parent
                         */
                        foreach ($fieldsList as $item):
                            $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbol_type'];
                            if (method_exists($_OBJECT_METHOD, 'html')):
                                $_GENERATE_HTML = new $_OBJECT_METHOD;

                                $item                              = self::jsonOverwrite($item);
                                $itemsHtml[$item['pbdv_parent']][] = $_GENERATE_HTML->html($item, false, ['unique_id' => $item['pbdv_id']]);
                            endif;
                        endforeach;

                        PageBuilder::$_VIEW->itemsHtml   = $itemsHtml;
                        PageBuilder::$_VIEW->itemDetails = $widget;
                        PageBuilder::$_VIEW->emptyWidget = _LOAD_OBJECT::emptyObject($widget['pbo_id']);

                        $_CURRENT_WIDGETS[] = selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'widget.php');
                    else:
                        foreach ($fieldsList as $item):
                            $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbol_type'];
                            if (method_exists($_OBJECT_METHOD, 'html')):
                                $_GENERATE_HTML = new $_OBJECT_METHOD;

                                $item        = self::jsonOverwrite($item);
                                $itemsHtml[] = $_GENERATE_HTML->html($item, false, ['unique_id' => $item['pbdv_id']]);
                            endif;
                        endforeach;
                        PageBuilder::$_VIEW->itemsHtml   = $itemsHtml;
                        PageBuilder::$_VIEW->itemDetails = $widget;
                        $_CURRENT_WIDGETS[]              = selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'widget.php');
                    endif;
                endforeach;
            endif;

        endif;

        /**
         * Get the current widgets based on group and object id
         */

        self::$_VIEW->group   = $_GROUP;
        self::$_VIEW->widgets = $_CURRENT_WIDGETS;
        return selfRender(self::$module, 'widget.php');
    }

    /**
     * @param $object
     * @return mixed
     */
    public static function jsonOverwrite($object)
    {
        $value      = unserialize($object['pbdv_pbol_value']);
        $objectJson = json_decode($object['pbol_json'], true);

        switch ($object['pbol_type']):
            case '_INPUT':
            case '_TEXTAREA':
            case '_GALLERY':
            case '_CHECKBOX':
            case '_SELECT':
            case '_TEXT_EDITOR':
            case '_IMAGE':
            case '_FILE':
            case '_RADIO':
                $objectJson['default_value'] = $value;
                break;

            case '_LINK':
                $objectJson['default_value']        = $value['title'];
                $objectJson['default_value_link']   = $value['href'];
                $objectJson['default_value_target'] = $value['target'];
                break;

        endswitch;
        $object['pbol_json'] = json_encode($objectJson);
        return $object;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function cleanString($string)
    {
        return preg_replace("/\r|\n/", "", trim($string));
    }

    /**
     * @param $objectId
     */
    public static function store($objectId)
    {
        DataStorage::store($objectId);
    }

    /**
     * @param $objectId
     */
    public static function delete($objectId)
    {
        DataStorage::delete($objectId);
    }

    /**
     * Post Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;
        $data_id = isset(_REQUEST::_POST()['data_id']) ? _REQUEST::_POST()['data_id'] : '';
        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$moduleAdmin . '\\' . $data_id;

        if (method_exists('\\_MODULE\\' . self::$moduleAdmin . '\\' . $data_id, 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['pagebuilder']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }
}