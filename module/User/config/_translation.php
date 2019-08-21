<?php
/**
 * Plugin Translation
 */
return [
    'user' => [
        /**
         * GENERIC
         */
        'invalid_request'       => 'Invalid request',
        'dashboard_redirect'    => 'Redirecting to your dashboard',
        'errors'                => 'Please fix the errors above.',
        'username_used'         => 'This username is already used by someone else.',
        'email_used'            => 'This email is already used by someone else.',
        'invalid_login'         => 'Invalid login details.',
        'recovery_ok'           => 'Further instructions have been sent to your email address.',
        'updated'               => 'Account details updated.',
        'account_created'       => 'Account created successfully.',
        'account_removed'       => 'Account removed successfully.',

        /**
         * Transactional Emails
         */
        'account_recovery_user' => [
            'subject' => 'Account recovery',
            'body'    => 'Hello,<br/><br/>' .
                         'Forgot your password?<br/><br/>' .
                         'To reset your password please follow the link below:<br/><br/>' .
                         '<a href="{SINGLE_LOGIN}">{SINGLE_LOGIN}</a><br/><br/>' .
                         'If you\'re not sure why you\'re receiving this message, you can report it to' .
                         ' us by emailing contact@domain.com.<br/><br/>' .
                         'If you suspect someone may have unauthorized access to your account, ' .
                         'we suggest you change your password as a precaution.<br/><br/>' .
                         'Thanks,<br/>' .
                         '{WEBSITE_URL}',
            'preview' => 'Forgot your password?',
        ],

        /**
         * SEO
         */
        'register'              => [
            'seo_title'       => 'User Register',
            'seo_description' => ''
        ],
        'login'                 => [
            'seo_title'       => 'User Login',
            'seo_description' => ''
        ],
        'recover'               => [
            'seo_title'       => 'User Recover',
            'seo_description' => ''
        ],
        'recover_sli'           => [
            'seo_title'       => 'Single Login',
            'seo_description' => ''
        ],
        'logout'                => [
            'seo_title'       => 'User Logout',
            'seo_description' => ''
        ],
        'admin_list'            => [
            'seo_title'       => 'Users Management',
            'seo_description' => ''
        ],
    ]
];