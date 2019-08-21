<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _WKNT\_INIT;

//Load Composer's autoloader
require_once dirname(__FILE__) . '/_lib/vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class SMTP
 * @package _MODULE
 */
class SMTP extends _INIT
{

    /**
     * Email management
     *
     * @param $_DATA
     * $_DATA['to'];
     * $_DATA['subject'];
     * $_DATA['body'];
     *
     * @return bool|string
     */
    public static function _SEND($_DATA)
    {

        /**
         * Get the current SMTP
         * $_DATA['to']
         * $_DATA['subject']
         * $_DATA['body']
         * $_DATA['text_body']
         *
         */
        $smtp  = new _DB\SMTP();
        $_SMTP = $smtp->search([]);

        if (!empty($_SMTP)):
            $mail = new PHPMailer(false);  // Passing `true` enables exceptions
            try {
                $mail->clearAllRecipients();
                $mail->clearAddresses();
                //Server settings

                // Enable verbose debug output
                $mail->SMTPDebug = isset($_DATA['debug']) ? $_DATA['debug'] : 0;


                // Specify main and backup SMTP servers
                $mail->Host = $_SMTP['0']['hostname'];

                // Enable SMTP authentication
                if (empty($_SMTP['0']['username']) or empty($_SMTP['0']['password'])):
                    $mail->SMTPAuth = false;
                else:
                    // Set mailer to use SMTP
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
                endif;

                // SMTP username
                if (!empty($_SMTP['0']['username'])) {
                    $mail->Username = $_SMTP['0']['username'];
                }

                // SMTP password
                if (!empty($_SMTP['0']['password'])) {
                    $mail->Password = $_SMTP['0']['password'];
                }

                // Enable TLS encryption, `ssl` also accepted
                $mail->SMTPSecure = $_SMTP['0']['tls'] ? 'tls' : 'ssl';

                // TCP port to connect to
                if (!empty($_SMTP['0']['port'])) {
                    $mail->Port = $_SMTP['0']['port'];
                }

                //Recipients
                $mail->setFrom($_SMTP['0']['noreply_email'], $_SMTP['0']['noreply_name']);
                $mail->addAddress($_DATA['to'], '');     // Add a recipient

                //Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = $_DATA['subject'];
                $mail->Body    = $_DATA['body'];
                $mail->AltBody = $_DATA['text_body'];
                $mail->send();
                return true;
            } catch (Exception $e) {
                return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }

        endif;

    }
}