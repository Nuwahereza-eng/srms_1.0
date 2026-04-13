<?php
chdir('../');
require_once 'autoload.php';
$gs = new grading_systems_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $gs->show($_POST['id']);
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
<label class="form-label">Grade</label>
<input type="text" name="grade[]" class="form-control txt_upper" value="<?php echo $value['grade']; ?>" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Minimum Score</label>
<input type="text" name="min_score[]" class="form-control score-range" value="<?php echo $value['min_score']; ?>" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Maximum Score</label>
<input type="text" name="max_score[]" class="form-control score-range" value="<?php echo $value['max_score']; ?>" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Points</label>
<input type="text" name="points[]" class="form-control score-range" value="<?php echo $value['points']; ?>" required>
</div>
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Remark</label>
<input type="text" name="remark[]" class="form-control txt_upper" value="<?php echo $value['remark']; ?>" required>
</div>
<div class="col-xl-6 col-l-5 col-md-11 col-sm-11 mb-2">
<label class="form-label">Class Teacher's Comment</label>
<input type="text" name="teacher_comment[]" class="form-control txt_cap" value="<?php echo $value['teacher_comment']; ?>" required>
</div>
<div class="col-xl-5 col-l-5 col-md-11 col-sm-11 mb-2">
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
