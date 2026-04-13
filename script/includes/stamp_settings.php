<form enctype="multipart/form-data" autocomplete="off" class="app_frm" action="app/routes/update_misc" method="POST">
<div class="mb-2">
<label class="form-label">Report Stamp</label>
<input name="file" type="file" accept=".png,.jpg,.jpeg" id="image_stamp" class="form-control ">
</div>
<div class="mb-2">
<div class="form-check form-switch form-check-inline">
<label class="form-label">Show Stamp</label>
<input class="form-check-input" type="checkbox" name="stamp_enabled" <?php echo $info['stamp_enabled'] == 'YES' ? ' checked="true" ' : ''; ?>>
</div>
</div>
<div class="col-12 mb-3">
<div class="image_preview">
<div class="text-center">
<img  src="storage/images/misc/<?php echo $info['stamp']; ?>" id="stamp_preview" height="80" alt="School Stamp">
</div>
</div>
</div>
<input type="hidden" name="misc_type" value="stamp_">
<input type="hidden" name="old_file" value="<?php echo $info['stamp']; ?>">
<?= $utility->csrf_field('update_misc.php', 600) ?>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
