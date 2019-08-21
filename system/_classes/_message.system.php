<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _MESSAGE extends _INIT
{


    /**
     * Message Set
     *
     * @param $message
     * @param string $type
     */
    public static function set($message, $type = 'secondary')
    {
        $_SESSION['messages'][] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    /**
     * Read all messages
     *
     * @return mixed
     */
    public static function all()
    {
        $messages             = isset($_SESSION['messages']) ? $_SESSION['messages'] : false;
        $_SESSION['messages'] = false;

        return $messages;
    }

}