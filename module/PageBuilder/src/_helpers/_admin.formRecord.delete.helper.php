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
 * Class _RECORD_DELETE
 * @package _MODULE\PageBuilder\Admin
 */
class _RECORD_DELETE
{

    /**
     * Record Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $pbfd_id   = $variables['pbfd_id'];
        $formId    = $variables['formId'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'page_builder_forms_data'        => [
                'key'   => 'pbfd_id',
                'value' => $pbfd_id
            ],
            'page_builder_forms_data_values' => [
                'key'   => 'pbfdv_pbf_id',
                'value' => $pbfd_id
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        _MESSAGE::set($_TRANSLATION['forms']['record_removed'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms/records/' . $formId
            ]);

    }
}