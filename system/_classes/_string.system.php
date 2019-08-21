<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _STRING extends _INIT
{

    /**
     * string
     * limit
     */
    static public function _substr($obj)
    {
        $obj['string'] = _SANITIZE::input($obj['string']);
        $end           = (strlen($obj['string']) > $obj['limit']) ? '...' : '';

        return substr($obj['string'], 0, $obj['limit']) . $end;

    }

}