<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class BlogPost Extends _CRUD
{
    //:: Table name
    protected $table = 'blog_post';

    //:: Primary key
    protected $key = 'bpid';
}
