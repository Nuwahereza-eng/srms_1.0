<?php
chdir('../../');
require_once 'autoload.php';
$mail = new smtp_settings_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$mail->update($sanitezed_data);

$utility->setMessage("success", 'Email configuration updated');
header("location:../email_settings");

}else{
header("location:../email_settings");
}
?>
