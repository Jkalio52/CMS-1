<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class UserStoredData Extends _CRUD
{
    //:: Table name
    protected $table = 'user_stored_data';

    //:: Primary key
    protected $key = 'uid';
}
