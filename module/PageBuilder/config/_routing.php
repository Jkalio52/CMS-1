<?php
/**
 * @package   WarpKnot
 */

/**
 * Routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * @contentBuilder Only
     */
    /**
     * Groups List
     */
    'admin/page-builder'                    => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'Objects',
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
     * Group Add
     */
    'admin/page-builder/group'              => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'AddGroup',
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
     * Group Edit
     */
    'admin/page-builder/edit/{var}'         => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'EditGroup',
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
     * Group Export
     */
    'admin/page-builder/export/{var}'       => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'ExportGroup',
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
     * Page Builder Widget
     */
    'admin/page-builder/object'             => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'AddObject',
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
     * Object Edit
     */
    'admin/page-builder/objects/edit/{var}' => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'EditObject',
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
     * Page Builder Widgets
     */
    'admin/page-builder/objects'            => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\Admin',
        'action'         => 'ListObjects',
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
     * Data Post
     */
    'admin/page-builder/post'               => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder',
        'action'         => 'Management',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'administrator'
        ]
    ],

    /**
     * @formsBuilder only
     */
    /**
     * Forms
     */
    'admin/forms'                           => [
        'module'         => 'PageBuilder',
        'namespace'      => 'FormsBuilder\Admin',
        'action'         => 'ListObjects',
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
     * Form Add
     */
    'admin/forms/add'                       => [
        'module'         => 'PageBuilder',
        'namespace'      => 'FormsBuilder\Admin',
        'action'         => 'AddObject',
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
     * Form Edit
     */
    'admin/forms/edit/{var}'                => [
        'module'         => 'PageBuilder',
        'namespace'      => 'FormsBuilder\Admin',
        'action'         => 'EditObject',
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
    'admin/forms/records/{var}'             => [
        'module'         => 'PageBuilder',
        'namespace'      => 'FormsBuilder\Admin',
        'action'         => 'FormData',
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
     * Form Save
     */
    'form/post'                             => [
        'module'         => 'PageBuilder',
        'namespace'      => 'PageBuilder\_FORM',
        'action'         => 'FormStore',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => []
    ],
];