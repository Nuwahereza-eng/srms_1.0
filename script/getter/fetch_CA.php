<?php
chdir('../');
require_once 'autoload.php';
$terms = new academic_terms_controller;
$ca = new continuous_assessments_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = unserialize($terms->show($_POST['term'])['ca']);

$ca_select = '<option value="" selected disabled></option>';

foreach ($data as $key => $value) {
$name = $ca->show($value)['name'];
$ca_select = $ca_select."<option value='$value'>$name</option>";

}

echo $ca_select;
}
?>
