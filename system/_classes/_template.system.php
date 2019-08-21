<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;

use Exception;

class _TEMPLATE extends _INIT
{
    public $vars = array();

    /**
     * Get the variable
     *
     * @param $_VAR
     *
     * @return mixed
     */
    public function __get($_VAR)
    {
        return $this->vars[$_VAR];
    }

    /**
     * @param $_VAR
     * @param $_VALUE
     *
     * @throws Exception
     */
    public function __set($_VAR, $_VALUE)
    {
        if ($_VAR == 'view_template_file') {
            throw new Exception("Cannot bind variable named 'view_template_file'");
        }
        $this->vars[$_VAR] = $_VALUE;
    }

    /**
     * @return array
     */
    public function _VARS()
    {
        return $this->vars;
    }

    /**
     * @param $buf
     * @return mixed
     */
    function ob_html_compress($buf)
    {
        return preg_replace(
            ['/<!--(.*)-->/Uis', "/[[:blank:]]+/"], ['', ' '], str_replace(["\n", "\r", "\t"], '', $buf));
    }

    /**
     * @param $_TEMPLATE_FILE
     *
     * @return false|string
     * @throws Exception
     */
    public function render($_TEMPLATE_FILE)
    {
        global $_APP_CONFIG;
        if (array_key_exists('view_template_file', $this->vars)) {
            throw new Exception("Cannot bind variable called 'view_template_file'");
        }

        extract($this->vars);
        if ($_APP_CONFIG['html_minify']):
            ob_start(['self', 'ob_html_compress']);
        else:
            ob_start();
        endif;
        if (file_exists($_TEMPLATE_FILE) && !is_dir($_TEMPLATE_FILE)):
            include($_TEMPLATE_FILE);
            $_LOAD = ob_get_contents();
            /**
             * Use ShortTags
             */
            // $_LOAD = preg_replace( '~\{\$(\w+?)\}~sUe', '${"$1"}', $_LOAD );
            ob_get_clean();

            return $_APP_CONFIG['html_minify'] ? self::ob_html_compress($_LOAD) : $_LOAD;
        else:
            return '';
        endif;
    }

}