<?php
require_once 'autoload.php';
$school = new school_controller;
$info = $school->index();
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Staff Login'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Bwire Mashauri">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container">
<main id="main-container">
<div>

<div class="row g-0 justify-content-center">

<div class="hero-static col-sm-8 col-md-6 col-xl-3 d-flex align-items-center p-2 px-sm-0">

<div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">

<div class="block-content block-content-full px-lg-5 px-xl-5 py-5 py-md-5 py-lg-5 bg-body-extra-light">
<div class="text-center">
<img src="storage/images/misc/<?php echo $info['logo']; ?>" height="130" alt="School Logo">
<h4 class="font-size-13 mt-3">Students Results Management System</h4>
<p class="text-muted login_paragraph">Enter your Credentials to Login</p>
</div>
<form autocomplete="off" class="app_frm" action="routes/staff_auth" method="POST">
<div class="mb-2">
<label class="form-label">Email</label>
<div class="input-group">
<input required type="email" class="form-control" name="email" placeholder="Enter email address">
<span class="input-group-text">
<i class="fa fa-envelope"></i>
</span>
</div>
</div>
<div class="mb-2">
<label class="form-label">Password</label>
<div class="input-group">
<input required type="password" class="form-control" name="password" placeholder="Enter your login password">
<span class="input-group-text">
<i class="fa fa-lock"></i>
</span>
</div>
</div>

<div class="d-sm-flex justify-content-sm-between text-sm-start mb-2">
<div class="fw-semibold fs-sm py-1">
<a href="staff/reset_pw">Forgot Password?</a>
</div>
<div class="fw-semibold fs-sm py-1">
<a href="./">Student Login</a>
</div>
</div>

<div class="mb-3"><button type="submit" name="submit" value="1" class="btn w-100 btn-primary app_btn">Login</button>
</div>
<?= $utility->csrf_field('staff_auth.php', 600) ?>
</form>
</div>
</div>
</div>
</div>
</div>
</main>
</div>
<script src="assets/js/core.js"></script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<?php require_once('includes/check_reply.php'); ?>
</body>
</html>
