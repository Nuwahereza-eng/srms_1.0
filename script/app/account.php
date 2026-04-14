<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$dashboard = new dashboard_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1) {

$page = $utility->get_page();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Account Settings'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
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

<div class="row mb-4">
<div class="col-xl-6 col-l-6 col-md-12 col-sm-12">
<div class="block block-rounded">
<div class="block-content">
<h2 class="content-heading pt-0"><i class="fa fa-fw fa-user text-muted me-1"></i> Account Information</h2>
<form autocomplete="off" class="app_frm" action="app/routes/update_profile" method="POST">
<?php require_once !empty($profile['role']) ? 'includes/staff_account.php' : 'includes/student_account.php'; ?>
<div class="mb-4"><button type="submit" name="submit" value="1" class="btn w-100 btn-primary app_btn">Save Changes</button>
</div>
<?= $utility->csrf_field('update_profile.php', 600) ?>
</form>

</div>
</div>
</div>
<div class="col-xl-6 col-l-6 col-md-12 col-sm-12">
<div class="block block-rounded">
<div class="block-content">
<h2 class="content-heading pt-0"><i class="fa fa-fw fa-asterisk text-muted me-1"></i> Change Password</h2>
<form autocomplete="off" class="app_frm" action="app/routes/change_password" method="POST">
<div class="mb-2">
<label class="form-label">Current Password</label>
<div class="input-group">
<input id="cpass" type="password" class="form-control" name="current_pw" placeholder="Enter your current password">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
</div>
</div>
<div class="mb-2">
<label class="form-label">New Password</label>
<div class="input-group">
<input id="npass" type="password" class="form-control" name="new_pw" placeholder="Enter your new password">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
</div>
</div>

<div class="mb-2">
<label class="form-label">Confirm New Password</label>
<div class="input-group">
<input id="cnpass" type="password" class="form-control" name="confirm_new_pw" placeholder="Confirm your new password">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
</div>
</div>

<div class="d-sm-flex justify-content-sm-between text-sm-start mb-2">
<div class="fw-semibold fs-sm py-1">
<a href="<?php echo !empty($profile['role']) ? './staff/reset_pw' : './reset_pw'; ?>">Forgot Password?</a>
</div>
</div>

<div class="mb-4"><button id="sub_btnp" type="submit" name="submit" value="1" class="btn w-100 btn-primary app_btn">Change Password</button>
</div>
<?= $utility->csrf_field('change_password.php', 600) ?>
</form>

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
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/loader/waitMe.js"></script>

</body>
</html>
<?php
require_once('includes/check_reply.php');
}else{
header("location:../staff/login");
}
?>
