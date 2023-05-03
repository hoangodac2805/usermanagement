<?php
if (!defined('_INCODE'))
    die('Access Dined...');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function showr($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
function layout($layoutName = 'header', $data = [])
{
    if (file_exists(require_once _WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php';
    }
}
function sendMail($mailTo, $subject, $content)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'hoangodac2805@gmail.com'; //SMTP username
        $mail->Password = 'yrsuqrxqhmjkeqmb'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('hoangodac2805@gmail.com', 'Chapter04');
        $mail->addAddress($mailTo); //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->CharSet ='UTF-8';
        $mail->Subject = $subject;
        $mail->Body = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
//Kiểm tra phương thức POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

//Kiểm tra phương thức GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}
//Lấy giá trị phương thức POST,GET
function getBody()
{
    $bodyArr = [];
    if (isGet()) {
        //Xử lý chuỗi trước khi hiển thị ra
        // return $_GET;
        //Đọc key của mảng $_GET
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);

                }
            }
        }

    }
    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);

                }
            }
        }
    }
    return $bodyArr;
}

//Kiểm tra email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}
function isNumberInt($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}
//Kiểm tra số thực
function isNumberFloat($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    }
    return $checkNumber;
}
//kiểm tra số điện thoại- 10 số và bắt đầu bằng số 0
function isPhone($phone)
{
    $checkFirstZero = false;
    if ($phone[0] == '0') {
        $checkFirstZero = true;
        $phone = substr($phone, 1);
    }

    $checkNumberLast = false;
    if (isNumberInt($phone && strlen($phone) == 9)) {
        $checkNumberLast = true;
    }
    if ($checkFirstZero && $checkNumberLast) {
        return true;
    }
    return false;
}
function getMsg($msg, $type = 'success')
{
    if (!empty($msg)) {
        echo '<div class="alert alert-' . $type . '">' . $msg . '</div>';
    }
}
function redirect($path = 'index.php')
{
    header("Location:$path");
    exit;
}
function form_error($fieldName,$errors,$beforeHtml='',$afterHtml=''){
    if (isset($errors[$fieldName])){
       echo '<span class="text-danger">';
             echo reset($errors[$fieldName]) ;
       echo '</span>';
    };
}
function old($fieldName,$oldData,$default = null){
    return (!empty($oldData[$fieldName]) ? $oldData[$fieldName] : $default);
}
?>