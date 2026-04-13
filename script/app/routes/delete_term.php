<?php
chdir('../../');
require_once 'autoload.php';
$terms = new academic_terms_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$ca->destroy($_GET['id']);

$utility->setMessage("success", 'Academic term deleted');
header("location:../terms");

}else{
header("location:../terms");
}
?>
