<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _FIREBASE extends _INIT
{

    public static function _PUSH($_DATA = [])
    {
        /**
         * Variables
         * data.message
         * data.title
         * data.image
         * data.id
         * data.mode : notification / update
         * data.color : down / up / slow
         *
         * extra
         * data.google.message_id
         * data.coldstart
         * data.collapse_key
         * data.foreground
         */

        // prep the bundle
        $msg    = array
        (
            'vibrate'     => $_DATA['vibrate'],
            'sound'       => isset($_DATA['sound']) ? $_DATA['sound'] : '',
            'soundname'   => isset($_DATA['soundname']) ? $_DATA['soundname'] : '',
            'style'       => isset($_DATA['style']) ? $_DATA['style'] : '',
            'image'       => isset($_DATA['image']) ? $_DATA['image'] : '',
            'icon'        => isset($_DATA['icon']) ? $_DATA['icon'] : '',
            'smallIcon'   => isset($_DATA['smallIcon']) ? $_DATA['smallIcon'] : '',
            'iconColor'   => isset($_DATA['iconColor']) ? $_DATA['iconColor'] : '',
            'autoClear'   => isset($_DATA['autoClear']) ? $_DATA['autoClear'] : '',
            'color'       => isset($_DATA['color']) ? $_DATA['color'] : '',
            'notId'       => isset($_DATA['id']) ? $_DATA['id'] : '',
            'id'          => isset($_DATA['id']) ? $_DATA['id'] : '',
            'title'       => isset($_DATA['title']) ? $_DATA['title'] : '',
            'message'     => isset($_DATA['message']) ? $_DATA['message'] : '',
            'summaryText' => isset($_DATA['summaryText']) ? $_DATA['summaryText'] : '',
            'ledColor'    => isset($_DATA['ledColor']) ? $_DATA['ledColor'] : '',
            'mode'        => isset($_DATA['mode']) ? $_DATA['mode'] : '',
        );
        $fields = array
        (
            'to'   => $_DATA['phone'],
            'data' => $msg
        );

        $headers = array
        (
            'Authorization: key=' . $_DATA['_FIREBASE_ACCESS_KEY'],
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}