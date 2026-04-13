<?php
chdir('../../');
require_once 'autoload.php';
$staff = new staff_controller;
require_once 'simplexlsx/vendor/autoload.php';
$subjects = new subjects_controller;
use Shuchkin\SimpleXLSX;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$file = $_FILES['file']['tmp_name'];
$current_record = 0;

if ( $xlsx = SimpleXLSX::parse($file) ) {
foreach( $xlsx->rows() as $row ) {

if ($current_record !== 0) {

$data['first_name'] = $utility->sanitize(ucwords($row[0]));
$data['last_name'] = $utility->sanitize(ucwords($row[1]));
$data['gender'] = $utility->sanitize($row[2]);
$data['email'] = $utility->sanitize($row[3]);
$data['hashed_pw'] = password_hash(strtoupper($data['first_name'].$data['last_name']), PASSWORD_BCRYPT);
$data['account_status'] = $utility->sanitize($row[4]);

if (empty($staff->account($data['email']))) {

$staff->store($data);

}
}
$current_record++;
}

$utility->setMessage("success", 'Data import completed');
header("location:../teachers");

} else {
echo SimpleXLSX::parseError();
}
}else{
header("location:../teachers");
}
?>
