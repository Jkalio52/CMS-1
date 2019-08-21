<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\_DB;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _FORM_UPDATE
 * @package _MODULE\PageBuilder\Admin
 */
class _FORM_UPDATE
{

    /**
     * Form Update
     */
    public static function execute()
    {
        global $_TRANSLATION;
        $data      = _REQUEST::_POST()['data'];
        $variables = _REQUEST::_VARIABLES($data);
        $errors    = _REQUEST::_VALIDATE(
            [
                'form_name'         => ['not_empty'],
                'form_machine_name' => ['not_empty'],
                'form_button_name'  => ['not_empty'],
                'form_message'      => ['not_empty'],
            ], $variables);
        $objects   = isset($data['json_object']) ? json_decode($data['json_object']) : false;

        $pbf_id = isset($variables['pbf_id']) ? $variables['pbf_id'] : '';


        if (empty($errors)):

            /**
             * Widget Update
             */
            $variables['form_machine_name']        = _SANITIZE::pageBuilder($variables['form_machine_name']);
            $machineNameCount                      = self::machineNameCount($variables['form_machine_name'], $pbf_id);
            $machine_name                          = ($machineNameCount > 0) ? $variables['form_machine_name'] . '-' . ($machineNameCount - 1) : $variables['form_machine_name'];
            $updateObject                          = new _DB\PageBuilderForm();
            $updateObject->pbf_name                = $variables['form_name'];
            $updateObject->pbf_description         = $variables['form_description'];
            $updateObject->pbf_notification_emails = isset($variables['form_emails']) ? $variables['form_emails'] : '';
            $updateObject->pbf_button_name         = isset($variables['form_button_name']) ? $variables['form_button_name'] : '';
            $updateObject->pbf_message             = isset($variables['form_message']) ? $variables['form_message'] : '';
            $updateObject->pbf_recaptcha           = isset($variables['form_recaptcha']) ? 1 : 0;
            $updateObject->pbf_machine_name        = $machine_name;
            $updateObject->pbf_repeater            = isset($variables['object_repeater']) ? 1 : 0;
            $updateObject->pbf_created             = _TIME::_DATE_TIME()['_NOW'];
            $updateObject->pbf_updated             = _TIME::_DATE_TIME()['_NOW'];
            $updateObject->pbf_status              = isset($variables['object_status']) ? 1 : 0;
            $updateObject->save($pbf_id);

            /**
             * Set all the fields as deleted,
             * and use the update function to remove the delete status
             */
            $objectsUpdate               = new _DB\PageBuilderFormFields();
            $objectsUpdate->connSettings = [
                'key' => 'pbff_pbf_id',
            ];
            $objectsUpdate->pbff_deleted = 1;
            $objectsUpdate->save($pbf_id);

            if (!empty($objects)):

                foreach ($objects as $object):
                    $fieldUpdate                     = new _DB\PageBuilderFormFields();
                    $fieldUpdate->pbff_type          = $object->json->object;
                    $fieldUpdate->pbff_name          = $object->json->name;
                    $fieldUpdate->pbff_machine_name  = $object->json->machine_name;
                    $fieldUpdate->pbff_values        = '';
                    $fieldUpdate->pbff_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                    $fieldUpdate->pbff_json          = json_encode($object->json);
                    $fieldUpdate->pbff_weight        = $object->weight;
                    $fieldUpdate->pbff_updated       = _TIME::_DATE_TIME()['_NOW'];
                    $fieldUpdate->pbff_deleted       = 0;
                    /**
                     * If this field doesn't exists, just add it to the databse
                     */
                    if (!$fieldUpdate->save($object->json->tempID)):
                        $fieldAdd                     = new _DB\PageBuilderFormFields();
                        $fieldAdd->pbff_type          = $object->json->object;
                        $fieldAdd->pbff_name          = $object->json->name;
                        $fieldAdd->pbff_machine_name  = $object->json->machine_name;
                        $fieldAdd->pbff_values        = '';
                        $fieldAdd->pbff_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                        $fieldAdd->pbff_json          = json_encode($object->json);
                        $fieldAdd->pbff_weight        = $object->weight;
                        $fieldAdd->pbff_updated       = _TIME::_DATE_TIME()['_NOW'];
                        $fieldAdd->pbff_deleted       = 0;
                        $fieldAdd->pbff_pbf_id        = $pbf_id;
                        $fieldAdd->pbff_created       = _TIME::_DATE_TIME()['_NOW'];
                        $fieldAdd->create();
                    endif;
                endforeach;
            endif;

            /**
             * Fields Cleanup
             */
            $del               = new _DB\PageBuilderFormFields();
            $del->connSettings = [
                'delete_key'   => 'pbff_deleted',
                'delete_value' => 1
            ];
            $del->delete();

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['forms']['updated']
                    ]
                ]);

        else:
            return json_encode(
                [
                    'errors'   => $errors,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['forms']['errors']
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
        $object              = new _DB\PageBuilderForm();
        $machineNameValidate = $object->search(
            [
                'fields' => [
                    'pbf_machine_name' => [
                        'type'  => '=',
                        'value' => $machineName
                    ],
                    'condition'        => [
                        'value' => 'and'
                    ],
                    'pbf_id'           => [
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
                        'pbf_machine_name' => [
                            'type'  => '=',
                            'value' => $machineName . '-' . $objectNumber
                        ],
                        'condition'        => [
                            'value' => 'and'
                        ],
                        'pbf_id'           => [
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