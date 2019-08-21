<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class UserProfile Extends _CRUD
{
    //:: Table name
    protected $table = 'user_profile';

    //:: Primary key
    protected $key = 'p_uid';
}
