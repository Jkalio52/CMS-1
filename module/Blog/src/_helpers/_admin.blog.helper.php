<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Blog;

use _MODULE\_DB;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class Admin
 * @package _MODULE\Blog
 */
class Admin extends _INIT
{
    private static $module = 'Blog\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'blog';

    /**
     * Categories List
     */
    public static function getCategoriesAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['category_name']) && !empty($_GET_VARIABLES['category_name'])):
            $filter['bc_title'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['category_name'] . '%'
            ];
        endif;

        $categories     = new _DB\BlogCategories();
        $categoriesList = $categories->search(
            [
                'fields' => $filter,
                'join'   => [
                    'blog_categories_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_categories_details',
                        'conn_id' => 'bcd_bcid',
                        'as'      => 'bcd'
                    ]
                ],
                'sort'   => [
                    'bcid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = $categoriesList;

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object = new _DB\BlogCategories();
            $delete = $object->search(
                [
                    'fields' => [
                        'bcid' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'categories';
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['list_categories']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['list_categories']['seo_description'];

        self::template('admin/categories.php');
    }

    /**
     * Generate the dashboard template
     *
     * @param $page
     */
    private static function template($page)
    {
        self::$_VRS = [
            'header'  => selfRender(self::$moduleTemplate, 'partials/header.php'),
            'footer'  => selfRender(self::$moduleTemplate, 'partials/footer.php'),
            'content' => selfRender('Blog', $page)
        ];
    }

    /**
     * Add a new category
     */
    public static function getAddCategoryAction()
    {
        global $_TRANSLATION;

        /**
         * Categories List
         */
        self::$_VIEW->categories       = self::categoriesList(false, true);
        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'categories';
        self::$_VIEW->objectTemplates  = self::availableTemplates();
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['add_category']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['add_category']['seo_description'];

        self::template('admin/category.php');
    }

    /**
     * @param bool $_BCID
     * @param $_PARENT_ONLY
     *
     * @return mixed
     */
    public static function categoriesList($_BCID = false, $_PARENT_ONLY = false)
    {
        /**
         * Categories List
         */
        $fields = [
            'bcd_status' => [
                'type'  => '=',
                'value' => 'PUBLISHED'
            ]
        ];

        $categories = new _DB\BlogCategories();
        if ($_BCID):
            $fields['condition_bcid'] = [
                'value' => 'and'
            ];
            $fields['bcid']           = [
                'type'  => '!=',
                'value' => $_BCID
            ];
        endif;

        if ($_PARENT_ONLY):
            $fields['condition']  = [
                'value' => 'and'
            ];
            $fields['bcd_parent'] = [
                'type'  => '=',
                'value' => 0
            ];
        endif;

        return $categories->search(
            [
                'fields' => $fields,
                'join'   => [
                    'blog_categories_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_categories_details',
                        'conn_id' => 'bcd_bcid',
                        'as'      => 'bcd'
                    ]
                ],
                'sort'   => [
                    'bc_title' => 'asc'
                ]
            ]);
    }

    /**
     * @return array
     */
    private static function availableTemplates()
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        $templatesList = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . self::$templatesDirectory . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $_TEMPLATES    = [];
        foreach (glob($templatesList . "*.php") as $template):
            $templateName              = str_replace(
                [
                    '.php',
                    '-'
                ], [
                    '',
                    ' '
                ], $template);
            $templateName              = preg_replace('/[^A-Za-z0-9\-]/', ' ', basename($templateName));
            $_TEMPLATES[$templateName] = basename($template);
        endforeach;

        return $_TEMPLATES;
    }

    /**
     * Category Update
     */
    public static function getEditCategoryAction()
    {
        global $_TRANSLATION;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_BCID       = $_REQUEST_ID[0];

        $object = new _DB\BlogCategories();
        $object = $object->search(
            [
                'fields' => [
                    'bcid' => [
                        'type'  => '=',
                        'value' => $_BCID
                    ]
                ],
                'join'   => [
                    'blog_categories_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_categories_details',
                        'conn_id' => 'bcd_bcid',
                        'as'      => 'bcd'
                    ]
                ],
            ]);

        if (empty($object)):
            _ROUTE::_REDIRECT('admin/blog/categories');
        endif;
        self::$_VIEW->object = $object[0];

        self::$_VIEW->categories       = self::categoriesList($_BCID, true);
        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'categories';
        self::$_VIEW->objectTemplates  = self::availableTemplates();
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['edit_category']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['edit_category']['seo_description'];

        self::template('admin/category.php');
    }

    /**
     * Return a list with all posts
     */
    public static function getListAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['post_title']) && !empty($_GET_VARIABLES['post_title'])):
            $filter['bp_title'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['post_title'] . '%'
            ];
        endif;


        $objectSearch     = new _DB\BlogPost();
        $objectSearchList = $objectSearch->search(
            [
                'fields' => $filter,
                'join'   => [
                    'blog_post_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_post_details',
                        'conn_id' => 'bpd_bpid',
                        'as'      => 'bpd'
                    ]
                ],
                'sort'   => [
                    'bpid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/blog',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/blog',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectSearchList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectSearchList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object = new _DB\BlogPost();
            $delete = $object->search(
                [
                    'fields' => [
                        'bpid' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'posts';
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['list']['seo_description'];

        self::template('admin/posts.php');
    }

    /**
     * Add a new post
     */
    public static function getAddAction()
    {
        global $_TRANSLATION;

        self::$_VIEW->categories       = self::categoriesList();
        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'posts_add';
        self::$_VIEW->objectTemplates  = self::availableTemplates();
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['add']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['add']['seo_description'];

        self::template('admin/post.php');
    }

    /**
     * Post update
     */
    public static function getEditAction()
    {
        global $_TRANSLATION;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        $_BCID       = $_REQUEST_ID[0];

        $object = new _DB\BlogPost();
        $object = $object->search(
            [
                'fields' => [
                    'bpid' => [
                        'type'  => '=',
                        'value' => $_BCID
                    ]
                ],
                'join'   => [
                    'blog_post_details' => [
                        'mode'    => 'left join',
                        'table'   => 'blog_post_details',
                        'conn_id' => 'bpd_bpid',
                        'as'      => 'bpd'
                    ]
                ],
            ]);

        if (empty($object)):
            _ROUTE::_REDIRECT('admin/blog');
        endif;
        self::$_VIEW->object = $object[0];

        // Current categories
        $BlogPostCategories = new _DB\BlogPostCategories();
        $bpc                = $BlogPostCategories->search(
            [
                'fields' => [
                    'pbc_bpid' => [
                        'type'  => '=',
                        'value' => $_BCID
                    ]
                ]
            ]);
        $attachedCategories = [];
        if (!empty($bpc)):
            foreach ($bpc as $item):
                $attachedCategories[] = $item['pbc_bcid'];
            endforeach;
        endif;

        self::$_VIEW->attachedCategories = $attachedCategories;
        self::$_VIEW->categories         = self::categoriesList();
        self::$_VIEW->menu               = 'blog_management';
        self::$_VIEW->sMenu              = 'posts_add';
        self::$_VIEW->objectTemplates    = self::availableTemplates();
        self::$_VIEW->page_title         = $_TRANSLATION['blog']['edit']['seo_title'];
        self::$_VIEW->page_description   = $_TRANSLATION['blog']['edit']['seo_description'];

        self::template('admin/post.php');
    }

    /**
     * Blog Settings Page
     */
    public static function getSettingsAction()
    {

        global $_TRANSLATION;

        $object = new _DB\BlogSettings();
        $object = $object->search([]);
        if (empty($object)):
            $settings                     = new _DB\BlogSettings();
            $settings->bs_name            = '';
            $settings->bs_body            = '';
            $settings->bs_seo_name        = '';
            $settings->bs_seo_description = '';
            $settings->bs_cover           = '';
            $settings->bs_template        = '';
            $settings->create();
        endif;


        self::$_VIEW->menu             = 'blog_management';
        self::$_VIEW->sMenu            = 'settings';
        self::$_VIEW->object           = empty($object) ? [] : $object[0];
        self::$_VIEW->page_title       = $_TRANSLATION['blog']['settings']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['blog']['settings']['seo_description'];

        self::template('admin/settings.php');
    }


    /**
     * Post Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;

        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'];

        if (method_exists('\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'], 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['blog']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}