<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_CRUD;
use _WKNT\_INIT;
use _WKNT\_TIME;

/**
 * Class RoutingSystem
 * @package _MODULE
 */
class RoutingSystem extends _INIT
{

    /**
     * @param $id
     * @param $route
     * @param $module
     * @param $namespace
     * @param $action
     * @param $type
     */
    public static function update($id, $route, $module, $namespace, $action, $type)
    {
        $routeFind = new _DB\RoutingSystem();
        $object    = $routeFind->search(
            [
                'fields' => [
                    'object_id'   => [
                        'type'  => '=',
                        'value' => $id
                    ],
                    'condition_1' => [
                        'value' => 'and'
                    ],
                    'module'      => [
                        'type'  => '=',
                        'value' => $module
                    ],
                    'condition_2' => [
                        'value' => 'and'
                    ],
                    'namespace'   => [
                        'type'  => '=',
                        'value' => $namespace
                    ],
                    'condition_3' => [
                        'value' => 'and'
                    ],
                    'action'      => [
                        'type'  => '=',
                        'value' => $action
                    ],
                    'condition_4' => [
                        'value' => 'and'
                    ],
                    'type'        => [
                        'type'  => '=',
                        'value' => $type
                    ]
                ]
            ]);
        if (!empty($object)):
            $rid = $object[0]['rid'];

            $routeUpdate               = new _DB\RoutingSystem();
            $routeUpdate->route        = $route;
            $routeUpdate->created_date = _TIME::_DATE_TIME()['_NOW'];
            $routeUpdate->save($rid);
        endif;
    }

    /**
     * @param $id
     * @param $module
     * @param $namespace
     * @param $action
     * @param $type
     */
    public static function delete($id, $module, $namespace, $action, $type)
    {
        $routeFind = new _DB\RoutingSystem();
        $object    = $routeFind->search(
            [
                'fields' => [
                    'object_id'   => [
                        'type'  => '=',
                        'value' => $id
                    ],
                    'condition_1' => [
                        'value' => 'and'
                    ],
                    'module'      => [
                        'type'  => '=',
                        'value' => $module
                    ],
                    'condition_2' => [
                        'value' => 'and'
                    ],
                    'namespace'   => [
                        'type'  => '=',
                        'value' => $namespace
                    ],
                    'condition_3' => [
                        'value' => 'and'
                    ],
                    'action'      => [
                        'type'  => '=',
                        'value' => $action
                    ],
                    'condition_4' => [
                        'value' => 'and'
                    ],
                    'type'        => [
                        'type'  => '=',
                        'value' => $type
                    ]
                ]
            ]);
        if (!empty($object)):
            $rid = $object[0]['rid'];
            $del = new _CRUD();
            $del->deleteFrom('routing_system', 'rid', $rid);
        endif;
    }

}