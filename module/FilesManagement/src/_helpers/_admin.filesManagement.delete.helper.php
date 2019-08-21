<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\FilesManagement;

use _MODULE\_DB;
use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _FILE_DELETE
 * @package _MODULE\FilesManagement
 */
class _FILE_DELETE
{

    /**
     * User Login Validation
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG, $__DIRECTORIES;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $fid       = $variables['fid'];

        /**
         * Get the file details
         */
        $object        = new _DB\FilesManagement();
        $objectDetails = $object->search(
            [
                'fields' => [
                    'fid' => [
                        'type'  => '=',
                        'value' => $fid
                    ]
                ]
            ]);
        if (empty($objectDetails)):
            _MESSAGE::set($_TRANSLATION['filesmanagement']['invalid_request'], 'danger');
        /**
         * Delete from the default tables
         */
        else:
            $_LOCATION = $__DIRECTORIES['_UPLOADS'] . $objectDetails['0']['location'];
            if (file_exists($_LOCATION)):
                unlink($_LOCATION);
            endif;

            $del           = new _CRUD();
            $defaultTables = [
                'files_management' => [
                    'key'   => 'fid',
                    'value' => $fid
                ]
            ];

            foreach ($defaultTables as $key => $table):
                $del->deleteFrom($key, $table['key'], $table['value']);
            endforeach;

            _MESSAGE::set($_TRANSLATION['filesmanagement']['removed'], 'success');
        endif;

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/files'
            ]
        );

    }
}