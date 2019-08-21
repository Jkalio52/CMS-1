<?php
/**
 * @package   WarpKnot
 */

/**
 * Blog routing system
 *
 * Static route e.g. /example/list
 *
 */
return [

    /**
     * @administration
     */

    /**
     * Blog Management - Private
     */
    'admin/blog/post'                  => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'Management',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'administrator'
        ],
        'redirect_page'  => ''
    ],

    /**
     * Categories List
     */
    'admin/blog/categories'            => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'Categories',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Add Category
     */
    'admin/blog/categories/add'        => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'AddCategory',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Category Update
     */
    'admin/blog/categories/edit/{var}' => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'EditCategory',
        'type'           => 'dynamic',
        'variables'      => [
            '{id}',
        ],
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Posts List
     */
    'admin/blog'                       => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'List',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Add new post
     */
    'admin/blog/add-post'              => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'Add',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Post Update
     */
    'admin/blog/edit-post/{var}'       => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'Edit',
        'type'           => 'dynamic',
        'variables'      => [
            '{id}',
        ],
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * Settings
     */
    'admin/blog/settings'              => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\Admin',
        'action'         => 'Settings',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],

    /**
     * @public
     */
    'blog'                             => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\PublicBlog',
        'action'         => 'Homepage',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [],
        'local_template' => true
    ],
    'blog/search'                      => [
        'module'         => 'Blog',
        'namespace'      => 'Blog\PublicBlog',
        'action'         => 'SearchResults',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [],
        'local_template' => true
    ],
];