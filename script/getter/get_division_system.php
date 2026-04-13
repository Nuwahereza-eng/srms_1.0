<?php
chdir('../');
require_once 'autoload.php';
$ds = new division_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $ds->show($_POST['id']);
$scales = unserialize($data['details']);

?>
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" value="<?php echo $data['name']; ?>" required class="form-control" name="name" placeholder="Enter grading system name">
</div>

<div class="grading_details_edit">
<?php

foreach ($scales as $key => $value) {
$id = "scale_".$key;
?>
<div class="grade_div" id="<?php echo $id; ?>">
<div class="row">
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12">
<label class="form-label">Division</label>
<input type="text" name="scale_name[]" class="form-control txt_upper" value="<?php echo $value['scale_name']; ?>" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Minimum Point</label>
<input type="text" name="min_point[]" class="form-control score-range" value="<?php echo $value['min_point']; ?>" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Maximum Point</label>
<input type="text" name="max_point[]" class="form-control score-range" value="<?php echo $value['max_point']; ?>" required>
</div>
<div class="col-xl-6 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Remark</label>
<input type="text" name="remark[]" class="form-control txt_upper" value="<?php echo $value['remark']; ?>" required>
</div>

<div class="col-xl-6 col-l-6 col-md-12 col-sm-12 mb-2">
<label class="form-label">Class Teacher's Comment</label>
<input type="text" name="teacher_comment[]" class="form-control txt_cap" value="<?php echo $value['teacher_comment']; ?>" required>
</div>
<div class="col-xl-5 col-l-5 col-md-12 col-sm-12 mb-2">
<label class="form-label">Head Teacher's Comment</label>
<input type="text" name="head_teacher_comment[]" class="form-control txt_cap" value="<?php echo $value['head_teacher_comment']; ?>" required>
</div>
<div class="col-xl-1 col-l-1 col-md-1 col-sm-1 mb-2">
<button type="button" class="btn btn-danger pull_right w-100 remove-scale">
<i class="fa fa-fw fa-trash"></i>
</button>
</div>
</div>
</div>
<?php
}
?>
</div>
<div class="mb-2">
<label class="form-label">Point Sorting</label>
<select required class="form-control" name="points_sorting">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['points_sorting'] == 'Ascending' ? ' selected ' : ''; ?> value="Ascending">ASCENDING</option>
<option <?php echo $data['points_sorting'] == 'Descending' ? ' selected ' : ''; ?> value="Descending">DESCENDING</option>
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
<button type="button" onclick="add_scale('grading_details_edit');" class="btn btn-success">Add Scale</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<?php
}
?>
