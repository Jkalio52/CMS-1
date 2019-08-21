<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    100 => [
        'pages_management' => [
            'name'  => 'Pages',
            'link'  => 'admin/pages',
            'icon'  => 'oi oi-folder',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'pages'     => [
                    'name'  => 'Pages',
                    'link'  => 'admin/pages',
                    'icon'  => 'oi oi-file',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'pages_add' => [
                    'name'  => 'Add Page',
                    'link'  => 'admin/pages/add',
                    'icon'  => 'oi oi-plus',
                    'roles' => [
                        'administrator'
                    ],
                ],
            ]
        ]
    ]
];