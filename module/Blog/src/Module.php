<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_INIT;
use _WKNT\_REQUEST;
use function json_encode;

/**
 * Class Blog
 * @package _MODULE
 */
class Blog extends _INIT
{

    private static $module = 'Blog';

    /**
     * @return string
     */
    public static function blogSlug()
    {
        return 'blog' . DIRECTORY_SEPARATOR;
    }

    /**
     * Blog Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;

        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'];
        if (method_exists('\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'], 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['user']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}