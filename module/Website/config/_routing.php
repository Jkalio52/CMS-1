<?php
/**
 * @package   WarpKnot
 */

/**
 * Website routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * @administration
     */

    /**
     * Pages Management - Private
     */
    'admin/settings/post'    => [
        'module'         => 'Website',
        'namespace'      => 'Website\Admin',
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
     * Website Settings
     */
    'admin/settings'         => [
        'module'         => 'Website',
        'namespace'      => 'Website\Admin',
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
     * SMTP Settings
     */
    'admin/settings/smtp'    => [
        'module'         => 'Website',
        'namespace'      => 'Website\Admin',
        'action'         => 'SMTP',
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
     * Routing
     */
    'admin/settings/routing' => [
        'module'         => 'Website',
        'namespace'      => 'Website\Admin',
        'action'         => 'Routing',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],
];