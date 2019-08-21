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
 * Class _OBJECT_CREATE
 * @package _MODULE\PageBuilder\Admin
 */
class _OBJECT_CREATE
{

    /**
     * Create a new object
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

        if (empty($errors)):

            /**
             * Create a new widget
             */
            $variables['widget_machine_name'] = _SANITIZE::pageBuilder($variables['widget_machine_name']);
            $machineNameCount                 = self::machineNameCount($variables['widget_machine_name']);
            $machine_name                     = ($machineNameCount > 0) ? $variables['widget_machine_name'] . '-' . ($machineNameCount - 1) : $variables['widget_machine_name'];

            $newObject                   = new _DB\PageBuilderWidget();
            $newObject->pbo_pbid         = isset($variables['group']) ? $variables['group'] : '';
            $newObject->pbo_name         = isset($variables['widget_name']) ? $variables['widget_name'] : '';
            $newObject->pbo_description  = isset($variables['widget_description']) ? $variables['widget_description'] : '';
            $newObject->pbo_machine_name = $machine_name;
            $newObject->pbo_repeater     = isset($variables['object_repeater']) ? 1 : 0;
            $newObject->pbo_created      = _TIME::_DATE_TIME()['_NOW'];
            $newObject->pbo_updated      = _TIME::_DATE_TIME()['_NOW'];
            $newObject->pbo_status       = isset($variables['object_status']) ? 1 : 0;
            $widget                      = $newObject->create();

            if (!empty($objects)):
                foreach ($objects as $object):
                    $field                     = new _DB\PageBuilderField();
                    $field->pbol_pbo_id        = $widget['id'];
                    $field->pbol_type          = isset($object->json->object) ? $object->json->object : '';
                    $field->pbol_name          = isset($object->json->name) ? $object->json->name : '';
                    $field->pbol_machine_name  = isset($object->json->machine_name) ? $object->json->machine_name : '';
                    $field->pbol_values        = '';
                    $field->pbol_default_value = isset($object->json->default_value) ? $object->json->default_value : '';
                    $field->pbol_json          = json_encode($object->json);
                    $field->pbol_weight        = isset($object->weight) ? $object->weight : 0;
                    $field->pbol_created       = _TIME::_DATE_TIME()['_NOW'];
                    $field->pbol_updated       = _TIME::_DATE_TIME()['_NOW'];
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
                        'text' => $_TRANSLATION['pagebuilder']['created_object']
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
                        'text' => $_TRANSLATION['pagebuilder']['errors']
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
        $object              = new _DB\PageBuilderWidget();
        $machineNameValidate = $object->search(
            [
                'fields' => [
                    'pbo_machine_name' => [
                        'type'  => '=',
                        'value' => $machineName
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($machineNameValidate)) {
            $object              = new _DB\PageBuilderWidget();
            $machineNameValidate = $object->search(
                [
                    'fields' => [
                        'pbo_machine_name' => [
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