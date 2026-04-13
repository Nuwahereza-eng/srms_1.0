<?php
chdir('../');
require_once 'autoload.php';
$staff = new staff_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $staff->show($_POST['id']);
?>
<div class="mb-2">
<label class="form-label">First Name</label>
<input value="<?php echo $data['first_name']; ?>" type="text" required class="form-control" name="first_name" placeholder="Enter first name">
</div>
<div class="mb-2">
<label class="form-label">Last Name</label>
<input value="<?php echo $data['last_name']; ?>"  type="text" required class="form-control" name="last_name" placeholder="Enter last name">
</div>
<div class="mb-2">
<label class="form-label">Gender</label>
<select required class="form-control" name="gender">
<option value="" selected disabled>Select Gender</option>
<option <?php echo $data['gender'] == 'Male' ? ' selected ' : ''; ?> value="Male">Male</option>
<option <?php echo $data['gender'] == 'Female' ? ' selected ' : ''; ?> value="Female">Female</option>
</select>
</div>
<div class="mb-2">
<label class="form-label">Email Address</label>
<input value="<?php echo $data['email']; ?>" type="email" required class="form-control" name="email" placeholder="Enter email address">
</div>
<div class="mb-3">
<label class="form-label">Status</label>
<select required class="form-control" name="account_status">
<option value="" selected disabled>Select Option</option>
<option <?php echo $data['account_status'] == 'ENABLED' ? ' selected ' : ''; ?> value="ENABLED">ENABLED</option>
<option <?php echo $data['account_status'] == 'DISABLED' ? ' selected ' : ''; ?> value="DISABLED">DISABLED</option>
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
