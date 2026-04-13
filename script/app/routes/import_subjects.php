<?php
chdir('../../');
require_once 'autoload.php';
require_once 'simplexlsx/vendor/autoload.php';
$subjects = new subjects_controller;
use Shuchkin\SimpleXLSX;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$file = $_FILES['file']['tmp_name'];
$current_record = 0;

if ( $xlsx = SimpleXLSX::parse($file) ) {
foreach( $xlsx->rows() as $row ) {

if ($current_record !== 0) {

$data['code'] = $utility->sanitize(strtoupper($row[0]));
$data['name'] = $utility->sanitize(ucwords($row[1]));
$data['is_principal'] = $utility->sanitize($row[2]);
$data['subject_type'] = $utility->sanitize($row[3]);
$data['status'] = $utility->sanitize($row[4]);

if (empty($subjects->check_code($data['code']))) {

$subjects->store($data);

}
}
$current_record++;
}

$utility->setMessage("success", 'Data import completed');
header("location:../subjects");

} else {
echo SimpleXLSX::parseError();
}
}else{
header("location:../subjects");
}
?>
