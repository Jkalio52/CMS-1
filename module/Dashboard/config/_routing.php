<?php
/**
 * @package   WarpKnot
 */

/**
 * Dashboard routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * Dashboard Management - Private
     */
    'admin/post' => [
        'module'         => 'Dashboard',
        'namespace'      => 'Dashboard',
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
     * Dashboard Index - Admin
     */
    'admin'      => [
        'module'         => 'Dashboard',
        'namespace'      => 'Dashboard',
        'action'         => 'Index',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'redirect_page'  => '',
        'local_template' => true
    ],
    /**
     * Dashboard Index - User
     */
    'dashboard'      => [
        'module'         => 'Dashboard',
        'namespace'      => 'Dashboard',
        'action'         => 'UserIndex',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'authenticated'
        ],
        'redirect_page'  => 'user/login',
        'local_template' => true
    ],
    /**
     * Dashboard User Profile
     */
    'user'       => [
        'module'         => 'Dashboard',
        'namespace'      => 'Dashboard',
        'action'         => 'User',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'authenticated'
        ],
        'redirect_page'  => 'user/login',
        'local_template' => true
    ],

];