<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class BlogPostCategories Extends _CRUD
{
    //:: Table name
    protected $table = 'blog_post_categories';

    //:: Primary key
    protected $key = 'pbc_bpid';
}
