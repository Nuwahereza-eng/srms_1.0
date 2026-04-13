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

$prev = !empty($students->last_entry()['reg_no']) ? $students->last_entry()['reg_no'] : NULL;

$data['reg_no'] = $utility->generate_reg_no($prev, $row[2], $info['short_code']);
$data['first_name'] = $utility->sanitize(ucwords($_POST['first_name']));
$data['last_name'] = $utility->sanitize(ucwords($_POST['last_name']));
$data['gender'] = $utility->sanitize($_POST['gender']);
$data['email'] = $utility->sanitize($_POST['email']);
$data['hashed_pw'] = password_hash(strtoupper($data['first_name'].$data['last_name']), PASSWORD_BCRYPT);
$data['reg_date'] = date('Y-m-d G:i:s');
$data['class'] = $utility->sanitize($_POST['class']);
$data['account_status'] = $utility->sanitize($_POST['account_status']);

if (isset($_SESSION['current_image'])) {

$photo = 'student_'. time() . '.png';
$folderPath = 'storage/images/students/';
$image_parts = explode(";base64,", $_SESSION['current_image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath.$photo;
file_put_contents($file, $image_base64);
$upload_status = 'OK';

}elseif($_FILES['file']['name'] !== ""){

$ext = $utility->extension($_FILES);
$file = 'student_'.time();
$upload_status = $utility->uploader('storage/images/students/', $_FILES, $file, 'png,jpeg,jpg');
$photo = $file.'.'.$ext;

}else{

$photo = NULL;
$upload_status = 'OK';

}

if ($upload_status == "OK") {

$data['display_img'] = $photo;
$students->store($data);
unset($_SESSION['current_image']);
$utility->setMessage("success", "Student registered with registration number ".$data['reg_no']);
header("location:../register_students");

}else{

$utility->setMessage("warning", $upload_status);
header("location:../register_students");
}

}else{
header("location:../register_students");
}
?>
