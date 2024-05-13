<?php
/**
 * PHPMailService
 * A simple PHPMailer wrapper
 *
 * @package framework/classes
 * @filesource framework/classes/PHPMailerService.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;
class PHPMailerService
{
    protected $smtp_username = SMTP_USERNAME;
    protected $smtp_password = SMTP_PASSWORD;
    protected $smtp_host = SMTP_HOST;
    protected $smtp_port = SMTP_PORT;
    protected $smtp_secure = 'ssl'; // can be ssl or tls

    protected $sender_email = DEFAULT_EMAIL;
    protected $sender_name = DEFAULT_EMAIL_ACCOUNT_NAME;

    public function __construct()
    {
        if (empty($this->smtp_port)) {
            $this->smtp_port = 465;
        }
    }

    public function send_mail($receipient_emails, $subject, $msg)
    {
        require_once LIBS_DIR . 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        if (USE_SMTP == true) {
            //$mail->SMTPDebug = 3;  // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = $this->smtp_host; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $this->smtp_username; // SMTP username
            $mail->Password = $this->smtp_password; // SMTP password
            $mail->SMTPSecure = $this->smtp_secure; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->smtp_port; // TCP port to connect to
        }

        $mail->From = $this->sender_email;
        $mail->FromName = $this->sender_name;

        if (is_array($receipient_emails)) {
            foreach ($receipient_emails as $email) {
                $mail->addAddress($email); // Add a recipient
            }
        } else {
            $mail->addAddress($receipient_emails); // Add a recipient
        }

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AltBody = strip_tags($msg);
        if ($mail->send()) {
            return true;
        } else {
            return $mail->ErrorInfo;
        }
    }
}
