<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder;

use _MODULE\_DB;
use _MODULE\Website;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use _WKNT\_TEMPLATE;
use Exception;

/**
 * Class _LOAD
 * @package _MODULE\PageBuilder
 */
class _LOAD extends _INIT
{

    /**
     * @param $_GROUP
     * @return string
     * @throws Exception
     */
    public static function execute($_GROUP)
    {
        $items = self::DataPrepare($_GROUP);
        return implode('', $items['htmlWidget']);
    }

    /**
     * @param bool $_GROUP
     * @return array
     * @throws Exception
     */
    public static function DataPrepare($_GROUP = false)
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        $_MODULE      = null;
        $_OBJECT_ID   = null;
        $widgetsArray = [];
        $htmlWidget   = [];

        if (_REQUEST::_IS_HOME()):
            /**
             * Load the front page details
             */
            $frontPage = Website::FrontPage();
            if (!empty($frontPage)):
                $_MODULE    = 'Pages';
                $_OBJECT_ID = isset($frontPage[0]['pid']) ? $frontPage[0]['pid'] : null;
            endif;
        else:
            $_CURRENT_ROUTE = _ROUTE::$_CURRENT_ROUTE;
            if (!empty($_CURRENT_ROUTE)):
                if (isset($_CURRENT_ROUTE['object'])):
                    $_MODULE    = $_CURRENT_ROUTE['object']['module'];
                    $_OBJECT_ID = $_CURRENT_ROUTE['object']['object_id'];
                endif;
            endif;
        endif;

        if (!empty($_MODULE) && !empty($_OBJECT_ID)):
            $widgets               = new _DB\PageBuilderData();
            $widgets->connSettings = [
                'key' => 'pbd_pbo_id',
            ];

            $fields = [
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
                ]
            ];
            if (!empty($_GROUP)):
                $fields['condition_2'] = [
                    'value' => 'and'
                ];
                $fields['pbd_group']   = [
                    'type'  => '=',
                    'value' => $_GROUP
                ];
            endif;


            $widgetsList = $widgets->search(
                [
                    'fields' => $fields,
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

                    $widgetsArray[$widget['pbd_group']]['group'] = [
                        'module'    => $widget['pbd_module'],
                        'container' => $widget['pbd_group']
                    ];
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

                    $fieldData = [];

                    /**
                     * Template Load & Reset
                     */
                    $_WIDGET_VIEW         = new _TEMPLATE();
                    $_WIDGET_VIEW->vars   = [];
                    $_WIDGET_VIEW->pbd_id = $widget['pbd_id'];

                    if ($widget['pbo_repeater']):
                        /**
                         * Group the items by using their widget parent id
                         * pbdv_parent
                         */
                        $repeaterList = [];
                        foreach ($fieldsList as $item):
                            $repeaterList[] = unserialize($item['pbdv_pbol_value']);
                            $fieldData[$item['pbdv_parent']][$item['pbol_machine_name']]
                                            = unserialize($item['pbdv_pbol_value']);
                        endforeach;

                        $_VARIABLE_NAME                = $widget['pbo_machine_name'];
                        $_WIDGET_VIEW->$_VARIABLE_NAME = $fieldData;

                    else:
                        foreach ($fieldsList as $item):
                            $_VARIABLE_NAME                = $item['pbol_machine_name'];
                            $_WIDGET_VIEW->$_VARIABLE_NAME = unserialize($item['pbdv_pbol_value']);
                            $fieldData[$widget['pbo_machine_name']][$item['pbol_machine_name']]
                                                           = unserialize($item['pbdv_pbol_value']);
                        endforeach;
                    endif;
                    $_WIDGET_VIEW->pageBuilderVars = $_WIDGET_VIEW->vars;
                    self::$_VIEW->pageBuilderVars  = $_WIDGET_VIEW->vars;

                    $widgetFile = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . 'pagebuilder' . DIRECTORY_SEPARATOR . $widget['pbo_machine_name'] . '.php';
                    if (file_exists($widgetFile)):
                        $htmlWidget[] = $_WIDGET_VIEW->render($widgetFile);
                    else:
                        echo "\n<!-- PageBuilder -->\n";
                        echo "<!-- Missing {$widget['pbo_machine_name']}.php -->\n";
                        echo "<!-- ./PageBuilder -->\n";
                    endif;

                    $widgetsArray[$widget['pbd_group']]['fields'][] = $fieldData;
                endforeach;
            endif;
        endif;
        return [
            'htmlWidget'   => $htmlWidget,
            'widgetsArray' => $widgetsArray,
        ];
    }
}