<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _CONFIG extends _INIT
{

    /**
     * Load configuration file
     *
     * @param array $_DATA
     *
     * @return array|mixed
     */
    static public function _LOAD($_DATA = [])
    {
        if (file_exists($_DATA['_FILE_LOCATION'])) {
            return require $_DATA['_FILE_LOCATION'];
        } else {
            return [];
        }
    }
}