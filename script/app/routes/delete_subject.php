<?php
chdir('../../');
require_once 'autoload.php';
$subjects = new subjects_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$subjects->destroy($_GET['id']);

$utility->setMessage("success", 'Subject deleted');
header("location:../subjects");

}else{
header("location:../subjects");
}
?>
