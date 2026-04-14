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

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN' && !empty($_SESSION['filter']) && !empty($_SESSION['merged'])) {

$page = $utility->get_page();

$promoted_students = 0;

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Confirm Students Promotion'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Sserwanga Abdul">
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
Confirm Students Promotion from <?php echo $classes->show($_SESSION['filter']['class'])['name'].' to '.$classes->show($_SESSION['filter']['next_class'])['name'].''; ?>
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">
<form autocomplete="off" class="app_frm" action="app/routes/confirm_promotion" method="POST">
<div class="row">
<?php
foreach ($_SESSION['merged'] as $key => $value) {


if (isset($value['average'])) {
$column = $value['average'];
$title = 'Average';
}else{
$column = $value['points'];
$title = 'Points';
}

$std_profile = $students->show($key);

if (!empty($_SESSION['filter']['promote_all'])) {

$status = '<div class="d-inline-block px-2 py-1 rounded-pill fs-sm fw-semibold text-success bg-success-light">
<i class="far fa-circle-check me-1"></i>
PROMOTED
</div>';

$promoted_students++;

}else{

$weight = $_SESSION['filter']['required_score'];

switch ($_SESSION['filter']['criteria']) {
case 'LESS THAN':

if ($column < $weight) {
$status = '<div class="d-inline-block px-2 py-1 rounded-pill fs-sm fw-semibold text-success bg-success-light">
<i class="far fa-circle-check me-1"></i>
PROMOTED
</div>';

$promoted_students++;

}else{
$status = '<div class="d-inline-block px-2 py-1 rounded-pill fs-sm fw-semibold text-danger bg-danger-light">
<i class="far fa-circle-xmark me-1"></i>
NOT PROMOTED
</div>';
}

break;

default:

if ($column > $weight) {
$status = '<div class="d-inline-block px-2 py-1 rounded-pill fs-sm fw-semibold text-success bg-success-light">
<i class="far fa-circle-check me-1"></i>
PROMOTED
</div>';

$promoted_students++;

}else{
$status = '<div class="d-inline-block px-2 py-1 rounded-pill fs-20 fw-semibold text-danger bg-danger-light">
<i class="far fa-circle-xmark me-1"></i>
NOT PROMOTED
</div>';
}

break;
}

}

?>
<div class="col-md-6 col-xl-3">
<a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
<div class="block-content block-content-full">
<img class="img-avatar" src="storage/images/students/<?php echo empty($std_profile['display_img']) ? $std_profile['gender'].'.png' : $std_profile['display_img']; ?>">
</div>
<div class="block-content block-content-full block-content-sm bg-body-light">
<p class="fw-semibold mb-0"><?php echo $std_profile['first_name'].' '.$std_profile['last_name'].''; ?></p>
<p class="fs-sm fw-medium text-muted mb-0">
<?php echo $std_profile['reg_no']; ?>
</p>
</div>
<div class="block-content block-content-full">
<div class="row g-sm">
<div class="col-6">
<p class="mb-2">
<?php echo $title; ?>
</p>
<p class="fs-sm fw-medium text-muted mb-0">
<?php echo $column;?>
</p>
</div>
<div class="col-6">
<p class="mb-2">
Status
</p>
<p class="fs-sm fw-medium text-muted mb-0">
<?php echo $status;?>
</p>
</div>
</div>
</div>
</a>
</div>
<?php
}
?>


<div class="mb-3">
<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0"><strong><?php echo number_format($promoted_students); ?></strong> students are eligible for promotion,
<strong><?php echo number_format(count($_SESSION['merged'])-$promoted_students); ?></strong> have not met the criteria</p>
</div>
</div>
<?= $utility->csrf_field('confirm_promotion.php', 3600) ?>
<button type="submit" class="btn btn-primary">Confirm Promotion</button>
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
<script src="assets/js/plugins/select2/js/select2.full.min.js"></script>
<script src="assets/loader/waitMe.js"></script>

</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
