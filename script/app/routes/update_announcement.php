<?php
chdir('../../');
require_once 'autoload.php';
$an = new announcements_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$data['title'] = ucwords($utility->sanitize($_POST['title']));
$data['announcement'] = $_POST['announcement'];
$data['audience'] = $_POST['audience'];

$an->update($_POST['id'], $data);

$utility->setMessage("success", 'Announcement updated');
header("location:../announcements");

}else{
header("location:../announcements");
}
?>
