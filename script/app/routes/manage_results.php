<?php
chdir('../../');
require_once 'autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$_SESSION['manage_data'] = $sanitezed_data;
header("location:../edit_results");

}else{
header("location:../manage_results");
}
?>
