<?php
if (!defined('_INCODE')) die('Access Deined...');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layout($layoutName = 'header', $data = []) {
    if (file_exists(_WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php')) {
        require_once _WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php';
    }else {
        echo 'file not exists';
    }
}

function sendMail($to, $subject, $content) {
//Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tangocdai13@gmail.com';                     //SMTP username
        $mail->Password   = 'vvomsmauybsamlph';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tangocdai13@gmail.com', 'TND Training');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; //mang yeu thi hien thi noi dung nay
//        $mail->IsSMTP();
//        $mail->Host = "smtp.gmail.com";
//        $mail->SMTPAuth = true;
//        $mail->SMTPSecure = "ssl";
//        $mail->Username = "myemail@gmail.com";
//        $mail->Password = "**********";
//        $mail->Port = "465";
        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}