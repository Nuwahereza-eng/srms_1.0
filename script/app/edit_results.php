<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$sn = new results_serial_numbers_controller;
$results = new examination_results_controller;
$ca = new continuous_assessments_controller;
$_subjects = new subjects_controller;
$classes = new classes_controller;
$terms = new academic_terms_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && !empty($_SESSION['manage_data'])) {

$r_data = $_SESSION['manage_data'];

$std_profile = [];

$r_data['students'] = unserialize($r_data['students']);
$r_data['subjects'] = unserialize($r_data['subjects']);

foreach ($r_data['students'] as $key => $value) {

array_push($std_profile, $students->show($value));

}


$page = $utility->get_page();

if (!empty($std_profile)) {
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Manage Results'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
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

<div class="block block-rounded col-12">
<div class="block-header block-header-default">
<h3 class="block-title">
<?php echo $classes->show($r_data['class'])['name'].' > '.$terms->show($r_data['term'])['name'].' > '.$ca->show($r_data['ca'])['name']; ?>
</h3>
</div>
<form enctype="multipart/form-data" class="app_frm" action="app/routes/update_results" method="POST" autocomplete="off">
<div class="block-content block-content-full mb-5 ">


<div class="row">

<?php
switch (count($std_profile)) {
case '1':
$width = 'col-xl-12 col-lg-12 col-md-12 col-md-12';
break;

case '2':
$width = 'col-xl-6 col-lg-6 col-md-12 col-md-12';
break;

default:
$width = 'col-xl-4 col-lg-4 col-md-12 col-md-12';
break;

}
foreach ($std_profile as $key => $value) {


?>
<div class="block block-rounded <?php echo $width; ?>">
<div class="block-content block-content-full bg-image  text-center">
<img class="img-avatar img-avatar-thumb" src="storage/images/students/<?php echo empty($value['display_img']) ? $value['gender'].'.png' : $value['display_img']; ?>">
</div>
<div class="block-content block-content-full block-content-sm bg-body-light text-center mb-2">
<div class="fw-semibold"><?php echo $value['first_name'].' '.$value['last_name']; ?></div>
<div class="fs-sm text-muted"><?php echo $value['reg_no']; ?></div>
</div>

<?php

foreach ($r_data['subjects'] as $key2 => $value2) {

$previous_record = $results->check_record($value['reg_no'], $r_data['class'], $r_data['term'], $r_data['ca']);

$score = NULL;

if (!empty($previous_record)) {

$current_somo_id = $value2;

$matokeo = unserialize($previous_record['results']);

if (isset($matokeo[$current_somo_id])) {

$score = $matokeo[$current_somo_id];

}

}
?>
<div class="col-12">
<div class="mb-2">
<label class="form-label" ><?php echo $_subjects->show($value2)['code'].' : '.$_subjects->show($value2)['name']; ?></label>
<input type="text" value="<?php echo $score; ?>" class="form-control score-range" name="<?php echo $value['reg_no'].'SCORE'.$value2; ?>" placeholder="Enter score">
</div>
</div>
<?php
}
?>
</div>
<?php
}
?>

</div>
<?php
if (count($std_profile) > 0) {

echo $utility->csrf_field('update_results.php', 3600);

?>
<div class="col-sm-8">
<button type="submit" class="btn btn-primary">Save</button>
</div>

<?php

}else{

?>
<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0">No examination results were found for selected data.</p>
</div>
</div>

<?php

}
?>
</div>
</form>
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
</body>
</html>
<?php
}else{
header("location:manage_results");
}
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
