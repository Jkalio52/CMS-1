<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_INIT;
use _WKNT\_REQUEST;

/**
 * Class DatabaseUpdates
 * @package _MODULE
 */
class DatabaseUpdates extends _INIT
{

    public static $module = 'DatabaseUpdates',
        $moduleAdmin = 'DatabaseUpdates\Admin';


    /**
     * Post Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;
        $data_id = isset(_REQUEST::_POST()['data_id']) ? _REQUEST::_POST()['data_id'] : '';
        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$moduleAdmin . '\\' . $data_id;

        if (method_exists('\\_MODULE\\' . self::$moduleAdmin . '\\' . $data_id, 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['database_updates']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }
}