<?php
chdir('../');
require_once 'autoload.php';
$terms = new academic_terms_controller;
$ca = new continuous_assessments_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $terms->show($_POST['id']);

$ca_list = $ca->index();

$selected_assessments = unserialize($data['ca']);

?>
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" value="<?php echo $data['name']; ?>" required class="form-control" name="name" placeholder="Enter term name">
</div>
<div class="mb-2">
<label class="form-label">Continuous Assessments</label>
<select required class="form-control select_2_edit" name="ca[]" multiple style="width:100%">
<?php
foreach ($ca_list as $key => $value) {
?><option <?php echo in_array($value['id'], $selected_assessments) ? ' selected ' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div class="mb-2">
<label class="form-label">Status</label>
<select required class="form-control" name="status">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['status'] == 'ENABLED' ? ' selected ' : ''; ?> value="ENABLED">ENABLED</option>
<option <?php echo $data['status'] == 'DISABLED' ? ' selected ' : ''; ?> value="DISABLED">DISABLED</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Show Results</label>
<select required class="form-control" name="show_results">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['show_results'] == 'YES' ? ' selected ' : ''; ?> value="YES">YES</option>
<option <?php echo $data['show_results'] == 'NO' ? ' selected ' : ''; ?> value="NO">NO</option>
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
