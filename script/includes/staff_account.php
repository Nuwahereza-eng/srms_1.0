<div class="mb-2">
<label class="form-label">First Name</label>
<input type="text" value="<?php echo $profile['first_name']; ?>" required class="form-control" name="first_name" placeholder="Enter first name">
</div>
<div class="mb-2">
<label class="form-label">Last Name</label>
<input type="text" value="<?php echo $profile['last_name']; ?>" required class="form-control" name="last_name" placeholder="Enter last name">
</div>
<div class="mb-2">
<label class="form-label">Gender</label>
<select required class="form-control" name="gender">
<option value="" selected disabled>Select Gender</option>
<option <?php echo $profile['gender'] == 'Male' ? ' selected ' : ''; ?> value="Male">Male</option>
<option <?php echo $profile['gender'] == 'Female' ? ' selected ' : ''; ?> value="Female">Female</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" value="<?php echo $profile['email']; ?>" required class="form-control" name="email" placeholder="Enter email address">
</div>
