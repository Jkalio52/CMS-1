<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _TEXT_EDITOR
 * @package _MODULE\PageBuilder\Admin
 */
class _TEXT_EDITOR
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
            'required'      => isset($variables['required']) ? $variables['required'] : '',
        ];

        PageBuilder::$_VIEW->data = $data;
        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'editor/editor.php')
        );
    }
}