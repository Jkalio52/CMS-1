<?php
/**
 * @package   WarpKnot
 */

/**
 * Database connection for default plugin
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class SMTPSettings Extends _CRUD
{
    //:: Table name
    protected $table = 'settings_smtp';

    //:: Primary key
    protected $key = 'id';
}
