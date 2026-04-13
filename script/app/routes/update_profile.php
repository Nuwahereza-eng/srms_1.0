<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;
$students = new students_controller;
$session = new session;

require_once 'includes/session_validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (!empty($profile['role'])) {

if (empty($staff->account($sanitezed_data['email'], $profile['id']))) {

$staff->update($profile['id'], $sanitezed_data);

$utility->setMessage("success", 'Account updated');
header("location:../account");

}else{

$utility->setMessage("warning", 'Email address is already registered');
header("location:../account");

}


}else{

$data['email'] = $sanitezed_data['email'];

$students->update($_POST['id'], $data);

$utility->setMessage("success", 'Account updated');
header("location:../account");

}

}else{
header("location:../account");
}
?>
