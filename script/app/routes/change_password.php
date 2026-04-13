<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;
$students = new students_controller;
$session = new session;

require_once 'includes/session_validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

if (password_verify($_POST['current_pw'], $profile['hashed_pw'])) {

if (!empty($profile['role'])) {

$data['hashed_pw'] = password_hash($_POST['new_pw'], PASSWORD_BCRYPT);
$staff->update($profile['id'], $data);

}else{

$data['hashed_pw'] = password_hash($_POST['new_pw'], PASSWORD_BCRYPT);
$students->update($profile['reg_no'], $data);

}

$utility->setMessage("success", 'Password updated');
header("location:../account");

}else{

$utility->setMessage("warning", 'Current password is not correct');
header("location:../account");

}
}else{
header("location:../account");
}
?>
