<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$terms = new academic_terms_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();

$term_list = $terms->index();

if ($profile['role'] == 'ADMIN') {
$class_list = $classes->index();
}else{
$class_list = $classes->index($profile['id']);
}
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Class Report'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/select2/css/select2.min.css">
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
Class Report
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">
<form autocomplete="off" class="app_frm" action="app/routes/start_report" method="POST">
<div class="row">
<label class="col-sm-12 col-form-label">Class</label>
<div class="col-sm-12">
<select style="width:100%;" class="form-control select_2" name="class" required>
<option value="" selected disabled></option>
<?php
foreach ($class_list as $list) {
?><option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option><?php
}
?>
</select>
</div>
</div>
<div class="row mb-3">
<label class="col-sm-12 col-form-label">Academic Term</label>
<div class="col-sm-12">
<select style="width:100%;" class="form-control select_2" name="term"  required>
<option value="" selected disabled></option>
<?php
foreach ($term_list as $key => $value) {
?><option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
</div>
<?= $utility->csrf_field('start_report.php', 600) ?>
<button type="submit" class="btn btn-primary">Generate Report</button>
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
<script src="assets/js/plugins/select2/js/select2.full.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script>
$(".select_2").select2();
</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
