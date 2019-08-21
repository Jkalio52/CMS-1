<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class BlogSettings Extends _CRUD
{
    //:: Table name
    protected $table = 'blog_settings';

    //:: Primary key
    protected $key = 'bsid';
}
