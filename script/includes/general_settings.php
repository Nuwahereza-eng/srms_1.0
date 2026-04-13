<form autocomplete="off" class="app_frm" action="app/routes/update_general_settings" method="POST">
<div class="mb-2">
<label class="form-label">School Name</label>
<input type="text" value="<?php echo $info['name']; ?>" required class="form-control" name="name" placeholder="Enter school name">
</div>
<div class="mb-2">
<label class="form-label">Phone 1</label>
<input type="text" value="<?php echo $info['phone_1']; ?>" required class="form-control" name="phone_1" placeholder="Enter phone 1">
</div>
<div class="mb-2">
<label class="form-label">Phone 2 (optional)</label>
<input type="text" value="<?php echo $info['phone_2']; ?>" class="form-control" name="phone_2" placeholder="Enter phone 2 (optional)">
</div>
<div class="mb-2">
<label class="form-label">Email 1</label>
<input type="email" value="<?php echo $info['email_1']; ?>" required class="form-control" name="email_1" placeholder="Enter email 1">
</div>
<div class="mb-2">
<label class="form-label">Email 2 (optional)</label>
<input type="email" value="<?php echo $info['email_2']; ?>" class="form-control" name="email_2" placeholder="Enter email 2 (optional)">
</div>
<div class="mb-2">
<label class="form-label">School Address</label>
<input type="text" value="<?php echo $info['address']; ?>" required class="form-control" name="address" placeholder="Enter school address">
</div>
<div class="mb-2">
<label class="form-label">School Slogan</label>
<input type="text" value="<?php echo $info['slogan']; ?>" required class="form-control" name="slogan" placeholder="Enter school slogan">
</div>
<div class="mb-2">
<label class="form-label">School Prefix</label>
<input type="text" value="<?php echo $info['short_code']; ?>" required class="form-control txt_upper" name="short_code" placeholder="Enter school prefix">
</div>
<div class="mb-3">
<label class="form-label">School Timezone</label>
<select required class="form-control select_2" name="timezone"  style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($timezone_list as $key => $value) {
?><option <?php echo $info['timezone'] == $value['timezone'] ? ' selected ' : ''; ?> value="<?php echo $value['timezone']; ?>"><?php echo $value['timezone']; ?></option><?php
}
?>
</select>
</div>
<?= $utility->csrf_field('update_general_settings.php', 600) ?>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
