<?php
chdir('../../');
require_once 'autoload.php';
$programmes = new programmes_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) && 
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($programmes->check_name($sanitezed_data['name'], $_POST['id']))) {

$programmes->update($_POST['id'], $sanitezed_data);

$utility->setMessage("success", 'Academic programme updated');
header("location:../programmes");

}else{

$utility->setMessage("warning", 'Academic programme is already registered');
header("location:../programmes");

}

}else{
header("location:../programmes");
}
?>
