<?php
/**
 * @package   WarpKnot
 */

/**
 * Admin Menu
 */
return [
    2000 => [
        'settings' => [
            'name'  => 'Settings',
            'link'  => 'admin/settings',
            'icon'  => 'oi oi-cog',
            'roles' => [
                'administrator'
            ],
            'items' => [
                'website_settings' => [
                    'name'  => 'Website',
                    'link'  => 'admin/settings',
                    'icon'  => 'oi oi-vertical-align-center',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'smtp_settings'    => [
                    'name'  => 'SMTP',
                    'link'  => 'admin/settings/smtp',
                    'icon'  => 'oi oi-envelope-open',
                    'roles' => [
                        'administrator'
                    ],
                ],
                'routing_settings' => [
                    'name'  => 'Routing',
                    'link'  => 'admin/settings/routing',
                    'icon'  => 'oi oi-external-link',
                    'roles' => [
                        'administrator'
                    ],
                ]
            ]
        ]
    ]
];