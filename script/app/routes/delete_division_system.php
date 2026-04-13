<?php
chdir('../../');
require_once 'autoload.php';
$ds = new division_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$ds->destroy($_GET['id']);

$utility->setMessage("success", 'Division system deleted');
header("location:../division_systems");

}else{
header("location:../division_systems");
}
?>
