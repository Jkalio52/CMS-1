<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\_DB;
use _WKNT\_CRUD;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _OBJECT_UPDATE
 * @package _MODULE\PageBuilder\Admin
 */
class _OBJECT_UPDATE
{

    /**
     * Object Update
     */
    public static function execute()
    {
        global $_TRANSLATION;
        $data      = _REQUEST::_POST()['data'];
        $variables = _REQUEST::_VARIABLES($data);
        $errors    = _REQUEST::_VALIDATE(
            [
                'widget_name'         => ['not_empty'],
                'widget_machine_name' => ['not_empty'],
                'group'               => ['not_empty'],
            ], $variables);
        $objects   = isset($data['json_object']) ? json_decode($data['json_object']) : false;

        $pbo_id = isset($variables['pbo_id']) ? $variables['pbo_id'] : '';

        if (empty($errors)):

            /**
             * Widget Update
             */
            $variables['widget_machine_name'] = _SANITIZE::pageBuilder($variables['widget_machine_name']);
            $machineNameCount                 = self::machineNameCount($variables['widget_machine_name'], $pbo_id);
            $machine_name                     = ($machineNameCount > 0) ? $variables['widget_machine_name'] . '-' . ($machineNameCount - 1) : $variables['widget_machine_name'];

            $updateObject                   = new _DB\PageBuilderWidget();
            $updateObject->pbo_pbid         = $variables['group'];
            $updateObject->pbo_name         = $variables['widget_name'];
            $updateObject->pbo_description  = $variables['widget_description'];
            $updateObject->pbo_machine_name = $machine_name;
            $updateObject->pbo_repeater     = isset($variables['object_repeater']) ? 1 : 0;
            $updateObject->pbo_created      = _TIME::_DATE_TIME()['_NOW'];
            $updateObject->pbo_updated      = _TIME::_DATE_TIME()['_NOW'];
            $updateObject->pbo_status       = isset($variables['object_status']) ? 1 : 0;
            $updateObject->save($pbo_id);

            /**
             * Set all the fields as deleted,
             * and use the update function to remove the delete status
             */
            $objectsUpdate               = new _DB\PageBuilderField();
            $objectsUpdate->connSettings = [
                'key' => 'pbol_pbo_id',
            ];
            $objectsUpdate->pbol_deleted = 1;

            $objectsUpdate->save($pbo_id);

            if (!empty($objects)):

                foreach ($objects as $object):
                    $fieldUpdate                     = new _DB\PageBuilderField();
                    $fieldUpdate->pbol_type          = $object->json->object;
                    $fieldUpdate->pbol_name          = $object->json->name;
                    $fieldUpdate->pbol_machine_name  = $object->json->machine_name;
                    $fieldUpdate->pbol_values        = '';
                    $fieldUpdate->pbol_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                    $fieldUpdate->pbol_json          = json_encode($object->json);
                    $fieldUpdate->pbol_weight        = $object->weight;
                    $fieldUpdate->pbol_updated       = _TIME::_DATE_TIME()['_NOW'];
                    $fieldUpdate->pbol_deleted       = 0;
                    /**
                     * If this field doesn't exists, just add it to the databse
                     */
                    if (!$fieldUpdate->save($object->json->tempID)):
                        $fieldAdd                     = new _DB\PageBuilderField();
                        $fieldAdd->pbol_type          = $object->json->object;
                        $fieldAdd->pbol_name          = $object->json->name;
                        $fieldAdd->pbol_machine_name  = $object->json->machine_name;
                        $fieldAdd->pbol_values        = '';
                        $fieldAdd->pbol_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                        $fieldAdd->pbol_json          = json_encode($object->json);
                        $fieldAdd->pbol_weight        = $object->weight;
                        $fieldAdd->pbol_updated       = _TIME::_DATE_TIME()['_NOW'];
                        $fieldAdd->pbol_deleted       = 0;
                        $fieldAdd->pbol_pbo_id        = $pbo_id;
                        $fieldAdd->pbol_created       = _TIME::_DATE_TIME()['_NOW'];
                        $fieldId                      = $fieldAdd->create();

                        /**
                         * Add this as a new row into the page_builder_data_values table
                         */
                        $pbd       = new _DB\PageBuilderData();
                        $pbdObject = $pbd->search(
                            [
                                'fields' => [
                                    'pbd_pbo_id' => [
                                        'type'  => '=',
                                        'value' => $pbo_id
                                    ]
                                ]
                            ]);
                        if (!empty($pbdObject)):
                            /**
                             * Add this field, as a new empty field so it will be displayed on the admin
                             */
                            foreach ($pbdObject as $item):
                                $dataValue                  = new _DB\PageBuilderDataValues();
                                $dataValue->pbdv_pbd_id     = $item['pbd_id'];
                                $dataValue->pbdv_pbo_id     = $pbo_id;
                                $dataValue->pbdv_module     = $item['pbd_module'];
                                $dataValue->pbdv_object_id  = $item['pbd_object_id'];
                                $dataValue->pbdv_group      = $item['pbd_group'];
                                $dataValue->pbdv_parent     = 0;
                                $dataValue->pbdv_pbol_id    = $fieldId['id'];
                                $dataValue->pbdv_pbol_value = serialize('');
                                $dataValue->create();
                            endforeach;
                        endif;

                    endif;
                endforeach;
            endif;

            /**
             * Fields Cleanup
             */

            $items     = new _DB\PageBuilderField();
            $itemsList = $items->search(
                [
                    'fields' => [
                        'pbol_deleted' => [
                            'type'  => '=',
                            'value' => 1
                        ]
                    ]
                ]);

            if (!empty($itemsList)):
                $del = new _CRUD();
                foreach ($itemsList as $item):
                    $pbdv       = new _DB\PageBuilderDataValues();
                    $pbdvObject = $pbdv->search(
                        [
                            'fields' => [
                                'pbdv_pbo_id'  => [
                                    'type'  => '=',
                                    'value' => $pbo_id
                                ],
                                'condition_1'  => [
                                    'value' => 'and'
                                ],
                                'pbdv_pbol_id' => [
                                    'type'  => '=',
                                    'value' => $item['pbol_id']
                                ]
                            ]
                        ]);

                    if (!empty($pbdvObject)):
                        foreach ($pbdvObject as $toDelete):
                            $del->deleteFrom('page_builder_data_values', 'pbdv_id', $toDelete['pbdv_id']);
                        endforeach;
                    endif;

                endforeach;
            endif;

            $del               = new _DB\PageBuilderField();
            $del->connSettings = [
                'delete_key'   => 'pbol_deleted',
                'delete_value' => 1
            ];
            $del->delete();

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['pagebuilder']['updated_object']
                    ]
                ]);

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['pagebuilder']['errors']
                    ],
                    'redirect' => false
                ]);
        endif;
        return false;
    }

    /**
     * @param $machineName
     * @param $id
     * @return int
     */
    private static function machineNameCount($machineName, $id)
    {

        /**
         * Validate the machine name
         */
        $object              = new _DB\PageBuilderWidget();
        $machineNameValidate = $object->search(
            [
                'fields' => [
                    'pbo_machine_name' => [
                        'type'  => '=',
                        'value' => $machineName
                    ],
                    'condition'        => [
                        'value' => 'and'
                    ],
                    'pbo_id'           => [
                        'type'  => '!=',
                        'value' => $id
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($machineNameValidate)) {
            $machineNameValidate = $object->search(
                [
                    'fields' => [
                        'pbo_machine_name' => [
                            'type'  => '=',
                            'value' => $machineName . '-' . $objectNumber
                        ],
                        'condition'        => [
                            'value' => 'and'
                        ],
                        'pbo_id'           => [
                            'type'  => '!=',
                            'value' => $id
                        ]
                    ]
                ]);
            $objectNumber++;
        }

        return $objectNumber;
    }
}