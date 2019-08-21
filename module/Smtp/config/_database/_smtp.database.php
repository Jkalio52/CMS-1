<?php
/**
 * @package   WarpKnot
 */

/**
 * Database connection for SMTP plugin
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

/**
 * Class SMTP
 * @package _MODULE\_DB
 */
class SMTP Extends _CRUD
{
    //:: Table name
    protected $table = 'settings_smtp';

    //:: Primary key
    protected $key = 'id';

    //:: Filters
    protected $filters = [];

}
