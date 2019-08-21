<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\Dashboard;

use _MODULE\User\_ACCOUNT;
use _WKNT\_CONFIG;
use _WKNT\_INIT;

/**
 * Class _ADMINISTRATOR
 * @package _MODULE\Dashboard
 */
class _ADMINISTRATOR extends _INIT
{
    private static $module = 'Dashboard';

    public static function menu()
    {
        global $__DIRECTORIES;
        if (in_array('administrator', _ACCOUNT::_getRoles())):
            /**
             * Collect all the data from the current modules
             */
            $menu = [];
            foreach (glob($__DIRECTORIES['_MODULE'] . "*") as $module):
                $menuFile = $module . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . '_admin.menu.php';
                if (file_exists($menuFile)):
                    $menuLoad = _CONFIG::_LOAD(['_FILE_LOCATION' => $menuFile]);

                    if (count($menuLoad) > 1):
                        foreach ($menuLoad as $mKey => $mItem):
                            $menu[$mKey] = $menuLoad[$mKey];
                        endforeach;
                    else:
                        $menu[key($menuLoad)] = $menuLoad[key($menuLoad)];
                    endif;
                endif;
            endforeach;

            ksort($menu);

            return self::menuRender($menu);
        else:
            foreach (_ACCOUNT::_getRoles() as $role):
                if ($role !== 'administrator'):
                    /**
                     * Collect all the data from the current modules
                     */
                    $menu = [];
                    foreach (glob($__DIRECTORIES['_MODULE'] . "*") as $module):
                        $menuFile = $module . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $role . DIRECTORY_SEPARATOR . '_' . $role . '.menu.php';
                        if (file_exists($menuFile)):
                            $menuLoad = _CONFIG::_LOAD(['_FILE_LOCATION' => $menuFile]);

                            if (count($menuLoad) > 1):
                                foreach ($menuLoad as $mKey => $mItem):
                                    $menu[$mKey] = $menuLoad[$mKey];
                                endforeach;
                            else:
                                $menu[key($menuLoad)] = $menuLoad[key($menuLoad)];
                            endif;
                        endif;
                    endforeach;

                    ksort($menu);

                    return self::menuRender($menu);
                endif;
            endforeach;
        endif;
    }

    public static function menuRender($menu)
    {
        self::$_VIEW->menuItems = $menu;
        self::$_VIEW->roles     = _ACCOUNT::_getRoles();
        $render                 = selfRender(self::$module, in_array('administrator', _ACCOUNT::_getRoles()) ? 'render/_admin.menu.php' : 'render/_user.menu.php');

        return $render;
    }
}