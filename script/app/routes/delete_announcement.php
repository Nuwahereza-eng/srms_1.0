<?php
chdir('../../');
require_once 'autoload.php';
$an = new announcements_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$an->destroy($_GET['id']);

$utility->setMessage("success", 'Announcement deleted');
header("location:../announcements");

}else{
header("location:../announcements");
}
?>
