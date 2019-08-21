<?php
/**
 * @package   WarpKnot
 */

/**
 * Database connection for default plugin
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class WebsiteSettings Extends _CRUD
{
    //:: Table name
    protected $table = 'settings_website';

    //:: Primary key
    protected $key = 'sw_id';
}
