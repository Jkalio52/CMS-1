<?php
/**
 * @package   WarpKnot
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . '_init.php');

if (isset($_DEBUG) && $_DEBUG):
    error_reporting(E_ALL);
endif;

use _WKNT\_RESPONSE;

_RESPONSE::_RETURN();