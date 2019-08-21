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
 * Class _GROUP_DELETE
 * @package _MODULE\PageBuilder\Admin
 */
class _GROUP_DELETE
{

    /**
     * Group Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $pbid      = $variables['pbid'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'page_builder_group' => [
                'key'   => 'pbid',
                'value' => $pbid
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        _MESSAGE::set($_TRANSLATION['pagebuilder']['removed'], 'success');

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/page-builder'
            ]);

    }
}