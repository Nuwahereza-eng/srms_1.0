<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$staff->destroy($_GET['id']);

$utility->setMessage("success", 'Teacher deleted');
header("location:../teachers");

}else{
header("location:../teachers");
}
?>
