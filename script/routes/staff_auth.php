<?php
chdir('../');
require_once 'autoload.php';
$staff = new staff_controller;
$session = new session;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);
$account = $staff->account($sanitezed_data['email']);

if (!empty($account)) {

if (password_verify($sanitezed_data['password'], $account['hashed_pw'])) {

if ($account['account_status'] == "ENABLED") {

$session->create_session($account);
header("location:../app/dashboard");

}else{

$utility->setMessage("warning", 'Your access is revoked');
header("location:../staff/login");

}
}else{

$utility->setMessage("warning", 'Invalid login credentials');
header("location:../staff/login");

}

}else{

$utility->setMessage("warning", 'Invalid login credentials');
header("location:../staff/login");

}
}else{
header("location:../staff/login");
}
?>
