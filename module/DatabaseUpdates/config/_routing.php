<?php
/**
 * @package   WarpKnot
 */

/**
 * Database routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * Management - Private
     */
    'admin/migrate/post'        => [
        'module'         => 'DatabaseUpdates',
        'namespace'      => 'DatabaseUpdates',
        'action'         => 'Management',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'administrator'
        ],
        'redirect_page'  => '',
        'local_template' => false
    ],

    /**
     * Pending
     */
    'admin/migrate'             => [
        'module'         => 'DatabaseUpdates',
        'namespace'      => 'DatabaseUpdates\Admin',
        'action'         => 'Pending',
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
     * Log
     */
    'admin/migrate/history'             => [
        'module'         => 'DatabaseUpdates',
        'namespace'      => 'DatabaseUpdates\Admin',
        'action'         => 'Log',
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
     * Apply
     */
    'admin/migrate/{var}/{var}' => [
        'module'         => 'DatabaseUpdates',
        'namespace'      => 'DatabaseUpdates\Admin',
        'action'         => 'Migrate',
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
        'local_template' => false
    ],
];