<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$timezone = new timezones_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();
$timezone_list = $timezone->index();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - General Settings'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?>  enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">

<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
General Settings
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">
<div class="block block-rounded tab_div">
<ul class="nav nav-tabs nav-tabs-block" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="btabs-static-settings-1-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings-1" role="tab" aria-controls="btabs-static-settings-1" aria-selected="true">General Settings</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-static-settings-2-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings-2" role="tab" aria-controls="btabs-static-settings-2" aria-selected="false" tabindex="-1">Logo Settings</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-static-settings-3-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings-3" role="tab" aria-controls="btabs-static-settings-3" aria-selected="false" tabindex="-1">Icon Settings</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-static-settings-4-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings-4" role="tab" aria-controls="btabs-static-settings-4" aria-selected="false" tabindex="-1">Stamp Settings</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-static-settings-5-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings-5" role="tab" aria-controls="btabs-static-settings-5" aria-selected="false" tabindex="-1">Color Theme</button>
</li>
</ul>
<div class="block-content tab-content">
<div class="tab-pane fade active show" id="btabs-static-settings-1" role="tabpanel" aria-labelledby="btabs-static-settings-1-tab" tabindex="0">
<?php include_once 'includes/general_settings.php'; ?>
</div>
<div class="tab-pane fade" id="btabs-static-settings-2" role="tabpanel" aria-labelledby="btabs-static-settings-2-tab" tabindex="0">
<?php include_once 'includes/logo_settings.php'; ?>
</div>
<div class="tab-pane fade" id="btabs-static-settings-3" role="tabpanel" aria-labelledby="btabs-static-settings-3-tab" tabindex="0">
<?php include_once 'includes/icon_settings.php'; ?>
</div>
<div class="tab-pane fade" id="btabs-static-settings-4" role="tabpanel" aria-labelledby="btabs-static-settings-4-tab" tabindex="0">
<?php include_once 'includes/stamp_settings.php'; ?>
</div>
<div class="tab-pane fade" id="btabs-static-settings-5" role="tabpanel" aria-labelledby="btabs-static-settings-5-tab" tabindex="0">
<?php include_once 'includes/color_settings.php'; ?>
</div>
</div>
</div>
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
<script src="assets/js/plugins/select2/js/select2.full.min.js"></script>
<script>
function cs(signature, element) {
document.getElementById(element).innerHTML = signature;
}

$(".select_2").select2();

document.getElementById("image_logo").addEventListener("change", function(event) {
const file = event.target.files[0];
const preview = document.getElementById("logo_preview");
if (!file) {
preview.src = 'storage/images/misc/<?php echo $info['logo']; ?>';
return;
}
if (!file.type.startsWith("image/")) {
preview.src = 'storage/images/misc/<?php echo $info['logo']; ?>';
return;
}
const reader = new FileReader();
reader.onload = function(e) {
preview.src = e.target.result;
};
reader.onerror = function() {
preview.src = 'storage/images/misc/<?php echo $info['logo']; ?>';
};
reader.readAsDataURL(file);
});



document.getElementById("image_icon").addEventListener("change", function(event) {
const file = event.target.files[0];
const preview = document.getElementById("icon_preview");
if (!file) {
preview.src = 'storage/images/misc/<?php echo $info['icon']; ?>';
return;
}
if (!file.type.startsWith("image/")) {
preview.src = 'storage/images/misc/<?php echo $info['icon']; ?>';
return;
}
const reader = new FileReader();
reader.onload = function(e) {
preview.src = e.target.result;
};
reader.onerror = function() {
preview.src = 'storage/images/misc/<?php echo $info['icon']; ?>';
};
reader.readAsDataURL(file);
});




document.getElementById("image_stamp").addEventListener("change", function(event) {
const file = event.target.files[0];
const preview = document.getElementById("stamp_preview");
if (!file) {
preview.src = 'storage/images/misc/<?php echo $info['stamp']; ?>';
return;
}
if (!file.type.startsWith("image/")) {
preview.src = 'storage/images/misc/<?php echo $info['stamp']; ?>';
return;
}
const reader = new FileReader();
reader.onload = function(e) {
preview.src = e.target.result;
};
reader.onerror = function() {
preview.src = 'storage/images/misc/<?php echo $info['stamp']; ?>';
};
reader.readAsDataURL(file);
});


</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
