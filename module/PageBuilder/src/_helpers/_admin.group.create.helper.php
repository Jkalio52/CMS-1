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
 * Class _GROUP_CREATE
 * @package _MODULE\PageBuilder\Admin
 */
class _GROUP_CREATE
{

    /**
     * Create a new group
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $errors    = _REQUEST::_VALIDATE(
            [
                'group_name'   => ['not_empty'],
                'machine_name' => ['not_empty']
            ], $variables);

        if (empty($errors)):

            /**
             * Create a new group
             */
            $variables['machine_name'] = _SANITIZE::pageBuilder($variables['machine_name']);
            $machineNameCount          = self::machineNameCount($variables['machine_name']);

            $machine_name = ($machineNameCount > 0) ? $variables['machine_name'] . '-' . ($machineNameCount - 1) : $variables['machine_name'];

            $newObject                   = new _DB\PageBuilderGroup();
            $newObject->pbg_name         = $variables['group_name'];
            $newObject->pbg_machine_name = $machine_name;
            $newObject->pbg_description  = $variables['object_description'];
            $newObject->pbg_date         = _TIME::_DATE_TIME()['_NOW'];
            $newObject->pbg_status       = isset($variables['object_status']) ? 1 : 0;
            $newObject->create();

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['pagebuilder']['created']
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
         * Validate the group machine name
         */
        $object              = new _DB\PageBuilderGroup();
        $machineNameValidate = $object->search(
            [
                'fields' => [
                    'pbg_machine_name' => [
                        'type'  => '=',
                        'value' => $machineName
                    ]
                ]
            ]);

        $objectNumber = 0;
        while (!empty($machineNameValidate)) {
            $object              = new _DB\PageBuilderGroup();
            $machineNameValidate = $object->search(
                [
                    'fields' => [
                        'pbg_machine_name' => [
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