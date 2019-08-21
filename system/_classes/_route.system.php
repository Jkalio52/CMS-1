<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;

use _MODULE\_DB;

class _ROUTE extends _INIT
{
    public static $mode, $_CURRENT_ROUTE = [], $_CURRENT_KEY = false;

    /**
     * Validate custom module
     */
    static public function _URI_MODULE_VALIDATE()
    {
        /**
         * Search for the link into the routing_system table
         */
        $route  = new _DB\RoutingSystem();
        $object = $route->search(
            [
                'fields' => [
                    'route' => [
                        'type'  => '=',
                        'value' => _REQUEST::_URI()['_ROUTE']['0']
                    ]
                ]
            ]);
        if (empty($object)):
            if (self::_ROUTE_STATIC_DYNAMIC()):
                return self::_URI_MODULE_STATIC();
            /**
             * Search for a custom page
             */
            else:
                /**
                 * No route
                 */
                _HOOK::execute('page_not_found');
            endif;
        /**
         * Got a route
         */
        else:
            $routeDetails         = $object['0'];
            self::$_CURRENT_ROUTE = [
                'module'         => $routeDetails['module'],
                'namespace'      => $routeDetails['namespace'],
                'action'         => $routeDetails['action'],
                'type'           => $routeDetails['type'],
                'methods'        => $routeDetails['methods'],
                'required_roles' => $routeDetails['required_roles'],
                'local_template' => $routeDetails['local_template'] ? true : false,
                'object'         => $routeDetails
            ];
            return self::_URI_MODULE_STATIC();
        endif;
        return false;
    }

    /**
     * @param $ROUTE
     *
     * @return string
     */
    static public function _ROUTE_STATIC_DYNAMIC()
    {
        return isset(_ROUTE::_LIST()[_REQUEST::_URI()['_ROUTE']['0']]) ? _ROUTE::_LIST()[_REQUEST::_URI()['_ROUTE']['0']] : self::_DYNAMIC_ROUTE();
    }

    static public function _LIST()
    {
        global $_ROUTING;

        return $_ROUTING;
    }

    /**
     * @return mixed
     */
    private static function _DYNAMIC_ROUTE()
    {
        $_URI       = _REQUEST::_URI()['_EXTEND'];
        $_ROUTES    = _ROUTE::_LIST();
        $_URI_COUNT = count($_URI);

        for ($x = 0; $x <= ($_URI_COUNT - 1); $x++):
            $_URI[$_URI_COUNT - $x - 1] = '{var}';

            $_KEY_EXISTS = implode("/", $_URI);
            if (array_key_exists($_KEY_EXISTS, $_ROUTES)):
                self::$_CURRENT_KEY = $_KEY_EXISTS;

                return $_ROUTES[$_KEY_EXISTS];
                exit(0);
            endif;
        endfor;

        return false;
    }

    /**
     * Get the response from the module
     * {@inheritdoc}
     */
    static private function _URI_MODULE_STATIC()
    {
        /**
         * Validate the request mode
         */

        if (self::$_CURRENT_ROUTE):

            $_METHOD      = _REQUEST::_METHOD() . self::$_CURRENT_ROUTE['action'] . _INIT::_ACTION;
            $_MODULE_NAME = '\_MODULE\\' . self::$_CURRENT_ROUTE['namespace'];
            //:: module init
            $_MODULE = new $_MODULE_NAME();

            /**
             * Validate request
             * method + action
             */
            if (method_exists($_MODULE, $_METHOD)):
                return $_MODULE->$_METHOD();
            /**
             * Invalid method, hook
             */
            else:
                _HOOK::execute('invalid_method');
            endif;
        /**
         * check if a dynamic route exist
         */
        else:
            _HOOK::execute('invalid_route');
        endif;

        return false;
    }

    /**
     * Require Authentication
     * {@inheritdoc}
     */
    public static function _REDIRECT($location)
    {
        global $__DIRECTORIES;
        $_APP_CONFIG = _CONFIG::_LOAD(['_FILE_LOCATION' => $__DIRECTORIES['_CONFIG'] . 'application.php']);
        header('Location: ' . $_APP_CONFIG['_DOMAIN_ROOT'] . $location);
    }

}