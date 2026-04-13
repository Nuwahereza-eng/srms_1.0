<?php
chdir('../../');
require_once 'autoload.php';
$gs = new grading_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$gs->destroy($_GET['id']);

$utility->setMessage("success", 'Grading system deleted');
header("location:../grading_systems");

}else{
header("location:../grading_systems");
}
?>
