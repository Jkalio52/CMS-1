<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User\Admin;

use _MODULE\_DB\UserStoredData;
use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _USER_DELETE
 * @package _MODULE\User\Admin
 */
class _USER_DELETE
{

    /**
     * User Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $uid       = $variables['uid'];


        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'user'         => [
                'key'   => 'uid',
                'value' => $uid
            ],
            'user_profile' => [
                'key'   => 'p_uid',
                'value' => $uid
            ],
            'user_recover' => [
                'key'   => 'r_uid',
                'value' => $uid
            ],
            'user_roles'   => [
                'key'   => 'ur_uid',
                'value' => $uid
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        /**
         * Other data stored for this user
         */
        $storedData = new UserStoredData();
        $data       = $storedData->search(
            [
                'fields' => [
                    'user_id' => [
                        'type'  => '=',
                        'value' => $uid
                    ]
                ]
            ]);
        if (!empty($data)):
            foreach ($data as $row):
                $del->deleteFrom($row['table_name'], $row['table_key'], $row['row_id']);
            endforeach;
        endif;

        _MESSAGE::set($_TRANSLATION['user']['account_removed'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/users'
            ]);

    }
}