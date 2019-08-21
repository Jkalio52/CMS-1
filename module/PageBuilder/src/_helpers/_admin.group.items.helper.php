<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\_DB;
use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _LOAD_WIDGETS
 * @package _MODULE\PageBuilder\Admin
 */
class _LOAD_WIDGETS
{
    private static $module = 'PageBuilder';

    /**
     * Using the modal
     */
    public static function execute()
    {
        $data  = isset(_REQUEST::_POST()['data']) ? _REQUEST::_POST()['data'] : [];
        $group = isset($data['group']) ? $data['group'] : [];

        if (isset($group['object']) && isset($group['object_id'])):

            $objects     = new _DB\PageBuilderWidget();
            $objectsList = $objects->search(
                [
                    'fields' => [
                        'pbo_pbid' => [
                            'type'  => '=',
                            'value' => $group['object_id']
                        ]
                    ],
                    'sort'   => [
                        'pbo_name' => 'asc'
                    ]
                ]);

            PageBuilder::$_VIEW->objectsList = $objectsList;
            return json_encode(
                selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'widgets.php')
            );

        else:
            return json_encode('No widgets available.');
        endif;

    }
}