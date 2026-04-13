<?php
chdir('../../');
require_once 'autoload.php';
$ca = new continuous_assessments_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) && 
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$ca->destroy($_GET['id']);

$utility->setMessage("success", 'Continuous assessments deleted');
header("location:../cont_assessments");

}else{
header("location:../cont_assessments");
}
?>
