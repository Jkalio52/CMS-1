<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\FilesManagement;
use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class _GENERATE_GALLERY
 * @package _MODULE\PageBuilder\Admin
 */
class _GENERATE_GALLERY
{
    private static $module = 'PageBuilder';

    /**
     * Convert post data to html
     */
    public static function execute()
    {
        $tempID    = time() . '-' . rand(0, time());
        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        $data                       = [
            'tempID'        => isset($variables['item_id']) ? $variables['item_id'] : $tempID,
            'name'          => isset($variables['page-builder-object-name']) ? $variables['page-builder-object-name'] : '',
            'machine_name'  => isset($variables['page-builder-object-machine-name']) ? $variables['page-builder-object-machine-name'] : '',
            'default_value' => isset($variables['page-builder-object-default']) ? $variables['page-builder-object-default'] : '',
            'placeholder'   => isset($variables['page-builder-object-placeholder']) ? $variables['page-builder-object-placeholder'] : '',
            'required'      => isset($variables['page-builder-object-required']) ? $variables['page-builder-object-required'] : '',
            'object'        => '_GALLERY'
        ];
        PageBuilder::$_VIEW->data   = $data;
        PageBuilder::$_VIEW->tempID = isset($variables['item_id']) ? $variables['item_id'] : $tempID;
        PageBuilder::$_VIEW->json   = json_encode($data);

        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'gallery/gallery.generate.php')
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
        global $_APP_CONFIG,
               $__DIRECTORIES;
        $_CACHE_LOCATION = $__DIRECTORIES['_UPLOADS'] . FilesManagement::$imageCacheFolder;

        $builderType = isset($object['pbol_json']) ? 'pbol_' : 'pbff_';
        $json        = json_decode($object[$builderType . 'json'], true);

        $galleryItems = [];
        if (!empty($json['default_value'])):
            foreach ($json['default_value'] as $item):
                $file     = explode("/", $item['value']);
                $fileName = is_array($file) ? end($file) : '';

                PageBuilder::$_VIEW->galleryItem = [
                    'value'  => $item['value'],
                    'weight' => $item['weight'],
                    'cache'  => file_exists($_CACHE_LOCATION . $fileName) ?
                        $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . FilesManagement::$imageCacheFolder . $fileName :
                        $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . $fileName
                ];

                $galleryItems[] = selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . 'item.php');
            endforeach;
        endif;


        $data                             = [
            'tempID'        => isset($object[$builderType . 'id']) ? $object[$builderType . 'id'] : '',
            'name'          => isset($json['name']) ? $json['name'] : '',
            'machine_name'  => isset($json['machine_name']) ? $json['machine_name'] : '',
            'default_value' => isset($json['default_value']) ? $json['default_value'] : '',
            'placeholder'   => isset($json['placeholder']) ? $json['placeholder'] : '',
            'required'      => isset($json['required']) ? $json['required'] : '',
            'object'        => '_GALLERY'
        ];
        PageBuilder::$_VIEW->galleryItems = implode('', $galleryItems);
        PageBuilder::$_VIEW->data         = $data;
        PageBuilder::$_VIEW->tempID       = isset($object[$builderType . 'id']) ? $object[$builderType . 'id'] : '';
        PageBuilder::$_VIEW->json         = json_encode($data);

        if ($placeholder):
            return selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'gallery/gallery.generate.php');
        else:
            return selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'gallery/gallery.generate-form.php');
        endif;
    }
}