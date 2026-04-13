<?php
chdir('../../');
require_once 'autoload.php';
$students = new students_controller;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf_token']) && isset($_GET['csrf_form_id']) &&
$utility->csrf_validate($_GET['csrf_form_id'], $_GET['csrf_token'], $utility->action_name())) {

$prev_photo = $students->show($_GET['id'])['display_img'];

$students->destroy($_GET['id']);

if (!empty($prev_photo)) {

$utility->delete_file('storage/images/students/'.$prev_photo);

}

$utility->setMessage("success", 'Student deleted');
header("location:../manage_students");

}else{
header("location:../manage_students");
}
?>
