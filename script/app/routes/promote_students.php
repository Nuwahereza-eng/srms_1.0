<?php
chdir('../../');
error_reporting(0);
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$exams = new examination_results_controller;
$grading_systems = new grading_systems_controller;
$division_systems = new division_systems_controller;
$sig = new signatures_controller;
$sn = new results_serial_numbers_controller;
$terms = new academic_terms_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$sanitezed_data = $utility->sanitize_request($_POST);

$_SESSION['filter'] = $sanitezed_data;

if (!empty($sanitezed_data['term'])) {

$madarasa_aliyofanyia_mtihani = $students->runQuery("SELECT class_id FROM examination_results WHERE class_id = ? AND term = ? GROUP BY class_id",
array($sanitezed_data['class'], $sanitezed_data['term']));

$students_in_class = [];

$full_matokeo = $students->runQuery("SELECT * FROM examination_results WHERE class_id = ? AND term = ?", array($sanitezed_data['class'], $sanitezed_data['term']));


foreach ($full_matokeo as $key => $value) {

$reg_no = $value["reg_no"];

$results = unserialize($value["results"]);

foreach ($results as $key1 => $value1) {

$result_key = $reg_no.'_RESULT'.$key1;


if (isset($matokeo[$result_key])) {

$matokeo[$result_key] = $matokeo[$result_key] + $value1;

}else{

$matokeo[$result_key] = $value1;

}

}

if (!in_array($reg_no, $students_in_class)) {
array_push($students_in_class, $reg_no);
}

}

$masomo_yanayohesabiwa = $students->runQuery("SELECT b.subject_id, a.is_principal FROM subject_combinations b
JOIN subjects a ON b.subject_id = a.id WHERE b.class_id = ? AND a.is_principal = 'YES'", array($madarasa_aliyofanyia_mtihani[0]['class_id']));

$masomo_yanayohesabiwa2 = [];

foreach ($masomo_yanayohesabiwa as $key__sub => $value__sub) {
array_push($masomo_yanayohesabiwa2, $value__sub['subject_id']);
}

$award_method = $classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['award_method'];
$scale_ya_grading = unserialize($grading_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['grading_system'])['details']);

if ($award_method == 'DIVISION') {

$scale_ya_division = unserialize($division_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['division_system'])['details']);
$order_ya_division =  $division_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['division_system'])['points_sorting'];

$merged = $utility->groupStudentResultsWithRanking($matokeo, $students_in_class, $masomo_yanayohesabiwa2, $scale_ya_division, $scale_ya_grading, $sortBy = 'points', $order_ya_division);

}else{

$scale_ya_division = NULL;
$order_ya_division =  'Descending';

$merged = $utility->groupStudentResultsWithRanking($matokeo, $students_in_class, $masomo_yanayohesabiwa2, $scale_ya_division, $scale_ya_grading, $sortBy = 'average', $order_ya_division);

}

$_SESSION['merged'] = $merged;
header("location:../confirm_promotion");


}else{

$students->runQuery("UPDATE students SET class = ? WHERE class = ?", array($sanitezed_data['next_class'], $sanitezed_data['class']));
$utility->setMessage("success", 'Student promotion completed');
header("location:../promote_students");

}

}else{
header("location:../promote_students");
}
?>
