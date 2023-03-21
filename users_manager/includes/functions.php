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
        $mail->setFrom('tangocdai13@gmail.com', 'TEST PROJECT CRUD');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
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

//Kiểm tra phương thức POST
function isPost() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }

    return false;
}
//Kiểm tra phương thức GET
function isGet() {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }

    return false;
}
//Lấy giá trị phương thức POST
function getBody() {
    if (isGet()) {
        $bodyArr = [];
        if (!empty($_GET)) {
            foreach ($_GET as $key=>$value) {
                $key = strip_tags($key);
                if (is_array($value)) { //trường hợp value là 1 mảng thì sẽ được chấp nhận
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS,
                                                                        FILTER_REQUIRE_ARRAY);
                }else {
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $bodyArr;
    }

    if (isPost()) {
        $bodyArr = [];
        if (!empty($_POST)) {
            foreach ($_POST as $key=>$value) {
                $key = strip_tags($key);
                if (is_array($value)) { //trường hợp value là 1 mảng thì sẽ được chấp nhận
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS,
                        FILTER_REQUIRE_ARRAY);
                }else {
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $bodyArr;
    }
}

//kiểm tra Email
function isEmail($email) {
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

    return $checkEmail;
}

//Kiểm tra số nguyên
function isNumberInt($number, $range=[]) {
    /*
     * $range = ['min_range' => 1, 'max_range' => 20];
     *
     * */
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $options);
    }else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }

    return $checkNumber;
}

//Kiểm tra Float
function isNumberFloat($number, $range=[]) {
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    }else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    }

    return $checkNumber;
}

//Kiểm tra số điện thoại
function isPhone($phone) {
    $checkFirstPhone = false;
    if ($phone[0] == 0) {
        $checkFirstPhone = true;
        $phone = substr($phone, 1);
    }
    $checkPhone = false;
    if (isNumberInt($phone) && strlen($phone) == 9) {
        $checkPhone = true;
    }

    if ($checkFirstPhone && $checkPhone) {
        return true;
    }

    return false;
}

//Hàm tạo thông báo
function msgFlash($msg, $type='success') {
    if (!empty($msg)) {
        echo '<div class="alert alert-'.$type.'">';
        echo $msg;
        echo '</div>';
    }
}

function redirect($path='') {
    header("location: $path");
    exit();
}

//Hàm thông báo lỗi
function form_error($fieldName, $errors, $beforeHtml='', $afterHtml='') {
    return (!empty($errors[$fieldName])) ? $beforeHtml.reset($errors[$fieldName]).$afterHtml : false;
}

//Hàm hiển thị lại dữ liệu
function old($oldData, $fieldName, $default=false) {
    return (!empty($oldData[$fieldName])) ? $oldData[$fieldName] : $default;
}