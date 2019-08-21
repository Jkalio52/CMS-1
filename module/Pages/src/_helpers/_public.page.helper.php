<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Pages;

use _MODULE\_DB;
use _MODULE\User\_ACCOUNT;
use _MODULE\Website;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;

/**
 * Class PublicPages
 * @package _MODULE\Pages
 */
class PublicPages extends _INIT
{
    private static $module = 'Pages';


    public static function getViewAction()
    {
        $slug = _REQUEST::_URI()['_ROUTE']['0'];
        if (in_array('administrator', _ACCOUNT::_getRoles())):
            $_FILTER = [
                'page_slug' => [
                    'type'  => '=',
                    'value' => $slug
                ]
            ];
        else:
            $_FILTER = [
                'page_slug'   => [
                    'type'  => '=',
                    'value' => $slug
                ],
                'condition_2' => [
                    'value' => 'and'
                ],
                'pd_status'   => [
                    'type'  => '=',
                    'value' => 'PUBLISHED'
                ],
            ];
        endif;

        $page   = new _DB\Pages();
        $object = $page->search(
            [
                'fields' => $_FILTER,
                'join'   => [
                    'pages_details' => [
                        'mode'    => 'left join',
                        'table'   => 'pages_details',
                        'conn_id' => 'pd_pid',
                        'as'      => 'up'
                    ]
                ]
            ]);
        if (!empty($object)):
            if (!_REQUEST::_IS_HOME() && $object['0']['page_front']):
                _ROUTE::_REDIRECT('');
            endif;
        endif;

        if (!empty($object)):
            $pageDetails                   = $object[0];
            self::$_VIEW->page_title       = empty($pageDetails['pd_seo_title']) ? $pageDetails['page_title'] : $pageDetails['pd_seo_title'];
            self::$_VIEW->page_description = $pageDetails['pd_seo_description'];
            self::$_VIEW->object           = $pageDetails;
            self::$_VIEW->ignorePartials   = true;
            self::$_VIEW->content          = selfRender(self::$module, (empty($pageDetails['pd_template']) ? 'public' . DIRECTORY_SEPARATOR . 'page.php' : 'templates' . DIRECTORY_SEPARATOR . $pageDetails['pd_template']));
        else:
            Website::Website_page_not_found();
        endif;
    }
}