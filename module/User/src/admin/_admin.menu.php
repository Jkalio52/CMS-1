<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    1000 => [
        'users_management' => [
            'name'  => 'Users',
            'link'  => 'admin/users',
            'icon'  => 'oi oi-people',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'users'     => [
                    'name'  => 'Users',
                    'link'  => 'admin/users',
                    'icon'  => 'oi oi-person',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'users_add' => [
                    'name'  => 'Add User',
                    'link'  => 'admin/users/add',
                    'icon'  => 'oi oi-plus',
                    'roles' => [
                        'administrator'
                    ],
                ],
            ]
        ]
    ]
];