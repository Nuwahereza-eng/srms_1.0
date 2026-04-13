<?php
chdir('../../');
require_once 'autoload.php';
$programmes = new programmes_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$programmes->destroy($_GET['id']);

$utility->setMessage("success", 'Academic programme deleted');
header("location:../programmes");

}else{
header("location:../programmes");
}
?>
