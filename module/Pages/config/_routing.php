<?php
/**
 * @package   WarpKnot
 */

/**
 * Pages routing system
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
    'admin/pages/post'       => [
        'module'         => 'Pages',
        'namespace'      => 'Pages\Admin',
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
     * Pages List
     */
    'admin/pages'            => [
        'module'         => 'Pages',
        'namespace'      => 'Pages\Admin',
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
     * Add new pages
     */
    'admin/pages/add'        => [
        'module'         => 'Pages',
        'namespace'      => 'Pages\Admin',
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
     * Page Update
     */
    'admin/pages/edit/{var}' => [
        'module'         => 'Pages',
        'namespace'      => 'Pages\Admin',
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
];