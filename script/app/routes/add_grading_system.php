<?php
chdir('../../');
require_once 'autoload.php';
$gs = new grading_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])  && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($gs->check_name($sanitezed_data['name']))) {

$scales = array();

foreach ($_POST['grade'] as $key => $value) {

$sub_data['grade'] = strtoupper($value);
$sub_data['min_score'] = $_POST['min_score'][$key];
$sub_data['max_score'] = $_POST['max_score'][$key];
$sub_data['points'] = $_POST['points'][$key];
$sub_data['remark'] = ucwords($_POST['remark'][$key]);
$sub_data['teacher_comment'] = ucwords($_POST['teacher_comment'][$key]);
$sub_data['head_teacher_comment'] = ucwords($_POST['head_teacher_comment'][$key]);

array_push($scales, $sub_data);

}

$data['name'] = $sanitezed_data['name'];
$data['details'] = serialize($scales);
$data['status'] = $sanitezed_data['status'];

$gs->store($data);

$utility->setMessage("success", 'Grading system registered');
header("location:../grading_systems");

}else{

$utility->setMessage("warning", 'Grading system is already registered');
header("location:../grading_systems");

}
}else{
header("location:../grading_systems");
}
?>
