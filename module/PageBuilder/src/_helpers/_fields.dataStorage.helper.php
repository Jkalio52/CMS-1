<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use _WKNT\_TIME;

/**
 * Class DataStorage
 * @package _MODULE\PageBuilder
 */
class DataStorage extends _INIT
{

    /**
     * @param $objectId
     */
    public static function store($objectId)
    {
        /**
         * Remove the old data
         */
        self::delete($objectId);

        /**
         * PageBuilder Data (read)
         */
        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        /**
         * Current Module
         */
        $module = _ROUTE::$_CURRENT_ROUTE['module'];

        if (isset($variables['page_builder'])):
            foreach ($variables['page_builder'] as $key => $groups):
                if (!empty($groups)):
                    foreach ($groups as $group):
                        if (!empty($group)):
                            /**
                             * Save the new data
                             */
                            $data                = new _DB\PageBuilderData();
                            $data->pbd_pbo_id    = $group['id'];
                            $data->pbd_module    = $module;
                            $data->pbd_object_id = $objectId;
                            $data->pbd_group     = $key;
                            $data->pbd_weight    = $group['weight'];
                            $data->pbd_created   = _TIME::_DATE_TIME()['_NOW'];
                            $dataCreate          = $data->create();

                            if (!empty($group['items'])):
                                foreach ($group['items'] as $parent => $item):

                                    if ($group['repeater']):
                                        /**
                                         * Got some friends, needs to set a parent id
                                         */
                                        foreach ($item as $itemGroup):
                                            $dataValue                  = new _DB\PageBuilderDataValues();
                                            $dataValue->pbdv_pbd_id     = $dataCreate['id'];
                                            $dataValue->pbdv_pbo_id     = $group['id'];
                                            $dataValue->pbdv_module     = $module;
                                            $dataValue->pbdv_object_id  = $objectId;
                                            $dataValue->pbdv_group      = $key;
                                            $dataValue->pbdv_parent     = $parent;
                                            $dataValue->pbdv_pbol_id    = $itemGroup['id'];
                                            $dataValue->pbdv_pbol_value = serialize($itemGroup['value']);
                                            $dataValue->create();
                                        endforeach;
                                    /**
                                     * Just a normal lonely group of fields
                                     */
                                    else:
                                        $dataValue                 = new _DB\PageBuilderDataValues();
                                        $dataValue->pbdv_pbd_id    = $dataCreate['id'];
                                        $dataValue->pbdv_pbo_id    = $group['id'];
                                        $dataValue->pbdv_module    = $module;
                                        $dataValue->pbdv_object_id = $objectId;
                                        $dataValue->pbdv_group     = $key;
//                                        $dataValue->pbdv_parent     = null;
                                        $dataValue->pbdv_pbol_id    = $item['id'];
                                        $dataValue->pbdv_pbol_value = serialize($item['value']);
                                        $dataValue->create();
                                    endif;

                                endforeach;
                            endif;
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;
    }

    /**
     * @param $objectId
     */
    public static function delete($objectId)
    {
        /**
         * Current Module
         */
        $module = _ROUTE::$_CURRENT_ROUTE['module'];

        /**
         * page_builder_data
         */
        $pbd       = new _DB\PageBuilderData();
        $pbdObject = $pbd->search(
            [
                'fields' => [
                    'pbd_module'    => [
                        'type'  => '=',
                        'value' => $module
                    ],
                    'condition_1'   => [
                        'value' => 'and'
                    ],
                    'pbd_object_id' => [
                        'type'  => '=',
                        'value' => $objectId
                    ]
                ]
            ]);

        /**
         * Remove from the page_builder_data table
         */
        if (!empty($pbdObject)):
            foreach ($pbdObject as $item):
                if (isset($item['pbd_id'])):
                    $del               = new _DB\PageBuilderData();
                    $del->connSettings = [
                        'delete_key'   => 'pbd_id',
                        'delete_value' => $item['pbd_id']
                    ];
                    $del->delete();
                endif;
            endforeach;
        endif;


        /**
         * page_builder_data_values
         */
        $pbdv       = new _DB\PageBuilderDataValues();
        $pbdvObject = $pbdv->search(
            [
                'fields' => [
                    'pbdv_module'    => [
                        'type'  => '=',
                        'value' => $module
                    ],
                    'condition_1'    => [
                        'value' => 'and'
                    ],
                    'pbdv_object_id' => [
                        'type'  => '=',
                        'value' => $objectId
                    ]
                ]
            ]);


        /**
         * Remove from the page_builder_data_values table
         */
        if (!empty($pbdvObject)):
            foreach ($pbdvObject as $item):
                if (isset($item['pbdv_id'])):
                    $del               = new _DB\PageBuilderDataValues();
                    $del->connSettings = [
                        'delete_key'   => 'pbdv_id',
                        'delete_value' => $item['pbdv_id']
                    ];
                    $del->delete();
                endif;
            endforeach;
        endif;
    }
}