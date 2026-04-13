<?php
chdir('../');
require_once 'autoload.php';
$programmes = new programmes_controller;
$classes = new classes_controller;
$staff = new staff_controller;
$gs = new grading_systems_controller;
$ds = new division_systems_controller;
$subs = new subjects_controller;
$comb = new subject_combinations_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $classes->show($_POST['id']);
$sub_data = unserialize($programmes->show($data['programme'])['subjects']);
$teacher_list = $staff->index();
$gs_list = $gs->index();
$ds_list = $ds->index();

?>
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" value="<?php echo $data['name']; ?>" required class="form-control" name="name" placeholder="Enter class name">
</div>
<div id="sub_lists_edit">
<?php
foreach ($sub_data as $key => $value) {

$teacher = $comb->sub_teacher($value, $_POST['id']);
?>
<div class="mb-2">
<label class="form-label">Select '<?php echo $subs->show($value)['code'].':'.$subs->show($value)['name']; ?>' Teacher</label>
<select required class="form-control" name="<?php echo $value; ?>" style="width:100%">
<option disabled selected>Select Subject Teacher</option>
<?php
foreach ($teacher_list as $key => $value) {
?><option <?php echo $teacher['teacher'] == $value['id'] ? ' selected ' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></option><?php
}
?>
</select>
</div>
<?php
}
?>
</div>
<div class="mb-2">
<label class="form-label">Grading System</label>
<select required class="form-control" name="grading_system"  style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($gs_list as $key => $value) {
?><option <?php echo $data['grading_system'] == $value['id'] ? ' selected ' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div class="mb-2">
<label class="form-label">Division System</label>
<select class="form-control" name="division_system"  style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($ds_list as $key => $value) {
?><option <?php echo $data['division_system'] == $value['id'] ? ' selected ' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div class="mb-2">
<label class="form-label">Award System</label>
<select required class="form-control" name="award_method">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['award_method'] == 'AVERAGE' ? ' selected ' : ''; ?> value="AVERAGE">AVERAGE</option>
<option <?php echo $data['award_method'] == 'DIVISION' ? ' selected ' : ''; ?> value="DIVISION">DIVISION</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Status</label>
<select required class="form-control" name="status">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['status'] == 'ENABLED' ? ' selected ' : ''; ?> value="ENABLED">ENABLED</option>
<option <?php echo $data['status'] == 'DISABLED' ? ' selected ' : ''; ?> value="DISABLED">DISABLED</option>
</select>
</div>
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<div class="mb-4">
<button type="submit" class="btn btn-primary">Save</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<?php
}
?>
