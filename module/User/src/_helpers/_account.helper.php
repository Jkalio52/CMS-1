<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\User;

use _MODULE\_DB\User;
use _MODULE\_DB\UserStoredData;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;

/**
 * Class _ACCOUNT
 * @package _MODULE\User
 */
class _ACCOUNT
{
    private $account;

    /**
     * _ACCOUNT constructor.
     */
    public function __construct()
    {
        $user          = _SANITIZE::input($_SESSION['user']);
        $this->account = '';
    }

    /**
     * Session Destroy
     */
    public static function _destroySession()
    {
        if (session_id()):
            session_destroy();
        endif;
    }

    /**
     * @param $_SSE
     */
    public static function _setSession($_SSE)
    {
        if (is_array($_SSE) && !empty($_SSE)):
            foreach ($_SSE as $key => $value):
                $_SESSION[$key] = $value;
            endforeach;
        endif;
    }

    /**
     * @param $_SSE
     */
    public static function _updateSession($_SSE)
    {
        $_SESSION[$_SSE['key']] = $_SSE['value'];
    }

    public static function _isAdmin()
    {
        return in_array('administrator', self::_getRoles());
    }

    /**
     * Return an array with the current roles
     */
    public static function _getRoles()
    {
        return (isset($_SESSION['roles']) ? $_SESSION['roles'] : []);
    }

    /**
     * Static Functions
     */
    public static function _loggedIn($_SSE)
    {
        return self::_validateSession($_SSE);
    }

    /**
     * @return bool
     */
    public static function _validateSession($_SSE)
    {
        if (isset($_SESSION[$_SSE])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Password Hash
     */
    public static function _passwordHash($_PASSWORD)
    {
        return hash('sha512', $_PASSWORD);
    }

    /**
     * Current User
     */
    public static function _current()
    {
        $user               = new User();
        $user->connSettings = [
            'key' => 'uid',
        ];

        return $user->search(
            [
                'fields' => [
                    'uid' => [
                        'type'  => '=',
                        'value' => self::_getSession('current_user')['uid']
                    ]
                ],
                'join'   => [
                    'user_profile' => [
                        'mode'    => 'left join',
                        'table'   => 'user_profile',
                        'conn_id' => 'p_uid',
                        'as'      => 'up'
                    ]
                ]
            ])[0];
    }

    /**
     * Return SESSION
     */
    public static function _getSession($_SSE = false)
    {
        if ($_SSE):
            return isset($_SESSION[$_SSE]) ? $_SESSION[$_SSE] : '';
        else:
            return $_SESSION;
        endif;
    }

    /**
     * This table is used to keep a tracking of the data stored for each user
     * When a user will be removed, all this data will be also deleted
     *
     * @param $user_id
     * @param $table_name
     * @param $row_id
     */
    public static function _storedData($user_id, $table_name, $row_id)
    {
        $storedData             = new UserStoredData();
        $storedData->user_id    = isset($user_id) ? $user_id : 0;
        $storedData->table_name = isset($table_name) ? $table_name : null;
        $storedData->row_id     = isset($row_id) ? $row_id : null;
        $storedData->stored_on  = _TIME::_DATE_TIME()['_NOW'];
        $storedData->create();
    }

    /**
     * Return the current user id
     * @return int
     */
    public function _getId()
    {
        return $this->account->id();
    }
}