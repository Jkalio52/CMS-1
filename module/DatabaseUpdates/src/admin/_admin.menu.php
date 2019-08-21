<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    1999 => [
        'migrate' => [
            'name'  => 'Database: Migrations',
            'link'  => 'admin/migrate',
            'icon'  => 'oi oi-pulse',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'pending' => [
                    'name'  => 'Pending',
                    'link'  => 'admin/migrate',
                    'icon'  => 'oi oi-pulse',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'migrated' => [
                    'name'  => 'Already Applied',
                    'link'  => 'admin/migrate/history',
                    'icon'  => 'oi oi-clock',
                    'roles' => [
                        'administrator'
                    ],
                ],
            ]
        ]
    ]
];