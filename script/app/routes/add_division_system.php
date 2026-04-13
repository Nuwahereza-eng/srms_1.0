<?php
chdir('../../');
require_once 'autoload.php';
$ds = new division_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])  && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($ds->check_name($sanitezed_data['name']))) {

$scales = array();

foreach ($_POST['scale_name'] as $key => $value) {

$sub_data['scale_namepoint'] = strtoupper($value);
$sub_data['min_point'] = $_POST['min_point'][$key];
$sub_data['max_point'] = $_POST['max_point'][$key];
$sub_data['remark'] = ucwords($_POST['remark'][$key]);
$sub_data['teacher_comment'] = ucwords($_POST['teacher_comment'][$key]);
$sub_data['head_teacher_comment'] = ucwords($_POST['head_teacher_comment'][$key]);

array_push($scales, $sub_data);

}

$data['name'] = $sanitezed_data['name'];
$data['points_sorting'] = $sanitezed_data['points_sorting'];
$data['details'] = serialize($scales);
$data['status'] = $sanitezed_data['status'];

$ds->store($data);

$utility->setMessage("success", 'Division system registered');
header("location:../division_systems");

}else{

$utility->setMessage("warning", 'Grading system is already registered');
header("location:../division_systems");

}
}else{
header("location:../division_systems");
}
?>
