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

$path = "storage/import_sheets/sheets_".time()."_".$class->show($_POST['class'])['name']."";
$path2 = $path.'/';

if (!file_exists($path2)) {
mkdir($path2, 0777, true);
}else{
array_map('unlink', array_filter((array) glob("$path2*")));
}

foreach ($subs as $key => $value) {
$sub_id = $value['id'];
$sub_name = $value['name'];
$sub_code = $value['code'];
$sub_select = $sub_select."<option value='$sub_code'>$sub_code : $sub_name</option>";
$fp = fopen($path2.strtoupper($value['code'].'.csv'), 'w');
fputcsv($fp, ['REGISTRATION_NUMBER', 'STUDENT_FULL_NAME', 'SCORE']);

foreach ($results as $key => $value2) {
fputcsv($fp, [$value2['reg_no'], $value2['name'], '']);
}
}


$zipFile = "$path.zip";
$zip = new ZipArchive;
if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
foreach ($files as $file) {
if (!$file->isDir()) {
$filePath = $file->getRealPath();
$zip->addFile($filePath, substr($filePath, strlen($path) + 1));
}
}
$zip->close();
}
}

$reply['message'] = "<div class='alert alert-dismissible alert-success mt-2' style='margin-bottom:-2px !important'><i class='fa fa-circle-check'></i> Students list generated. Click <a download href='$path.zip'>here</a> to download.</div>";
$reply['subs'] = $sub_select;


echo str_replace("\\", "", json_encode($reply, JSON_PRETTY_PRINT));
?>
