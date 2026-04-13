<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($staff->account($sanitezed_data['email'], $_POST['id']))) {

$staff->update($_POST['id'], $sanitezed_data);

$utility->setMessage("success", 'Teacher updated');
header("location:../teachers");

}else{

$utility->setMessage("warning", 'Email address is already registered');
header("location:../teachers");

}
}else{
header("location:../teachers");
}
?>
