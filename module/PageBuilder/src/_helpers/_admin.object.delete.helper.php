<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _OBJECT_DELETE
 * @package _MODULE\PageBuilder\Admin
 */
class _OBJECT_DELETE
{

    /**
     * Object Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $pbo_id    = $variables['pbo_id'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'page_builder_object'      => [
                'key'   => 'pbo_id',
                'value' => $pbo_id
            ],
            'page_builder_object_list' => [
                'key'   => 'pbol_pbo_id',
                'value' => $pbo_id
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        _MESSAGE::set($_TRANSLATION['pagebuilder']['removed_object'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder/objects'
            ]);

    }
}