<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class BlogCategories Extends _CRUD
{
    //:: Table name
    protected $table = 'blog_categories';

    //:: Primary key
    protected $key = 'bcid';
}
