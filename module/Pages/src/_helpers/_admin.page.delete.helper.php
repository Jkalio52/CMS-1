<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Pages\Admin;

use _MODULE\PageBuilder;
use _MODULE\RoutingSystem;
use _WKNT\_CRUD;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _PAGE_DELETE
 * @package _MODULE\Pages\Admin
 */
class _PAGE_DELETE
{

    /**
     * Page Delete
     */
    public static function execute()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);
        $pid       = $variables['pid'];

        /**
         * Delete from the default tables
         */
        $del           = new _CRUD();
        $defaultTables = [
            'pages'         => [
                'key'   => 'pid',
                'value' => $pid
            ],
            'pages_details' => [
                'key'   => 'pd_pid',
                'value' => $pid
            ]
        ];

        foreach ($defaultTables as $key => $table):
            $del->deleteFrom($key, $table['key'], $table['value']);
        endforeach;

        /**
         * Delete the route
         */
        RoutingSystem::delete($pid, 'Pages', 'Pages\PublicPages', 'View', 'static');

        _MESSAGE::set($_TRANSLATION['pages']['removed'], 'success');

        /**
         * PageBuilder Data Remove
         */
        PageBuilder::delete($pid);

        return json_encode(
            [
                'errors'   => '',
                'message'  => false,
                'redirect' => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/pages'
            ]
        );

    }
}