<?php
chdir('../../');
require_once 'autoload.php';
$subjects = new subjects_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) && 
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($subjects->check_code($sanitezed_data['code']))) {

$subjects->store($sanitezed_data);

$utility->setMessage("success", 'Subject registered');
header("location:../subjects");

}else{

$utility->setMessage("warning", 'Subject code is used');
header("location:../subjects");

}
}else{
header("location:../subjects");
}
?>
