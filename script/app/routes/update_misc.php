<?php
chdir('../../');
require_once 'autoload.php';
$school = new school_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

switch ($_POST['misc_type']) {
case 'logo_':

$ext = $utility->extension($_FILES);
$file = 'logo_'.time();
$upload_status = $utility->uploader('storage/images/misc/', $_FILES, $file, 'png,jpeg,jpg');
$file = $file.'.'.$ext;

if ($upload_status == "OK") {

$utility->delete_file('storage/images/misc/'.$_POST['old_file']);

$data['logo'] = $file;

$school->update($data);

$utility->setMessage("success", "Logo updated successfully");
header("location:../general_settings");

}else{

$utility->setMessage("warning", $upload_status);
header("location:../general_settings");
}

break;

case 'icon_':

$ext = $utility->extension($_FILES);
$file = 'icon_'.time();
$upload_status = $utility->uploader('storage/images/misc/', $_FILES, $file, 'png,jpeg,jpg');
$file = $file.'.'.$ext;

if ($upload_status == "OK") {

$utility->delete_file('storage/images/misc/'.$_POST['old_file']);

$data['icon'] = $file;

$school->update($data);

$utility->setMessage("success", "Icon updated successfully");
header("location:../general_settings");

}else{

$utility->setMessage("warning", $upload_status);
header("location:../general_settings");
}


break;

case 'stamp_':

if ($_FILES['file']['name'] == "") {
$upload_status = 'OK';
$file = $_POST['old_file'];
}else{
$ext = $utility->extension($_FILES);
$file = 'stamp_'.time();
$upload_status = $utility->uploader('storage/images/misc/', $_FILES, $file, 'png,jpeg,jpg');
$file = $file.'.'.$ext;
}

if ($upload_status == "OK") {

if ($_POST['old_file'] !== $file) {
$utility->delete_file('storage/images/misc/'.$_POST['old_file']);
}

$data['stamp'] = $file;
$data['stamp_enabled'] = !empty($_POST['stamp_enabled']) ? 'YES' : 'NO';

$school->update($data);

$utility->setMessage("success", "Stamp updated successfully");
header("location:../general_settings");

}else{

$utility->setMessage("warning", $upload_status);
header("location:../general_settings");
}

break;

default:
header("location:../general_settings");
break;
}

}else{

header("location:../general_settings");

}
?>
