<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$sig = new signatures_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();
$signatures = $sig->index();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Signature Settings'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Sserwanga Abdul">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?> enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">

<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
Signature Settings
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">
<form autocomplete="off" class="app_frm" action="app/routes/update_signatures" method="POST">
<div class="row mb-3">
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature Name 1</label>
<input type="text" value="<?php echo $signatures['name_1']; ?>" class="form-control" placeholder="Enter signature name 1" required name="name_1">
</div>
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature Title 1</label>
<input type="text" value="<?php echo $signatures['title_1']; ?>" class="form-control" placeholder="Enter signature title 1" required name="title_1">
</div>
<div class="col-xl-3 col-l-3 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature 1</label>
<input type="text" value="<?php echo $signatures['signature_1']; ?>" onchange="cs(this.value, 'sig_1');" onkeyup="cs(this.value, 'sig_1');" onkeydown="cs(this.value, 'sig_1');" class="form-control" placeholder="Enter signature 1" required name="signature_1">
</div>
<div class="col-xl-1 col-l-1 col-md-1 col-sm-1 mb-2">
<div class="form-check form-switch form-check-inline sig_check">
<label class="form-label">Enabled</label>
<input class="form-check-input" type="checkbox" name="1_enabled" <?php echo $signatures['1_enabled'] == 'YES' ? ' checked="true" ' : ''; ?>>
</div>
</div>
<div class="col-12">
<label class="form-label">Signature 1 Preview</label>
<div class="signature_preview" id="sig_1"><?php echo $signatures['signature_1']; ?></div>
</div>
</div>


<div class="row mb-3">
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature Name 2</label>
<input type="text" value="<?php echo $signatures['name_2']; ?>" class="form-control" placeholder="Enter signature name 2" required name="name_2">
</div>
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature Title 2</label>
<input type="text" value="<?php echo $signatures['title_2']; ?>" class="form-control" placeholder="Enter signature title 2" required name="title_2">
</div>
<div class="col-xl-3 col-l-3 col-md-6 col-sm-12 mb-2">
<label class="form-label">Signature 2</label>
<input type="text"  value="<?php echo $signatures['signature_2']; ?>" onchange="cs(this.value, 'sig_2');" onkeyup="cs(this.value, 'sig_2');" onkeydown="cs(this.value, 'sig_2');" class="form-control" placeholder="Enter signature 2" required name="signature_2">
</div>
<div class="col-xl-1 col-l-1 col-md-1 col-sm-1 mb-2">
<div class="form-check form-switch form-check-inline sig_check">
<label class="form-label">Enabled</label>
<input class="form-check-input" type="checkbox" name="2_enabled" <?php echo $signatures['2_enabled'] == 'YES' ? ' checked="true" ' : ''; ?>>
</div>
</div>
<div class="col-12">
<label class="form-label">Signature 2 Preview</label>
<div class="signature_preview" id="sig_2"><?php echo $signatures['signature_2']; ?></div>
</div>
</div>
<?= $utility->csrf_field('update_signatures.php', 600) ?>
<div class="mb-2">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>
</div>

</div>
</main>
<?php require_once 'includes/footer.php'; ?>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/core.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/plugins/datatables/dataTables.min.js"></script>
<script src="assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script>
function cs(signature, element) {
document.getElementById(element).innerHTML = signature;
}
</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
