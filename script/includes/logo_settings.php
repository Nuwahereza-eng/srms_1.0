<form enctype="multipart/form-data" autocomplete="off" class="app_frm" action="app/routes/update_misc" method="POST">
<div class="mb-2">
<label class="form-label">School Logo</label>
<input name="file" type="file" required accept=".png,.jpg,.jpeg" id="image_logo" class="form-control ">
</div>
<div class="col-12 mb-3">
<div class="image_preview">
<div class="text-center">
<img  src="storage/images/misc/<?php echo $info['logo']; ?>" id="logo_preview" height="80" alt="School Logo">
</div>
</div>
</div>
<input type="hidden" name="misc_type" value="logo_">
<input type="hidden" name="old_file" value="<?php echo $info['logo']; ?>">
<?= $utility->csrf_field('update_misc.php', 600) ?>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
