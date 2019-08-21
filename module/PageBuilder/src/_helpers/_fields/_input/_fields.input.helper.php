<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _INPUT
 * @package _MODULE\PageBuilder\Admin
 */
class _INPUT
{
    private static $module = 'PageBuilder';

    /**
     *
     */
    public static function execute()
    {
        $variables = _REQUEST::_VARIABLES(isset(_REQUEST::_POST()['data']) ? _REQUEST::_POST()['data'] : '');

        $data = [
            'tempID'        => '',
            'name'          => isset($variables['name']) ? $variables['name'] : '',
            'machine_name'  => isset($variables['machine_name']) ? $variables['machine_name'] : '',
            'default_value' => isset($variables['default_value']) ? $variables['default_value'] : '',
            'placeholder'   => isset($variables['placeholder']) ? $variables['placeholder'] : '',
            'type'          => isset($variables['type']) ? $variables['type'] : '',
            'required'      => isset($variables['required']) ? $variables['required'] : '',
        ];

        PageBuilder::$_VIEW->data  = $data;
        PageBuilder::$_VIEW->types = [
            'text',
            'password',
            'email',
            'tel',
            'number',
            'date',
            'time',
            'datetime',
            'color'
        ];
        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'input/input.php')
        );
    }
}