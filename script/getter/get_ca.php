<?php
chdir('../');
require_once 'autoload.php';
$ca = new continuous_assessments_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $ca->show($_POST['id']);
?>
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" value="<?php echo $data['name']; ?>" required class="form-control" name="name" placeholder="Enter continuous asessment name">
</div>
<div class="mb-2">
<label class="form-label">Weight</label>
<input type="text" value="<?php echo $data['weight']; ?>" required class="form-control score-range" name="weight" placeholder="Enter weight">
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
