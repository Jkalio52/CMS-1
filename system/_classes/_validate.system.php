<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _VALIDATE extends _INIT
{
    /**
     * Validate email address
     */
    static public function email($obj)
    {
        return (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $obj)) ? false : true;
    }

    /**
     * Validate external links
     *
     * @access  public
     *
     * @param   $obj
     *
     * @return bool
     */
    static public function external_link($obj)
    {
        $url_host      = parse_url($obj, PHP_URL_HOST);
        $base_url_host = parse_url(HTTP_MASTER, PHP_URL_HOST);
        if ($url_host == $base_url_host || empty($url_host)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Alpha
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    static public function alpha($obj)
    {
        return (!preg_match("/^([a-z])+$/i", $obj)) ? false : true;
    }

    /**
     * Alpha-numeric
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    static public function alpha_numeric($obj)
    {
        return (!preg_match("/^([a-z0-9])+$/i", $obj)) ? false : true;
    }

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    static public function alpha_dash($obj)
    {
        return (!preg_match("/^([-a-z0-9_-])+$/i", $obj)) ? false : true;
    }

    /**
     * Numeric
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    static public function numeric($obj)
    {
        return (bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $obj);
    }

    /**
     * @param $domain
     *
     * @return bool
     */
    public static function isDomainAvailible($domain)
    {
        //check, if a valid url is provided
        if (!filter_var($domain, FILTER_VALIDATE_URL)) {
            return false;
        }

        //initialize curl
        $curlInit = curl_init($domain);
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlInit, CURLOPT_HEADER, true);
        curl_setopt($curlInit, CURLOPT_NOBODY, true);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

        //get answer
        $response = curl_exec($curlInit);

        curl_close($curlInit);
        if ($response) {
            return true;
        }

        return false;
    }

    public static function getDomain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return false;
    }

    /**
     * @param $string
     * @param bool $return_data
     * @return bool|mixed
     */
    public static function is_json($string, $return_data = false)
    {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }

    /**
     * Is Numeric
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function is_numeric($obj)
    {
        return (!is_numeric($obj)) ? false : true;
    }

    /**
     * Integer
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function integer($obj)
    {
        return (bool)preg_match('/^[\-+]?[0-9]+$/', $obj);
    }

    /**
     * Decimal number
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function decimal($obj)
    {
        return (bool)preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $obj);
    }

    /**
     * Greather than
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function greater_than($max, $min)
    {
        if (!is_numeric($max)) {
            return false;
        }

        return $max > $min;
    }

    /**
     * Less than
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function less_than($min, $max)
    {
        if (!is_numeric($min)) {
            return false;
        }

        return $min < $max;
    }

    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @access  public
     *
     * @param string
     *
     * @return  bool
     */
    public function is_natural($obj)
    {
        return (bool)preg_match('/^[0-9]+$/', $obj);
    }

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @access    public
     *
     * @param string
     *
     * @return    bool
     */
    public function is_natural_no_zero($obj)
    {
        if (!preg_match('/^[0-9]+$/', $obj)) {
            return false;
        }

        if ($obj == 0) {
            return false;
        }

        return true;
    }
}