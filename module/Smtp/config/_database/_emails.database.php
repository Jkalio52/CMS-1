<?php
/**
 * @package   WarpKnot
 */

/**
 * Database connection for SMTP plugin
 */

namespace _MODULE\_DB\SMTP;

use _WKNT\_CRUD;

class Emails Extends _CRUD
{
    //:: Table name
    protected $table = 'transactional_emails';

    //:: Primary key
    protected $key = 'human_id';

    //:: Filters
    protected $filters = [];

}
