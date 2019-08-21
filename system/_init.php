<?php
/**
 * @package   WarpKnot
 */

use _WKNT\_CONFIG;

if (session_id() == '') {
    //session has not started
    session_start();
}
/**
 * Load the local configuration file
 */
$__DIRECTORIES = [
    '_ROOT'               => dirname(__FILE__) . DIRECTORY_SEPARATOR,
    '_CONFIG'             => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR,
    '_MODULE'             => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR,
    '_UPLOADS'            => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR,
    '_CLASSES'            => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR,
    '_LOGS'               => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR,
    '_CRONS'              => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../_crons' . DIRECTORY_SEPARATOR,

    /**
     * Theme directory
     */
    '_THEME'              => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR,

    /**
     * Load Module Config Files
     */
    '_MODULE_CONFIG'      => DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_config.php',
    '_MODULE_DATABASE'    => DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_database' . DIRECTORY_SEPARATOR . '*',
    '_MODULE_CLASS_FILE'  => DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Module.php',
    '_MODULE_ROUTE'       => DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_routing.php',
    '_MODULE_TRANSLATION' => DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_translation.php',
];

/**
 * System initialization
 */
require_once $__DIRECTORIES['_ROOT'] . '_wknt.class.php';
foreach (glob($__DIRECTORIES['_ROOT'] . '_classes' . DIRECTORY_SEPARATOR . "*.system.php") as $filename):
    require_once $filename;
endforeach;


/**
 * Configs load
 */
//:: APP CONFIG
$_APP_CONFIG = _CONFIG::_LOAD(['_FILE_LOCATION' => $__DIRECTORIES['_CONFIG'] . 'application.php']);

//:: SETTINGS
$_APP_SETTINGS = _CONFIG::_LOAD(['_FILE_LOCATION' => $__DIRECTORIES['_CONFIG'] . 'settings.php']);

//:: DEBUG ON/OFF
$_DEBUG = $_APP_CONFIG['debug'];
/**
 * Set the timezone
 */
if (!empty($_APP_CONFIG['_TIMEZONE'])):
    date_default_timezone_set($_APP_CONFIG['_TIMEZONE']);
endif;

//:: Error Codes
$_ERROR_CODES = _CONFIG::_LOAD(['_FILE_LOCATION' => $__DIRECTORIES['_CONFIG'] . 'error.codes.php']);

//:: DEFAULT DB
$_DATABASE = _CONFIG::_LOAD(['_FILE_LOCATION' => $__DIRECTORIES['_CONFIG'] . 'database.php']);

/**
 * Load helpers
 */
foreach (glob($__DIRECTORIES['_ROOT'] . '_classes' . DIRECTORY_SEPARATOR . '_helpers' . DIRECTORY_SEPARATOR . "*.helper.php") as $filename):
    require_once $filename;
endforeach;

/**
 * Database INIT
 */
if (!empty($_DATABASE)):
    foreach ($_DATABASE as $key => $_DB):
        $_CONN[$key] = new DB(
            [
                "_DB_HOSTNAME" => $_DB['hostname'],
                "_DB_USERNAME" => $_DB['username'],
                "_DB_PASSWORD" => $_DB['password'],
                "_DB_DATABASE" => $_DB['database'],
                "_DB_CHARSET"  => $_DB['charset']
            ]);
    endforeach;
endif;

/**
 * Load available modules
 */
$_ROUTING     = [];
$_TRANSLATION = [];
foreach (glob($__DIRECTORIES['_MODULE'] . "*") as $module):
    $_ROUTE    = [];
    $_CONFIG   = [];
    $_LANGUAGE = [];

    /**
     * Load custom configuration, like database connection
     */
    if (file_exists($module . $__DIRECTORIES['_MODULE_CONFIG'])):
        $_CONFIG = _CONFIG::_LOAD(['_FILE_LOCATION' => $module . $__DIRECTORIES['_MODULE_CONFIG']]);
    endif;

    /**
     * Load table name and set the primary key
     */
    $_CONNECTION = isset($_CONFIG['database']['default']) ? $_CONN[$_CONFIG['database']['default']] : isset($_CONN['default']) ? $_CONN['default'] : false;

    foreach (glob($module . $__DIRECTORIES['_MODULE_DATABASE']) as $module_db):
        require_once $module_db;
    endforeach;

    /**
     * Main module class
     */
    if (file_exists($module . $__DIRECTORIES['_MODULE_CLASS_FILE'])):
        require_once $module . $__DIRECTORIES['_MODULE_CLASS_FILE'];
    endif;

    /**
     * Module Helpers
     */
    foreach (glob($module . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . '_helpers' . DIRECTORY_SEPARATOR . "*.helper.php") as $filename):
        require_once $filename;
    endforeach;

    /**
     * Module routing with response codes
     */
    if (file_exists($module . $__DIRECTORIES['_MODULE_ROUTE'])):
        $_ROUTE = _CONFIG::_LOAD(['_FILE_LOCATION' => $module . $__DIRECTORIES['_MODULE_ROUTE']]);
    endif;
    $_ROUTING = array_merge($_ROUTING, $_ROUTE);

    /**
     * Load the default translation
     */
    if (file_exists($module . $__DIRECTORIES['_MODULE_ROUTE'])):
        $_LANGUAGE = _CONFIG::_LOAD(['_FILE_LOCATION' => $module . $__DIRECTORIES['_MODULE_TRANSLATION']]);
        if (is_array($_LANGUAGE)):
            $_TRANSLATION = array_merge($_TRANSLATION, $_LANGUAGE);
        endif;

        /**
         * Overwrite the current translation
         */

        $_OVERWRITE_TRANSLATION_FILE = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . basename($module) . '.php';
        if (file_exists($_OVERWRITE_TRANSLATION_FILE)):
            $_LANGUAGE = _CONFIG::_LOAD(['_FILE_LOCATION' => $_OVERWRITE_TRANSLATION_FILE]);
            if (is_array($_LANGUAGE)):
                $_TRANSLATION = array_merge($_TRANSLATION, $_LANGUAGE);
            endif;
        endif;
    endif;
endforeach;

/**
 * Generic functions include
 */
if (file_exists($__DIRECTORIES['_ROOT'] . '_functions.php')):
    require_once $__DIRECTORIES['_ROOT'] . '_functions.php';
endif;

/**
 * Custom generic functions include
 */
$functionsPHP = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . '_functions.php';
if (file_exists($functionsPHP)):
    require_once $functionsPHP;
endif;