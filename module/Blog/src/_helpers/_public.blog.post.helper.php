<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog;

use _MODULE\_DB;
use _MODULE\User\_ACCOUNT;
use _MODULE\Website;
use _WKNT\_INIT;
use _WKNT\_REQUEST;

/**
 * Class PublicPost
 * @package _MODULE\Blog
 */
class PublicPost extends _INIT
{
    private static $module = 'Blog';

    /**
     * Post Page
     */
    public static function getViewAction()
    {
        $mainSlug = explode("/", _REQUEST::_URI()['_ROUTE']['0']);
        unset($mainSlug[0]);
        $slug = implode("/", $mainSlug);

        if (in_array('administrator', _ACCOUNT::_getRoles())):
            $_FILTER = [
                'bp_slug' => [
                    'type'  => '=',
                    'value' => $slug
                ]
            ];
        else:
            $_FILTER = [
                'bp_slug'     => [
                    'type'  => '=',
                    'value' => $slug
                ],
                'condition_2' => [
                    'value' => 'and'
                ],
                'bpd_status'  => [
                    'type'  => '=',
                    'value' => 'PUBLISHED'
                ],
            ];
        endif;

        $object       = new _DB\BlogPost();
        $objectSearch = $object->search(
            [
                'fields' => $_FILTER,
                'join'   => [
                    'blog_post_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_post_details',
                        'conn_id' => 'bpd_bpid',
                        'as'      => 'bpd'
                    ]
                ]
            ]);
        if (!empty($objectSearch)):
            /**
             * Post categories
             */

            $categories               = new _DB\BlogPostCategories();
            $categories->connSettings = [
                'key' => 'pbc_bcid'
            ];

            $categoriesList = $categories->search(
                [
                    'fields' => [
                        'bcd_status'          => [
                            'type'  => '=',
                            'value' => 'PUBLISHED'
                        ],
                        'condition'           => [
                            'value' => 'and'
                        ],
                        'module'              => [
                            'type'  => '=',
                            'value' => 'Blog'
                        ],
                        'condition_namespace' => [
                            'value' => 'and'
                        ],
                        'namespace'           => [
                            'type'  => '=',
                            'value' => 'Blog\PublicCategory'
                        ],
                        'condition_pbc_bpid'  => [
                            'value' => 'and'
                        ],
                        'pbc_bpid'            => [
                            'type'  => '=',
                            'value' => $objectSearch[0]['bpid']
                        ],
                    ],
                    'join'   => [
                        'blog_categories'         => [
                            'mode'    => 'left join',
                            'table'   => 'blog_categories',
                            'conn_id' => 'bcid',
                            'as'      => 'bc'
                        ],
                        'blog_categories_details' => [
                            'mode'    => 'left join',
                            'table'   => 'blog_categories_details',
                            'conn_id' => 'bcd_bcid',
                            'as'      => 'bcd'
                        ],
                        'routing_system'          => [
                            'mode'    => 'left join',
                            'table'   => 'routing_system',
                            'conn_id' => 'object_id',
                            'as'      => 'rsystem'
                        ]
                    ],
                    'sort'   => [
                        'pbc_bpid' => 'desc'
                    ]
                ]);

            $objectDetails                 = $objectSearch[0];
            self::$_VIEW->page_title       = empty($objectDetails['bpd_seo_title']) ? $objectDetails['bp_title'] : $objectDetails['bpd_seo_title'];
            self::$_VIEW->page_description = $objectDetails['bpd_seo_description'];
            self::$_VIEW->object           = $objectDetails;
            self::$_VIEW->categories       = $categoriesList;
            self::$_VIEW->ignorePartials   = true;
            self::$_VIEW->content          = selfRender(self::$module, 'public' . DIRECTORY_SEPARATOR . 'post.php');
        else:
            Website::Website_page_not_found();
        endif;
    }

}