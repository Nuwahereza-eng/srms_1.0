<?php
chdir('../../');
require_once 'autoload.php';
$terms = new academic_terms_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) && 
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($terms->check_name($sanitezed_data['name']))) {

$terms->store($sanitezed_data);

$utility->setMessage("success", 'Academic term registered');
header("location:../terms");

}else{

$utility->setMessage("warning", 'Academic term is already registered');
header("location:../terms");

}
}else{
header("location:../terms");
}
?>
