<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _RADIO
 * @package _MODULE\PageBuilder\Admin
 */
class _RADIO
{
    private static $module = 'PageBuilder';

    /**
     *
     */
    public static function execute()
    {
        $variables    = _REQUEST::_VARIABLES(isset(_REQUEST::_POST()['data']) ? _REQUEST::_POST()['data'] : '');
        $selectValues = isset($variables['object_values']) ? json_decode($variables['object_values']) : '';
        $values       = [];
        if (!empty($selectValues)):
            $options = explode("\n", $selectValues);
            if (!empty($options)):
                $i = 0;
                foreach ($options as $value):
                    $values[$i] = PageBuilder::cleanString($value);
                    $i++;
                endforeach;
            endif;
        endif;

        $data                       = [
            'tempID'        => '',
            'name'          => isset($variables['name']) ? $variables['name'] : '',
            'machine_name'  => isset($variables['machine_name']) ? $variables['machine_name'] : '',
            'object_values' => isset($variables['object_values']) ? json_decode($variables['object_values']) : '',
            'placeholder'   => isset($variables['placeholder']) ? $variables['placeholder'] : '',
            'values'        => array_reverse($values),
            'required'      => isset($variables['required']) ? $variables['required'] : '',
        ];
        PageBuilder::$_VIEW->values = isset($variables['object_values']) ? json_decode($variables['object_values']) : [];
        PageBuilder::$_VIEW->data   = $data;
        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'radio/radio.php')
        );
    }
}