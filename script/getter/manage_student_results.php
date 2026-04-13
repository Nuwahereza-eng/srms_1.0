<?php
chdir('../');
require_once 'autoload.php';
$students = new students_controller;
$staff = new staff_controller;
$session = new session;
$class = new classes_controller;
$comb = new subject_combinations_controller;

require_once 'includes/session_validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$query = "SELECT reg_no, CONCAT(first_name,' ',last_name) as name FROM students WHERE class = ?";
$params = array($_POST['class']);

$results = $students->runQuery($query, $params);

if ($profile['role'] == 'ADMIN') {
$subs = $comb->get_subjects($_POST['class']);
}else{
$subs = $comb->get_subjects($_POST['class'], $_SESSION['logged_account']['id']);
}

$sub_select = "";
$std_select = "";

foreach ($results as $key0 => $value0) {
$reg = $value0['reg_no'];
$name = $value0['name'];
$std_select = $std_select."<option value='$reg'>$name ($reg)</option>";
}

foreach ($subs as $key => $value) {
$sub_name = $value['name'];
$sub_id = $value['id'];
$sub_code = $value['code'];
$sub_select = $sub_select."<option value='$sub_id'>$sub_code : $sub_name</option>";
}

$reply['students'] = $std_select;
$reply['subs'] = $sub_select;

echo str_replace("\\", "", json_encode($reply, JSON_PRETTY_PRINT));
}


?>
