<?php
chdir('../../');
require_once 'autoload.php';
$school = new school_controller;
$students = new students_controller;
require_once 'simplexlsx/vendor/autoload.php';
use Shuchkin\SimpleXLSX;

$info = $school->index();
date_default_timezone_set($info['timezone']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);
$prev = !empty($students->last_entry()['reg_no']) ? $students->last_entry()['reg_no'] : NULL;
$file = $_FILES['file']['tmp_name'];
$current_record = 0;

if ( $xlsx = SimpleXLSX::parse($file) ) {
foreach( $xlsx->rows() as $row ) {

if ($current_record !== 0) {

$data['reg_no'] = $utility->generate_reg_no($prev, $row[2], $info['short_code']);

$data['first_name'] = $utility->sanitize(ucwords($row[0]));
$data['last_name'] = $utility->sanitize(ucwords($row[1]));
$data['gender'] = $utility->sanitize($row[2]);
$data['email'] = $utility->sanitize($row[3]);
$data['hashed_pw'] = password_hash(strtoupper($data['first_name'].$data['last_name']), PASSWORD_BCRYPT);
$data['reg_date'] = date('Y-m-d G:i:s');
$data['class'] = $sanitezed_data['class'];
$data['account_status'] = $utility->sanitize($row[4]);
$prev = $data['reg_no'];

$students->store($data);

}
$current_record++;
}

$utility->setMessage("success", 'Data import completed');
header("location:../import_students");

} else {
echo SimpleXLSX::parseError();
}
}else{
header("location:../import_students");
}
?>
