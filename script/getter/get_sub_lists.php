<?php
chdir('../');
require_once 'autoload.php';
$programmes = new programmes_controller;
$staff = new staff_controller;
$subs = new subjects_controller;
$comb = new subject_combinations_controller;

$teacher_list = $staff->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = unserialize($programmes->show($_POST['id'])['subjects']);

foreach ($data as $key => $value) {
?>
<div class="mb-2">
<label class="form-label">Select '<?php echo $subs->show($value)['code'].':'.$subs->show($value)['name']; ?>' Teacher</label>
<select required class="form-control" name="<?php echo $value; ?>" style="width:100%">
<option disabled selected>Select Subject Teacher</option>
<?php
foreach ($teacher_list as $key => $value) {
?><option value="<?php echo $value['id']; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></option><?php
}
?>
</select>
</div>
<?php
}

}
?>
