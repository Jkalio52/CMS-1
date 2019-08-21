<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class User Extends _CRUD
{
    //:: Table name
    protected $table = 'user';

    //:: Primary key
    protected $key = 'uid';
}
