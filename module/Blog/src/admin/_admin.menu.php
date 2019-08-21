<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    200 => [
        'blog_management' => [
            'name'  => 'Blog',
            'link'  => 'admin/blog',
            'icon'  => 'oi oi-text',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'posts'      => [
                    'name'  => 'Posts',
                    'link'  => 'admin/blog',
                    'icon'  => 'oi oi-file',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'posts_add'  => [
                    'name'  => 'Add Post',
                    'link'  => 'admin/blog/add-post',
                    'icon'  => 'oi oi-plus',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'categories' => [
                    'name'  => 'Categories',
                    'link'  => 'admin/blog/categories',
                    'icon'  => 'oi oi-file',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'settings'   => [
                    'name'  => 'Settings',
                    'link'  => 'admin/blog/settings',
                    'icon'  => 'oi oi-wrench',
                    'roles' => [
                        'administrator'
                    ],
                ]
            ]
        ]
    ]
];