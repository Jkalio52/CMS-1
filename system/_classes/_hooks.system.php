<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _HOOK extends _INIT
{

    /**
     * @param $hook
     */
    public static function execute($hook)
    {
        foreach (self::modules() as $module):
            if (method_exists('\_MODULE\\' . $module, $module . '_' . $hook)):
                call_user_func_array(
                    array('\_MODULE\\' . $module, $module . '_' . $hook),
                    []
                );
            endif;
        endforeach;
    }

    /**
     * @return array
     */
    public static function modules()
    {
        global $__DIRECTORIES;

        $directories = glob($__DIRECTORIES['_MODULE'] . '*');
        $modules     = [];
        foreach ($directories as $directory):
            if (is_dir($directory)) {
                array_push($modules, basename($directory));
            }
        endforeach;

        return $modules;
    }

}