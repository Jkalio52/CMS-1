<?php
/**
 * @package   WarpKnot
 */

/**
 * Manage Error Codes
 */
return [
    'routing' => [
        'invalid'     => [
            'message' => 'Invalid request',
            'code'    => '400'
        ],
        'nonexistent' => [
            'message' => 'Invalid request',
            'code'    => '204'
        ],
        'forbidden'   => [
            /**
             * Method not allowed by route
             */
            'not_allowed' => [
                'message' => 'Forbidden. Method not allowed.',
                'code'    => '403'
            ],
            /**
             * In case the method doesn't exist inside the module class
             */
            'not_existed' => [
                'message' => 'Forbidden. Method doesn\'t exist.',
                'code'    => '403'
            ]
        ],
    ]
];