<?php
chdir('../../');
require_once 'autoload.php';
$school = new school_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$data['name'] = $sanitezed_data['name'];
$data['phone_1'] = $sanitezed_data['phone_1'];
$data['phone_2'] = empty($sanitezed_data['phone_2']) ? NULL : $sanitezed_data['phone_2'];
$data['email_1'] = $sanitezed_data['email_1'];
$data['email_2'] = empty($sanitezed_data['email_2']) ? NULL : $sanitezed_data['email_2'];
$data['address'] = $sanitezed_data['address'];
$data['timezone'] = $sanitezed_data['timezone'];
$data['slogan'] = $sanitezed_data['slogan'];
$data['short_code'] = $sanitezed_data['short_code'];

$school->update($data);

$utility->setMessage("success", 'General settings updated');
header("location:../general_settings");

}else{

header("location:../general_settings");

}
?>
