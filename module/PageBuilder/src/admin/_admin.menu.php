<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    400 => [
        'page_builder_management' => [
            'name'  => 'Page Builder',
            'link'  => 'admin/page-builder',
            'icon'  => 'oi oi-layers',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'groups'  => [
                    'name'  => 'Groups',
                    'link'  => 'admin/page-builder',
                    'icon'  => 'oi oi-project',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'objects' => [
                    'name'  => 'Widgets',
                    'link'  => 'admin/page-builder/objects',
                    'icon'  => 'oi oi-layers',
                    'roles' => [
                        'administrator'
                    ],
                ],
            ]
        ]
    ],
    500 => [
        'forms_management' => [
            'name'  => 'Forms Builder',
            'link'  => 'admin/forms',
            'icon'  => 'oi oi-spreadsheet',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'forms'     => [
                    'name'  => 'Forms',
                    'link'  => 'admin/forms',
                    'icon'  => 'oi oi-tablet',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'forms_add' => [
                    'name'  => 'Add Form',
                    'link'  => 'admin/forms/add',
                    'icon'  => 'oi oi-plus',
                    'roles' => [
                        'administrator'
                    ],
                ],
            ]
        ]
    ]
];