<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog;

use _MODULE\_DB;
use _MODULE\User\_ACCOUNT;
use _MODULE\Website;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;

/**
 * Class PublicCategory
 * @package _MODULE\Blog
 */
class PublicCategory extends _INIT
{
    private static $module = 'Blog';


    public static function getViewAction()
    {
        global $_APP_CONFIG;

        /**
         * Current category
         */
        $mainSlug = explode("/", _REQUEST::_URI()['_ROUTE']['0']);
        unset($mainSlug[0]);
        $slug = implode("/", $mainSlug);

        if (in_array('administrator', _ACCOUNT::_getRoles())):
            $_FILTER = [
                'bc_slug' => [
                    'type'  => '=',
                    'value' => $slug
                ]
            ];
        else:
            $_FILTER = [
                'bc_slug'     => [
                    'type'  => '=',
                    'value' => $slug
                ],
                'condition_2' => [
                    'value' => 'and'
                ],
                'bcd_status'  => [
                    'type'  => '=',
                    'value' => 'PUBLISHED'
                ],
            ];
        endif;

        $object = new _DB\BlogCategories();
        $object = $object->search(
            [
                'fields' => $_FILTER,
                'join'   => [
                    'blog_categories_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_categories_details',
                        'conn_id' => 'bcd_bcid',
                        'as'      => 'bcd'
                    ]
                ]
            ]);


        if (empty($object)):
            Website::Website_page_not_found();
        else:

            $objectSearchList   = PublicBlog::posts($object[0]['bcid']);
            self::$_VIEW->posts = _PAGINATION::_GENERATE(
                [
                    '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . _REQUEST::_URI()['_ROUTE']['0'],
                    '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . _REQUEST::_URI()['_ROUTE']['0'],
                    '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                    '_TOTAL_ITEMS'    => count($objectSearchList),
                    '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                    '_ITEMS'          => $objectSearchList
                ]
            );

            self::$_VIEW->categoriesList = PublicBlog::categories();

            $objectDetails                 = $object[0];
            self::$_VIEW->page_title       = empty($objectDetails['bcd_seo_title']) ? $objectDetails['bc_title'] : $objectDetails['bcd_seo_title'];
            self::$_VIEW->page_description = $objectDetails['bcd_seo_description'];
            self::$_VIEW->object           = empty($object) ? [] : $object[0];
            self::$_VIEW->ignorePartials   = true;
            self::$_VIEW->content          = selfRender(self::$module, 'public' . DIRECTORY_SEPARATOR . 'category.php');
        endif;
    }

}