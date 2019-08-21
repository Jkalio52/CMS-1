<?php
/**
 * @package   WarpKnot
 */

/**
 * User routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * User Management - Public
     */
    'user/post'                => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Management',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => false
    ],

    /**
     * User Register
     */
    'user/register'            => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Register',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => true
    ],

    /**
     * User Login
     */
    'user/login'               => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Login',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => true
    ],

    /**
     * User Recover
     */
    'user/recover'             => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Recover',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => true
    ],

    /**
     * User Logout
     */
    'user/logout'              => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Logout',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => true,
        'template'       => false
    ],

    /**
     * User Login Recovery
     */
    'login/sli/{var}/{var}'    => [
        'module'         => 'User',
        'namespace'      => 'User',
        'action'         => 'Sli',
        'type'           => 'dynamic',
        'variables'      => [
            '{id}',
            '{auth}'
        ],
        'methods'        => [
            'get'
        ],
        'required_roles' => false,
        'redirect_page'  => '',
        'local_template' => true,
    ],

    /**
     * @administration
     */

    /**
     * User Management - Private
     */
    'admin/user/post'          => [
        'module'         => 'User',
        'namespace'      => 'User\Admin',
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
     * Users List
     */
    'admin/users'              => [
        'module'         => 'User',
        'namespace'      => 'User\Admin',
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
     * Add new user
     */
    'admin/users/add'          => [
        'module'         => 'User',
        'namespace'      => 'User\Admin',
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
     * User Update
     */
    'admin/users/edit/{var}'   => [
        'module'         => 'User',
        'namespace'      => 'User\Admin',
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
     * User Delete
     */
    'admin/users/delete/{var}' => [
        'module'         => 'User',
        'namespace'      => 'User\Admin',
        'action'         => 'Delete',
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
];