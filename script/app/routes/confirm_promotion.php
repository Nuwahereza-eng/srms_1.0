<?php
chdir('../../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$terms = new academic_terms_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

foreach ($_SESSION['merged'] as $key => $value) {

$data['class'] = $_SESSION['filter']['next_class'];

if (isset($value['average'])) {
$column = $value['average'];
$title = 'Average';
}else{
$column = $value['points'];
$title = 'Points';
}

$std_profile = $students->show($key);

if (!empty($_SESSION['filter']['promote_all'])) {

$students->update($std_profile['reg_no'], $data);

}else{

$weight = $_SESSION['filter']['required_score'];

switch ($_SESSION['filter']['criteria']) {
case 'LESS THAN':

if ($column < $weight) {

$students->update($std_profile['reg_no'], $data);

}

break;

default:

if ($column > $weight) {

$students->update($std_profile['reg_no'], $data);

}
break;
}

}

}

$utility->setMessage("success", 'Student promotion completed');
header("location:../promote_students");

}else{
header("location:../promote_students");
}
?>
