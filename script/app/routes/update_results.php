<?php
chdir('../../');
require_once 'autoload.php';

$students = new students_controller;
$results = new examination_results_controller;
$sn = new results_serial_numbers_controller;
$_subjects = new subjects_controller;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$r_data = $_SESSION['manage_data'];

$std_profile = [];

$r_data['students'] = unserialize($r_data['students']);
$r_data['subjects'] = unserialize($r_data['subjects']);

foreach ($r_data['students'] as $key => $value) {

array_push($std_profile, $students->show($value));

}


foreach ($std_profile as $key => $value) {



foreach ($r_data['subjects'] as $key2 => $value2) {

$_data['reg_no'] = $value['reg_no'];
$_data['class_id'] = $r_data['class'];
$_data['term'] = $r_data['term'];
$_data['ca'] = $r_data['ca'];

$serial = $sn->show($value['reg_no'], $r_data['class'], $r_data['term']);

if (empty($serial)) {

$serial_no = $utility->generateSerialSecure();

$sn->store($value['reg_no'], $r_data['class'], $r_data['term'], $serial_no);

}


$previous_record = $results->check_record($value['reg_no'], $r_data['class'], $r_data['term'], $r_data['ca']);

if (!empty($previous_record)) {

$current_somo_id = $value2;

$matokeo = unserialize($previous_record['results']);

$post_key = $value['reg_no'].'SCORE'.$current_somo_id;

$matokeo[$current_somo_id] = !empty($sanitezed_data[$post_key]) ? $sanitezed_data[$post_key] : NULL;

$sub_data = $matokeo;

$update = 1;

}else{

$current_somo_id = $value2;

$sub_data[$current_somo_id] = $score;

$update = 0;

}

$_data['results'] = serialize($sub_data);

if ($update < 1) {

$results->store($_data);

}else{

$results->update($previous_record['id'], $_data);

}


}


}

$utility->setMessage("success", 'Results updated successfully');

header("location:../edit_results");

}else{

header("location:../edit_results");

}
?>
