<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class UserTransactionalEmail Extends _CRUD
{
    //:: Table name
    protected $table = 'user_transactional_emails';

    //:: Primary key
    protected $key = 'human_id';
}
