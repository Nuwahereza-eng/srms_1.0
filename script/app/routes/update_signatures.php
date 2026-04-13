<?php
chdir('../../');
require_once 'autoload.php';
$sig = new signatures_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && isset($_POST['csrf_form_id']) &&
$utility->csrf_validate($_POST['csrf_form_id'], $_POST['csrf_token'], $utility->action_name())) {

$sanitezed_data = $utility->sanitize_request($_POST);

$data['name_1'] = $sanitezed_data['name_1'];
$data['title_1'] = $sanitezed_data['title_1'];
$data['signature_1'] = $sanitezed_data['signature_1'];
$data['1_enabled'] = !empty($sanitezed_data['1_enabled']) ? 'YES' : 'NO';
$data['name_2'] = $sanitezed_data['name_2'];
$data['title_2'] = $sanitezed_data['title_2'];
$data['signature_2'] = $sanitezed_data['signature_2'];
$data['2_enabled'] = !empty($sanitezed_data['2_enabled']) ? 'YES' : 'NO';

$sig->update($data);

$utility->setMessage("success", 'Signature settings updated');
header("location:../signature_settings");

}else{
header("location:../signature_settings");
}
?>
