<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _TIME extends _INIT
{

    /**
     * @return array
     * variables format : strtotime
     * _NOW : time now
     * _START_DATE : start of day
     * _END_DATE : end of day
     * {@inheritdoc}
     */
    static public function _DATE_TIME($_DATA = [])
    {
        /**
         * Set timezone
         */
        $_NOW        = isset($_DATA['_TIME']) ? empty($_DATA['_TIME']) ? strtotime("now") : $_DATA['_TIME'] : strtotime("now");
        $_START_DATE = strtotime("midnight", $_NOW);
        $_END_DATE   = strtotime("tomorrow", $_START_DATE) - 1;

        return [
            '_AGO'              => isset($_DATA['_AGO']) ? strtotime($_DATA['_AGO']) : strtotime("now"),
            '_NOW'              => $_NOW,
            '_START_DATE'       => $_START_DATE,
            '_END_DATE'         => $_END_DATE,
            '_START_DATE_MONTH' => strtotime(date('m/01/Y 00:00:00', $_NOW)),
            '_END_DATE_MONTH'   => strtotime(date('m/t/Y 23:59:59', $_NOW)),
            '_SERVER_TIME_ZONE' => date_default_timezone_get()
        ];
    }

    /**
     * This function will convert date to strtotime
     *
     * @param $_DATA
     *
     * @used parameters : $_DATA['_DATE']
     * @return int
     */
    static public function _DATE_TO_STRTOTIME($_DATA)
    {
        return strtotime($_DATA['_DATE']);
    }

    /**
     * @param $_DATA
     *
     * @used parameters : $_DATA['_DATE']
     * @return bool|string
     */
    static public function _STRTOTIME_TO_DATE($_DATA)
    {
        global $_APP_CONFIG;
        if (empty($_DATA['_DATE'])):
            return '';
        else:
            return date($_APP_CONFIG['_DATE_FORMAT'], $_DATA['_DATE']);
        endif;
    }

    /**
     * @param $_DATA
     *
     * @used parameters : $_DATA['_MODE'], $_DATA['_DATE']
     * @return bool|string
     */
    static public function _DATE_TIME_CONVERT($_DATA)
    {
        global $_APP_CONFIG;
        $_DATA['_MODE'] = isset($_DATA['_MODE']) ? $_DATA['_MODE'] : '_SMALL_DATE';
        $_DATA['_DATE'] = isset($_DATA['_DATE']) ? $_DATA['_DATE'] : strtotime("now");
        switch ($_DATA['_MODE']):
            case '_SMALL_DATE':
                return date($_APP_CONFIG['_DATE_FORMAT'], $_DATA['_DATE']);
                break;
            case '_FULL_DATE':
                return date($_APP_CONFIG['_FULL_DATE_FORMAT'], $_DATA['_DATE']);
                break;
            case '_TIME':
                return date($_APP_CONFIG['_HOUR_FORMAT'], $_DATA['_DATE']);
                break;
        endswitch;

        return false;
    }
}