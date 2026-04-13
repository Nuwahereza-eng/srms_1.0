<?php
chdir('../../');
require_once 'autoload.php';
require_once 'simplexlsx/vendor/autoload.php';

$results = new examination_results_controller;
$sn = new results_serial_numbers_controller;
$_subjects = new subjects_controller;

use Shuchkin\SimpleXLSX;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$subjects = $_POST['subjects'] ?? [];
$files = $_FILES['files'] ?? null;

$errors = '';

if (count($subjects) !== count($files['name'])) {
$errors = $errors." The number of subjects (" . count($subjects) . ") does not match the number of uploaded files (" . count($files['name']) . ").";
}

if (empty($errors)) {
$uploadedFiles = array_map('basename', $files['name']);

foreach ($subjects as $subject) {
$expectedFile = $subject . ".CSV";
if (!in_array($expectedFile, $uploadedFiles)) {
$errors = $errors. " Missing or incorrectly named file for subject: $subject (expected $expectedFile)";
}
}
}

if (!empty($errors)) {

$utility->setMessage("warning", $errors);
header("location:../import_results");

} else {

$fileMap = [];
foreach ($_FILES['files']['name'] as $i => $name) {
$fileMap[basename($name)] = $_FILES['files']['tmp_name'][$i];
}

foreach ($subjects as $subject) {
$expectedName = $subject . '.CSV';

$file = $fileMap[$expectedName];

if (($handle = fopen($file, "r")) !== false) {

$header = fgetcsv($handle, 1000, ",");

$regIndex = array_search('REGISTRATION_NUMBER', $header);
$scoreIndex = array_search('SCORE', $header);

while (($data = fgetcsv($handle, 1000, ",")) !== false) {
$reg = trim($data[$regIndex] ?? '');
$score = !empty($data[$scoreIndex]) ? trim($data[$scoreIndex] ?? '') : NULL;
if ($reg !== '') {

$sub_data = [];

$_data['reg_no'] = $reg;
$_data['class_id'] = $sanitezed_data['class'];
$_data['term'] = $sanitezed_data['term'];
$_data['ca'] = $sanitezed_data['ca'];

$serial = $sn->show($_data['reg_no'], $_data['class_id'], $_data['term']);

if (empty($serial)) {

$serial_no = $utility->generateSerialSecure();

$sn->store($_data['reg_no'], $_data['class_id'], $_data['term'], $serial_no);

}

$previous_record = $results->check_record($_data['reg_no'], $_data['class_id'], $_data['term'], $_data['ca']);

if (empty($previous_record)) {

$update = 0;
$sub_data[$_subjects->show_by_code($subject)['id']] = $score;


}else{

$current_somo_id = $_subjects->show_by_code($subject)['id'];

$matokeo = unserialize($previous_record['results']);

$matokeo[$current_somo_id] = $score;

$sub_data = $matokeo;

$update = 1;

}

$_data['results'] = serialize($sub_data);

if ($update < 1) {

$results->store($_data);

}else{

$results->update($previous_record['id'], $_data);

}

}

}

fclose($handle);
} else {

}
}


$utility->setMessage("success", 'Data import completed');
header("location:../import_results");

}

}else{

header("location:../import_results");

}
?>
