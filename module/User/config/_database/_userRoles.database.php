<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class UserRoles Extends _CRUD
{
    //:: Table name
    protected $table = 'user_roles';

    //:: Primary key
    protected $key = 'ur_uid';
}
