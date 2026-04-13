<div class="mb-2">
<label class="form-label">First Name</label>
<input type="text" value="<?php echo $profile['first_name']; ?>" readonly disabled class="form-control-plaintext">
</div>
<div class="mb-2">
<label class="form-label">Last Name</label>
<input type="text" value="<?php echo $profile['last_name']; ?>" readonly disabled class="form-control-plaintext">
</div>
<div class="mb-2">
<label class="form-label">Gender</label>
<input type="text" value="<?php echo $profile['gender'] == 'Male' ? 'Male' : 'Female'; ?>" readonly disabled class="form-control-plaintext">
</div>
<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" value="<?php echo $profile['email']; ?>" required class="form-control" name="email" placeholder="Enter email address">
</div>
