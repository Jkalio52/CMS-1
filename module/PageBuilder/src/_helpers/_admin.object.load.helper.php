<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\_DB;
use _MODULE\PageBuilder;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _LOAD_OBJECT
 * @package _MODULE\PageBuilder\Admin
 */
class _LOAD_OBJECT extends _INIT
{
    private static $module = 'PageBuilder';

    /**
     * Using the modal
     */
    public static function execute()
    {
        $data   = isset(_REQUEST::_POST()['data']) ? _REQUEST::_POST()['data'] : [];
        $widget = isset($data['widget']) ? $data['widget'] : FALSE;
        $itemID = isset($data['itemID']) ? $data['itemID'] : FALSE;

        /**
         * Return the HTML part for each field
         */
        if ($widget && $itemID):
            /**
             * Widget Details
             */
            $item        = new _DB\PageBuilderWidget();
            $itemDetails = $item->search(
                [
                    'fields' => [
                        'pbo_id' => [
                            'type'  => '=',
                            'value' => $itemID
                        ]
                    ]
                ]);

            /**
             * Fields List
             */
            $items     = new _DB\PageBuilderField();
            $itemsList = $items->search(
                [
                    'fields' => [
                        'pbol_pbo_id' => [
                            'type'  => '=',
                            'value' => $itemID
                        ]
                    ],
                    'sort'   => [
                        'pbol_weight' => 'asc'
                    ]
                ]);

            $itemsHtml = [];
            foreach ($itemsList as $item):
                $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbol_type'];
                if (method_exists($_OBJECT_METHOD, 'html')):
                    $_GENERATE_HTML = new $_OBJECT_METHOD;
                    $itemsHtml[]    = $_GENERATE_HTML->html($item, false);
                endif;
            endforeach;


            PageBuilder::$_VIEW->itemsHtml   = $itemsHtml;
            PageBuilder::$_VIEW->itemDetails = isset($itemDetails[0]) ? $itemDetails[0] : [];
            return json_encode(
                selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'widget.php')
            );

        endif;

        return false;
    }

    /**
     * @param $itemID
     * @return bool
     */
    public static function emptyObject($itemID)
    {
        /**
         * Fields List
         */
        $items     = new _DB\PageBuilderField();
        $itemsList = $items->search(
            [
                'fields' => [
                    'pbol_pbo_id' => [
                        'type'  => '=',
                        'value' => $itemID
                    ]
                ],
                'sort'   => [
                    'pbol_weight' => 'asc'
                ]
            ]);

        $itemsHtml = [];
        foreach ($itemsList as $item):
            $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbol_type'];
            if (method_exists($_OBJECT_METHOD, 'html')):
                $_GENERATE_HTML = new $_OBJECT_METHOD;
                $itemsHtml[]    = $_GENERATE_HTML->html($item, false, ['empty_editor' => 'true']);
            endif;
        endforeach;

        return implode("", $itemsHtml);

    }
}