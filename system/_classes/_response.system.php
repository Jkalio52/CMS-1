<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _RESPONSE extends _INIT
{

    /**
     * Get the response
     */
    static public function _RETURN()
    {
        global $__DIRECTORIES, $_APP_CONFIG;

        /**
         * Set the current route
         */
        _ROUTE::$_CURRENT_ROUTE = _ROUTE::_ROUTE_STATIC_DYNAMIC();

        /**
         * Execute this hook before the route loads
         */
        _HOOK::execute('route_load');

        $_VIEW              = new _TEMPLATE();
        $_VIEW->_APP_CONFIG = $_APP_CONFIG;
        self::$_VIEW        = $_VIEW;
        $_CURRENT_RESPONSE  = self::_LOAD_RESPONSE();
        $_VIEW->_CONTENT    = $_CURRENT_RESPONSE;

        if (isset(_ROUTE::$_CURRENT_ROUTE['local_template']) && !empty(_ROUTE::$_CURRENT_ROUTE['local_template'])):
            $_DIRECTORY = empty(self::$_TEMPLATE_DIRECTORY) ? '' : self::$_TEMPLATE_DIRECTORY;
            $_FILE      = empty(self::$_TEMPLATE_FILE) ? 'default.php' : self::$_TEMPLATE_FILE;
        else:
            echo $_CURRENT_RESPONSE;
            exit();
        endif;

        /**
         * Execute this hook before the render
         */
        _HOOK::execute('before_render');
        if (!empty(self::$_VRS)):
            foreach (self::$_VRS as $_KEY => $_VALUE):
                $_VIEW->$_KEY = $_VALUE;
            endforeach;
        endif;

        $_THEME_LOCATION = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . (empty($_DIRECTORY) ? '' : $_DIRECTORY . DIRECTORY_SEPARATOR);

        /**
         * Set the header and the footer
         */
        if (!isset(self::$_VRS['header'])):
            $_VIEW->header = $_VIEW->render($_THEME_LOCATION . 'partials' . DIRECTORY_SEPARATOR . 'header.php');
        endif;

        if (!isset(self::$_VRS['footer'])):
            $_VIEW->footer = $_VIEW->render($_THEME_LOCATION . 'partials' . DIRECTORY_SEPARATOR . 'footer.php');
        endif;

        echo $_VIEW->render($_THEME_LOCATION . $_FILE);

        // Display the debug variables
        if ($_APP_CONFIG['debug'] && $_SERVER['REQUEST_METHOD'] !== 'POST'):
            echo "<!-- Theme Directory : {$_DIRECTORY} -->\n";
            echo "<!-- Theme File : {$_FILE} -->\n";
        endif;
    }


    /**
     * Validate URI
     * If empty or invalid return 404
     */
    static public function _LOAD_RESPONSE()
    {
        $_URI = _REQUEST::_URI();
        if (empty($_URI['_REQUEST']) || $_URI['_REQUEST'] == '/' || substr($_URI['_REQUEST'], 0, 2) === "/?"):
            /**
             * Execute the front page hook
             */
            _HOOK::execute('front_page');
        else:
            return _ROUTE::_URI_MODULE_VALIDATE();
        endif;
    }

}