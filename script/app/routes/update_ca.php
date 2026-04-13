<?php
chdir('../../');
require_once 'autoload.php';
$ca = new continuous_assessments_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($ca->check_name($sanitezed_data['name'], $_POST['id']))) {

$ca->update($_POST['id'], $sanitezed_data);

$utility->setMessage("success", 'Continuous assessments updated');
header("location:../cont_assessments");

}else{
$utility->setMessage("warning", 'Continuous assessments is already registered');
header("location:../cont_assessments");

}
}else{
header("location:../cont_assessments");
}
?>
