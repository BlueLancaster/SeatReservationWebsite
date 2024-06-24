<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require_once(__DIR__.'/PHPMailer/src/Exception.php');
require_once(__DIR__.'/PHPMailer/src/PHPMailer.php');
require_once(__DIR__.'/PHPMailer/src/SMTP.php');

$smtp_host = 'smtp.mail.yahoo.com';
$smtp_port = 465;
$smtp_username = 'a3800729612@yahoo.com';
$smtp_password = 'nyxrlriiearuadox';

$sender_email = "a3800729612@yahoo.com";
$sender_name = "Seat Reservation System";

//echo send_email($sender_email, $sender_name,"a3800729679@gmail.com", "blue", "test smtp", "mouse 4234");
function send_email( $recipient_email, $recipient_name, $subject, $body) {

    global $sender_email, $sender_name, $smtp_host, $smtp_port, $smtp_username, $smtp_password;




    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $smtp_host;                             //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $smtp_username;                         //SMTP username
        $mail->Password   = $smtp_password;                         //SMTP password
        $mail->SMTPSecure = 'ssl';                                  //Enable  encryption
        $mail->Port       = $smtp_port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom($sender_email, $sender_name);
        $mail->addAddress($recipient_email, $recipient_name);


        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}