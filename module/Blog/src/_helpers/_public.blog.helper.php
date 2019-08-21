<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;

/**
 * Class PublicBlog
 * @package _MODULE\Blog
 */
class PublicBlog extends _INIT
{
    private static $module = 'Blog';

    /**
     * Blog Index
     */
    public static function getHomepageAction()
    {
        global $_APP_CONFIG;

        $object = new _DB\BlogSettings();
        $object = $object->search([]);
        if (empty($object)):
            self::$_VIEW->page_title       = 'Blog';
            self::$_VIEW->page_description = '';
        else:
            self::$_VIEW->page_title       = empty($object['0']['bs_name']) ? $object['0']['bs_seo_name'] : $object['0']['bs_seo_name'];
            self::$_VIEW->page_description = $object['0']['bs_seo_description'];
        endif;


        $objectSearchList   = self::posts();
        self::$_VIEW->posts = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'blog',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'blog',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectSearchList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectSearchList
            ]
        );

        self::$_VIEW->categoriesList = self::categories();
        self::$_VIEW->object         = empty($object) ? [] : $object[0];
        self::$_VIEW->ignorePartials = true;
        self::$_VIEW->content        = selfRender(self::$module, 'public' . DIRECTORY_SEPARATOR . 'blog.php');
    }


    /**
     * Search Results
     */
    public static function getSearchResultsAction()
    {
        global $_APP_CONFIG;

        $object = new _DB\BlogSettings();
        $object = $object->search([]);

        if (empty($object)):
            self::$_VIEW->page_title       = 'Blog - Search Results';
            self::$_VIEW->page_description = '';
        else:
            self::$_VIEW->page_title       = empty($object['0']['bs_name']) ? $object['0']['bs_seo_name'] : $object['0']['bs_seo_name'] . ' - Search Results';
            self::$_VIEW->page_description = $object['0']['bs_seo_description'];
        endif;


        $objectSearchList   = self::posts(false, true);
        self::$_VIEW->posts = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'blog/search',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'blog/search',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectSearchList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectSearchList
            ]
        );

        self::$_VIEW->categoriesList = self::categories();
        self::$_VIEW->object         = empty($object) ? [] : $object[0];
        self::$_VIEW->ignorePartials = true;
        self::$_VIEW->content        = selfRender(self::$module, 'public' . DIRECTORY_SEPARATOR . 'blog-search.php');
    }

    /**
     * Posts List
     *
     * @param bool $category
     * @param bool $search
     * @return mixed
     */
    public static function posts($category = false, $search = false)
    {
        $variables = _REQUEST::_GET_VARIABLES();
        $s         = isset($variables['s']) ? $variables['s'] : '';

        $objectSearch = new _DB\BlogPost();

        if (empty($category)):
            $fields = [
                'bpd_status'          => [
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
                    'value' => 'Blog\PublicPost'
                ],
            ];
            if ($search && !empty($s)):
                $fields['condition_search_and']       = [
                    'value' => 'and'
                ];
                $fields['group_query_start']          = [
                    'value' => '('
                ];
                $fields['bp_title']                   = [
                    'type'  => 'like',
                    'value' => '%' . $s . '%'
                ];
                $fields['condition_search_or']        = [
                    'value' => 'or'
                ];
                $fields['bp_body']                    = [
                    'type'  => 'like',
                    'value' => '%' . $s . '%'
                ];
                $fields['condition_search_second_or'] = [
                    'value' => 'or'
                ];
                $fields['bp_preview']                 = [
                    'type'  => 'like',
                    'value' => '%' . $s . '%'
                ];
                $fields['group_query_end']            = [
                    'value' => ')'
                ];
            endif;
            $objectSearchList = $objectSearch->search(
                [
                    'fields' => $fields,
                    'join'   => [
                        'blog_post_details' => [
                            'mode'    => 'left join',
                            'table'   => 'blog_post_details',
                            'conn_id' => 'bpd_bpid',
                            'as'      => 'bpd'
                        ],
                        'routing_system'    => [
                            'mode'    => 'left join',
                            'table'   => 'routing_system',
                            'conn_id' => 'object_id',
                            'as'      => 'rsystem'
                        ]
                    ],
                    'sort'   => [
                        'bpid' => 'desc'
                    ]
                ]
            );
        else:
            $objectSearch     = new _DB\BlogPostCategories();
            $fields           = [
                'bpd_status'          => [
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
                    'value' => 'Blog\PublicPost'
                ],
                'condition_pbc_bcid'  => [
                    'value' => 'and'
                ],
                'pbc_bcid'            => [
                    'type'  => '=',
                    'value' => $category
                ],
            ];
            $objectSearchList = $objectSearch->search(
                [
                    'fields' => $fields,
                    'join'   => [
                        'blog_post'         => [
                            'mode'    => 'left join',
                            'table'   => 'blog_post',
                            'conn_id' => 'bpid',
                            'as'      => 'bp'
                        ],
                        'blog_post_details' => [
                            'mode'    => 'left join',
                            'table'   => 'blog_post_details',
                            'conn_id' => 'bpd_bpid',
                            'as'      => 'bpd'
                        ],
                        'routing_system'    => [
                            'mode'    => 'left join',
                            'table'   => 'routing_system',
                            'conn_id' => 'object_id',
                            'as'      => 'rsystem'
                        ]
                    ],
                    'sort'   => [
                        'bpid' => 'desc'
                    ]
                ]
            );

        endif;


        return $objectSearchList;
    }

    /**
     * Categories List
     *
     * @return mixed
     */
    public static function categories()
    {
        $categories     = new _DB\BlogCategories();
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
                ],
                'join'   => [
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
                    'bc_title' => 'asc'
                ]
            ]
        );

        return $categoriesList;
    }

    /**
     * @param $_POST_ID
     * @return mixed
     */
    public static function postCategories($_POST_ID)
    {
        $BlogPostCategories               = new _DB\BlogPostCategories();
        $BlogPostCategories->connSettings = [
            'key' => 'pbc_bcid'
        ];
        $categories                       = $BlogPostCategories->search(
            [
                'fields'   => [
                    'pbc_bpid' => [
                        'type'  => '=',
                        'value' => $_POST_ID
                    ],
                    'condition' => [
                        'value' => 'and'
                    ],
                    'namespace'      => [
                        'type'  => '=',
                        'value' => 'Blog\PublicCategory'
                    ]
                ],
                'join'     => [
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
                'group_by' => 'bc.bcid',
            ]);
        return $categories;
    }

}