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
 * Class _FORM_DELETE
 * @package _MODULE\PageBuilder\Admin
 */
class _FORM_DELETE
{

    /**
     * Form Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $pbf_id    = $variables['pbf_id'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'page_builder_forms'        => [
                'key'   => 'pbf_id',
                'value' => $pbf_id
            ],
            'page_builder_forms_fields' => [
                'key'   => 'pbff_pbf_id',
                'value' => $pbf_id
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        _MESSAGE::set($_TRANSLATION['forms']['removed'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/forms'
            ]);

    }
}