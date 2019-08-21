<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\_DB;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use function json_encode;

/**
 * Class _GROUP_UPDATE
 * @package _MODULE\PageBuilder\Admin
 */
class _GROUP_UPDATE
{
    /**
     * Group Update
     */
    public static function execute()
    {
        global $_TRANSLATION;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $errors = _REQUEST::_VALIDATE(
            [
                'group_name'   => ['not_empty'],
                'machine_name' => ['not_empty'],
            ], $variables);

        if (empty($errors)):

            /**
             * Update your group
             */
            $variables['machine_name'] = _SANITIZE::pageBuilder($variables['machine_name']);
            $slugCount                 = self::machineNameCount($variables['machine_name'], $variables['pbid']);
            $machine_name              = ($slugCount > 0) ? $variables['machine_name'] . '-' . ($slugCount - 1) : $variables['machine_name'];


            $objectUpdate                   = new _DB\PageBuilderGroup();
            $objectUpdate->pbg_name         = $variables['group_name'];
            $objectUpdate->pbg_machine_name = $machine_name;
            $objectUpdate->pbg_description  = $variables['object_description'];
            $objectUpdate->pbg_status       = isset($variables['object_status']) ? 1 : 0;
            $objectUpdate->save($variables['pbid']);

            return json_encode(
                [
                    'errors'  => false,
                    'message' => [
                        'type' => 'success',
                        'text' => $_TRANSLATION['pagebuilder']['updated']
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
        $object              = new _DB\PageBuilderGroup();
        $machineNameValidate = $object->search(
            [
                'fields' => [
                    'pbg_machine_name' => [
                        'type'  => '=',
                        'value' => $machineName
                    ],
                    'condition'        => [
                        'value' => 'and'
                    ],
                    'pbid'             => [
                        'type'  => '!=',
                        'value' => $id
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
                        ],
                        'condition'        => [
                            'value' => 'and'
                        ],
                        'pbid'             => [
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