<?php
chdir('../../');
require_once 'autoload.php';
$an = new announcements_controller;
$school = new school_controller;
$info = $school->index();
date_default_timezone_set($info['timezone']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$data['title'] = $sanitezed_data['title'];
$data['announcement'] = $_POST['announcement'];
$data['audience'] = $sanitezed_data['audience'];
$data['date_published'] = date('Y-m-d G:i:s');

$an->store($data);

$utility->setMessage("success", 'Announcement created');
header("location:../announcements");

}else{
header("location:../announcements");
}
?>
