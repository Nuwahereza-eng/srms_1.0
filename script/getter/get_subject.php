<?php
chdir('../');
require_once 'autoload.php';
$subjects = new subjects_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $subjects->show($_POST['id']);
?>
<div class="mb-2">
<label class="form-label">Subject Code</label>
<input value="<?php echo $data['code']; ?>" type="text" required class="form-control txt_upper" name="code" placeholder="Enter subject code">
</div>
<div class="mb-2">
<label class="form-label">Subject Name</label>
<input value="<?php echo $data['name']; ?>" type="text" required class="form-control" name="name" placeholder="Enter subject name">
</div>
<div class="mb-2">
<label class="form-label">Principal Subject</label>
<select required class="form-control" name="is_principal">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['is_principal'] == 'YES' ? ' selected ' : ''; ?> value="YES">YES</option>
<option <?php echo $data['is_principal'] == 'NO' ? ' selected ' : ''; ?>  value="NO">NO</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Subject Status</label>
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
