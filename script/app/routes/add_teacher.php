<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($staff->account($sanitezed_data['email']))) {

$data['first_name'] = $sanitezed_data['first_name'];
$data['last_name'] = $sanitezed_data['last_name'];
$data['gender'] = $sanitezed_data['gender'];
$data['email'] = $sanitezed_data['email'];
$data['hashed_pw'] = password_hash(strtoupper($data['first_name'].$data['last_name']), PASSWORD_BCRYPT);
$data['account_status'] = $sanitezed_data['account_status'];

$staff->store($data);

$utility->setMessage("success", 'Teacher registered');
header("location:../teachers");

}else{

$utility->setMessage("warning", 'Email address is already registered');
header("location:../teachers");

}
}else{
header("location:../teachers");
}
?>
