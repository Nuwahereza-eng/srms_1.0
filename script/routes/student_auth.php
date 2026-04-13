<?php
chdir('../');
require_once 'autoload.php';
$students = new students_controller;
$session = new session;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);
$account = $students->show($sanitezed_data['reg_no']);

if (!empty($account)) {

if (password_verify($sanitezed_data['password'], $account['hashed_pw'])) {

if ($account['account_status'] == "ENABLED") {

$session->create_session($account);
header("location:../app/home");

}else{

$utility->setMessage("warning", 'Your access is revoked');
header("location:../");

}
}else{

$utility->setMessage("warning", 'Invalid login credentials');
header("location:../");

}

}else{

$utility->setMessage("warning", 'Invalid login credentials');
header("location:../");

}
}else{
header("location:../");
}
?>
