<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _GENERATE_SELECT
 * @package _MODULE\PageBuilder\Admin
 */
class _GENERATE_SELECT
{
    private static $module = 'PageBuilder';

    /**
     * Convert post data to html
     */
    public static function execute()
    {
        $tempID    = time() . '-' . rand(0, time());
        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $selectValues = isset($variables['page-builder-object-values']) ? $variables['page-builder-object-values'] : '';


        $values = [];
        if (!empty($selectValues)):
            $options = explode("\n", $selectValues);
            if (!empty($options)):
                foreach ($options as $value):
                    $option                                       = explode(":", $value);
                    $values[PageBuilder::cleanString($option[0])] = isset($option[1]) ? PageBuilder::cleanString($option[1]) : PageBuilder::cleanString($option[0]);
                endforeach;
            endif;
        endif;

        $data                       = [
            'tempID'        => isset($variables['item_id']) ? $variables['item_id'] : $tempID,
            'name'          => isset($variables['page-builder-object-name']) ? $variables['page-builder-object-name'] : '',
            'machine_name'  => isset($variables['page-builder-object-machine-name']) ? $variables['page-builder-object-machine-name'] : '',
            'object_values' => isset($variables['page-builder-object-values']) ? json_encode($variables['page-builder-object-values']) : '',
            'placeholder'   => isset($variables['page-builder-object-placeholder']) ? $variables['page-builder-object-placeholder'] : '',
            'required'      => isset($variables['page-builder-object-required']) ? $variables['page-builder-object-required'] : '',
            'values'        => $values,
            'object'        => '_SELECT'
        ];
        PageBuilder::$_VIEW->data   = $data;
        PageBuilder::$_VIEW->tempID = isset($variables['item_id']) ? $variables['item_id'] : $tempID;
        PageBuilder::$_VIEW->json   = json_encode($data);

        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'select/select.generate.php')
        );
    }

    /**
     * HTML Generate
     *
     * @param $object
     * @param bool $placeholder
     * @param array $options
     * @return mixed
     */
    public static function html($object, $placeholder = true, $options = [])
    {
        $builderType = isset($object['pbol_json']) ? 'pbol_' : 'pbff_';
        $json        = json_decode($object[$builderType . 'json'], true);


        $json['object_values'] = isset($json['values']) ? $json['values'] : [];

        $values = [];
        if (!empty($json['object_values'])):
            foreach ($json['object_values'] as $key => $value):
                $values[$key] = isset($value) ? PageBuilder::cleanString($value) : PageBuilder::cleanString($key);
            endforeach;
        endif;

        $data = [
            'tempID'        => isset($object[$builderType . 'id']) ? $object[$builderType . 'id'] : '',
            'name'          => isset($json['name']) ? $json['name'] : '',
            'machine_name'  => isset($json['machine_name']) ? $json['machine_name'] : '',
            'default_value' => isset($json['default_value']) ? $json['default_value'] : '',
            'object_values' => isset($json['values']) ? json_encode($json['values']) : '',
            'placeholder'   => isset($json['placeholder']) ? $json['placeholder'] : '',
            'required'      => isset($json['required']) ? $json['required'] : '',
            'values'        => $values,
            'object'        => '_SELECT'
        ];

        PageBuilder::$_VIEW->data   = $data;
        PageBuilder::$_VIEW->tempID = isset($object[$builderType . 'id']) ? $object[$builderType . 'id'] : '';
        PageBuilder::$_VIEW->json   = $object[$builderType . 'json'];

        if ($placeholder):
            return selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'select/select.generate.php');
        else:
            return selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'select/select.generate-form.php');
        endif;
    }
}