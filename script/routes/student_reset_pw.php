<?php
chdir('../');
require_once 'autoload.php';
$students = new students_controller;
$mail = new smtp_settings_controller;
$school = new school_controller;

$info = $school->index();
$smtp = $mail->index();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/src/Exception.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);
$account = $students->show($sanitezed_data['reg_no']);

if (!empty($account)) {

if ($account['account_status'] == "ENABLED") {

$new_password = $utility->genRandString(8);
$new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

if ((isset($_SERVER['HTTPS']) &&   (($_SERVER['HTTPS'] == 'on'))) || (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] == 443))
{
$actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
else
{
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
$actual_link = str_replace("routes/student_reset_pw.php","",$actual_link);

$msg = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>
<style>
body {
font-family: Arial, sans-serif;
line-height: 1.6;
color: #333333;
margin: 0;
padding: 0;
background-color: #f7f7f7;
}
.container {
max-width: 600px;
margin: 0 auto;
padding: 20px;
}
.email-container {
background-color: #ffffff;
border-radius: 8px;
overflow: hidden;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.header {
background-color: #5438dc;
color: white;
padding: 25px;
text-align: center;
}
.content {
padding: 30px;
}
.password-box {
background-color: #f8f9fa;
border-left: 4px solid #4a86e8;
padding: 15px;
margin: 20px 0;
font-size: 18px;
font-weight: bold;
text-align: center;
}

@media screen and (max-width: 600px) {
.container {
width: 100%;
padding: 10px;
}
.content {
padding: 20px;
}
}
</style>
</head>
<body>
<div class="container">
<div class="email-container">
<div class="header">
<h1>Reset Password</h1>
</div>

<div class="content">
<h2>👋Hello '.$account['first_name'].',</h2>

<p>It seems that you’ve forgotten your password.</p>

<p><b>Registration Number</b> : <mark>'.$account['reg_no'].'</mark></p>
<p><b>New Password</b> : <mark>'.$new_password.'</mark></p>
<p><b>Login Link</b> : <a href="'.$actual_link.'">'.$actual_link.'</a></p>
</div>
</div>
</div>
</body>
</html>
';


$mail = new PHPMailer;
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);

$mail->isSMTP();
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = $smtp['server'];
$mail->SMTPAuth = true;
$mail->Username = $smtp['username'];
$mail->Password = $smtp['password'];
$mail->SMTPSecure = $smtp['encryption'];
$mail->Port = $smtp['port'];

$mail->setFrom($smtp['username'], $info['name']);
$mail->addAddress($account['email']);
$mail->isHTML(true);

$mail->Subject = 'Reset Password';
$mail->Body    = $msg;
$mail->AltBody = $msg;


if(!$mail->send()) {

$utility->setMessage("warning", "Something went wrong");
header("location:../reset_pw");

}else{

$data['hashed_pw'] = $new_password_hashed;
$students->update($account['reg_no'], $data);

$utility->setMessage("success", "Check your email for new password");
header("location:../reset_pw");

}

}else{

$utility->setMessage("warning", 'Your access is revoked');
header("location:../reset_pw");

}
}else{

$utility->setMessage("warning", "Account was not found");
header("location:../reset_pw");

}

}else{
header("location:../reset_pw");
}
?>
