<?php
chdir('../');
require_once 'autoload.php';
$programmes = new programmes_controller;
$subjects = new subjects_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $programmes->show($_POST['id']);
$subject_list = $subjects->index();

$selected_subjects = unserialize($data['subjects']);

?>
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" required class="form-control" name="name" placeholder="Enter programme name">
</div>
<div class="mb-2">
<label class="form-label">Subjects</label>
<select required class="form-control select_2_edit" name="subjects[]" multiple style="width:100%">
<?php
foreach ($subject_list as $key => $value) {
?><option <?php echo in_array($value['id'], $selected_subjects) ? ' selected ' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['code'].' : '.$value['name']; ?></option><?php
}
?>
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
