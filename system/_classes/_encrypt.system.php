<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
use Exception;

class _ENCRYPT extends _INIT
{
    const
        _SECRET_IV = 'KJASLK@J#KA#15ASJ',
        _ENCRYPT_METHOD = "AES-256-CBC";

    public static function _ENCRYPT($_DATA)
    {
        //:: hash
        $_KEY = hash('sha256', $_DATA['_SECRET']);

        //:: iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $_IV = substr(hash('sha256', self::_SECRET_IV), 0, 16);

        return base64_encode(openssl_encrypt($_DATA['_STRING'], self::_ENCRYPT_METHOD, $_KEY, 0, $_IV));
    }

    public static function _DECRYPT($_DATA = [])
    {
        //:: hash
        $_KEY = hash('sha256', $_DATA['_SECRET']);
        //:: iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $_IV = substr(hash('sha256', self::_SECRET_IV), 0, 16);

        return openssl_decrypt(base64_decode($_DATA['_STRING']), self::_ENCRYPT_METHOD, $_KEY, 0, $_IV);
    }


    /**
     * @param array $_DATA
     *
     * @return string
     * @throws Exception
     */
    public static function _HASH_CODE($_DATA = [])
    {
        $length = isset($_DATA['length']) ? $_DATA['length'] : 16;

        if (function_exists('random_bytes')):
            $tokenParts = [];
            if (isset($_DATA['parts'])):
                for ($x = 0; $x < $_DATA['parts']; $x++):
                    $tokenParts[] = bin2hex(random_bytes($length));
                endfor;
                $token = implode("-", $tokenParts);
            else:
                $token = bin2hex(random_bytes($length));
            endif;
        else:
            $tokenParts = [];
            if (isset($_DATA['parts'])):
                for ($x = 0; $x < $_DATA['parts']; $x++):
                    $tokenParts[] = bin2hex(openssl_random_pseudo_bytes($length));
                endfor;

                $token = implode("-", $tokenParts);
            else:
                $token = bin2hex(openssl_random_pseudo_bytes($length));
            endif;
        endif;

        return $token;
    }


}