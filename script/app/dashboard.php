<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$dashboard = new dashboard_controller;
$announcements = new announcements_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && !empty($profile['role'])) {

$page = $utility->get_page();
$latest_news = $announcements->get_latest('Teachers');

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Dashboard'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?> enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">
<?php require_once $profile['role'] == 'ADMIN' ? 'includes/admin_dashboard.php' : 'includes/teacher_dashboard.php' ;?>

<?php
if ($profile['role'] == 'TEACHER') {
?>
<div class="col-lg-12">
<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">Announcements</small></h3>
</div>
<div class="block-content">
<div class="row">
<div class="col-lg-12 push">
<?php
if (count($latest_news) < 1) {

print '<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0">No any published announcements at the moment.</p>
</div>
</div>';

}

?>
<div id="accordion" role="tablist" aria-multiselectable="true">

<?php
foreach ($latest_news as $key => $value) {
if ($key == 0) {
?>
<div class="block block-rounded mb-1 news_div">
<div class="block-header block-header-default" role="tab" id="accordion_h<?php echo $key; ?>">
<a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q<?php echo $key; ?>" aria-expanded="true" aria-controls="accordion_q<?php echo $key; ?>"><?php echo ($key+1).'. '.$value['title']; ?></a>
</div>
<div id="accordion_q<?php echo $key; ?>" class="collapse show" role="tabpanel" aria-labelledby="accordion_h<?php echo $key; ?>" data-bs-parent="#accordion">
<div class="block-content">
<?php echo $value['announcement']; ?>
<?php echo '<i>'.date("F d, Y G:i:s A", strtotime($value['date_published'])).'</i>'; ?>
</div>
</div>
</div>
<?php
}else{
?>
<div class="block block-rounded mb-1 news_div">
<div class="block-header block-header-default" role="tab" id="accordion_h<?php echo $key; ?>">
<a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q<?php echo $key; ?>" aria-expanded="true" aria-controls="accordion_q<?php echo $key; ?>"><?php echo ($key+1).'. '.$value['title']; ?></a>
</div>
<div id="accordion_q<?php echo $key; ?>" class="collapse" role="tabpanel" aria-labelledby="accordion_h<?php echo $key; ?>" data-bs-parent="#accordion">
<div class="block-content">
<?php echo $value['announcement']; ?>
<?php echo '<i>'.date("F d, Y G:i:s A", strtotime($value['date_published'])).'</i>'; ?>
</div>
</div>
</div>
<?php
}
}
?>

</div>
</div>
</div>


</div>
</div>
</div>
<?php
}
?>
</div>
</main>
<?php require_once 'includes/footer.php'; ?>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/core.js"></script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
?>
