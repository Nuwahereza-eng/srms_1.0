<?php
chdir('../../');
require_once 'autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$_SESSION['export_data'] = $sanitezed_data['class'];
header("location:../students_list");

}else{
header("location:../export_students");
}
?>
