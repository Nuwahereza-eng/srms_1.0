<?php
chdir('../../');
require_once 'autoload.php';
$classes = new classes_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$classes->destroy($_GET['id']);

$utility->setMessage("success", 'Class deleted');
header("location:../classes");

}else{
header("location:../classes");
}
?>
