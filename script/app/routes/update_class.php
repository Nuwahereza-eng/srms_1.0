<?php
chdir('../../');
require_once 'autoload.php';
$classes = new classes_controller;
$combinations = new subject_combinations_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

if (empty($classes->check_name($sanitezed_data['name'], $_POST['id']))) {

$data['name'] = $sanitezed_data['name'];
$data['grading_system'] = $sanitezed_data['grading_system'];
$data['division_system'] = !empty($sanitezed_data['division_system']) ? $sanitezed_data['division_system'] : NULL;
$data['award_method'] = $sanitezed_data['award_method'];
$data['status'] = $sanitezed_data['status'];

$classes->update($_POST['id'], $data);

foreach ($sanitezed_data as $key => $value) {
if ($key !== 'name' AND $key !== 'programme' AND $key !== 'grading_system' AND $key !== 'division_system' AND $key !== 'award_method' AND  $key !== 'status') {

$combinations->update($key, $_POST['id'], $value);

}
}

$utility->setMessage("success", 'Class updated');
header("location:../classes");

}else{

$utility->setMessage("warning", 'Class is already registered');
header("location:../classes");

}
}else{
header("location:../classes");
}
?>
