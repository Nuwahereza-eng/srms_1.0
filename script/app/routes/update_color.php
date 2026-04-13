<?php
chdir('../../');
require_once 'autoload.php';
$school = new school_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$school->update($sanitezed_data);

$utility->setMessage("success", 'Color settings updated');
header("location:../general_settings");

}else{

header("location:../general_settings");

}
?>
