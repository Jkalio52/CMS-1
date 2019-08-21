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
 * Class _FORM_CREATE
 * @package _MODULE\PageBuilder\Admin
 */
class _FORM_CREATE
{

    /**
     * Create a new Form
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


        if (empty($errors)):

            /**
             * Create a new widget
             */
            $variables['form_machine_name'] = _SANITIZE::pageBuilder($variables['form_machine_name']);
            $machineNameCount               = self::machineNameCount($variables['form_machine_name']);
            $machine_name                   = ($machineNameCount > 0) ? $variables['form_machine_name'] . '-' . ($machineNameCount - 1) : $variables['form_machine_name'];

            $newObject                          = new _DB\PageBuilderForm();
            $newObject->pbf_name                = isset($variables['form_name']) ? $variables['form_name'] : '';
            $newObject->pbf_description         = isset($variables['form_description']) ? $variables['form_description'] : '';
            $newObject->pbf_notification_emails = isset($variables['form_emails']) ? $variables['form_emails'] : '';
            $newObject->pbf_button_name         = isset($variables['form_button_name']) ? $variables['form_button_name'] : '';
            $newObject->pbf_message             = isset($variables['form_message']) ? $variables['form_message'] : '';
            $newObject->pbf_recaptcha           = isset($variables['form_recaptcha']) ? 1 : 0;
            $newObject->pbf_machine_name        = $machine_name;
            $newObject->pbf_repeater            = isset($variables['object_repeater']) ? 1 : 0;
            $newObject->pbf_created             = _TIME::_DATE_TIME()['_NOW'];
            $newObject->pbf_updated             = _TIME::_DATE_TIME()['_NOW'];
            $newObject->pbf_status              = isset($variables['object_status']) ? 1 : 0;
            $widget                             = $newObject->create();

            if (!empty($objects)):
                foreach ($objects as $object):
                    $field                     = new _DB\PageBuilderFormFields();
                    $field->pbff_pbf_id        = $widget['id'];
                    $field->pbff_type          = isset($object->json->object) ? $object->json->object : '';
                    $field->pbff_name          = isset($object->json->name) ? $object->json->name : '';
                    $field->pbff_machine_name  = isset($object->json->machine_name) ? $object->json->machine_name : '';
                    $field->pbff_values        = '';
                    $field->pbff_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                    $field->pbff_json          = json_encode($object->json);
                    $field->pbff_weight        = isset($object->weight) ? $object->weight : 0;
                    $field->pbff_created       = _TIME::_DATE_TIME()['_NOW'];
                    $field->pbff_updated       = _TIME::_DATE_TIME()['_NOW'];
                    $field->create();
                endforeach;
            endif;


            /**
             * Store each field as a separated database row
             */

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['forms']['created']
                    ],
                    'action'  => [
                        'function'  => 'clearAll',
                        'arguments' => ''
                    ],
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
    }

    /**
     * @param $machineName
     * @return int
     */
    private static function machineNameCount($machineName)
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
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($machineNameValidate)) {
            $object              = new _DB\PageBuilderForm();
            $machineNameValidate = $object->search(
                [
                    'fields' => [
                        'pbf_machine_name' => [
                            'type'  => '=',
                            'value' => $machineName . '-' . $objectNumber
                        ]
                    ]
                ]);
            $objectNumber++;
        }

        return $objectNumber;
    }
}