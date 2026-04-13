<form enctype="multipart/form-data" autocomplete="off" class="app_frm" action="app/routes/update_color" method="POST">
<div class="mb-2">
<div class="space-y-2 mb-4">
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="0" <?php echo $info['theme'] == '0' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-default c_theme">
Default Color Theme
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="1" <?php echo $info['theme'] == '1' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xwork c_theme">
Color Theme 1
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="2" <?php echo $info['theme'] == '2' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xmodern c_theme">
Color Theme 2
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="3" <?php echo $info['theme'] == '3' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xeco c_theme">
Color Theme 3
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="4" <?php echo $info['theme'] == '4' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xsmooth c_theme">
Color Theme 4
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="5" <?php echo $info['theme'] == '5' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xinspire c_theme">
Color Theme 5
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="6" <?php echo $info['theme'] == '6' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xdream c_theme">
Color Theme 6
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="7" <?php echo $info['theme'] == '7' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xpro c_theme">
Color Theme 7
</b>
</div>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" id="0" name="theme" value="8" <?php echo $info['theme'] == '8' ? ' checked="true" ' : ''; ?>>
<div class="col-xl-1 col-l-1 col-md-2 col-sm-2 mb-1">
<b class="d-block py-3 text-white fs-xs fw-semibold bg-xplay c_theme">
Color Theme 8
</b>
</div>
</div>

<div class="mb-4">
<label class="form-label">SideBar</label>
<div class="space-y-2">
<div class="form-check">
<input required class="form-check-input" type="radio" name="sidebar" value="sidebar-dark" <?php echo $info['sidebar'] == 'sidebar-dark' ? ' checked="true" ' : ''; ?>>
<label class="form-check-label">Default (Black)</label>
</div>
<div class="form-check">
<input required class="form-check-input" type="radio" name="sidebar" value="sidebar-light" <?php echo $info['sidebar'] == 'sidebar-light' ? ' checked="true" ' : ''; ?>>
<label class="form-check-label">Light</label>
</div>
</div>
</div>
</div>
</div>
<?= $utility->csrf_field('update_color.php', 600) ?>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
