<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class BlogPostDetails Extends _CRUD
{
    //:: Table name
    protected $table = 'blog_post_details';

    //:: Primary key
    protected $key = 'bpd_bpid';
}
