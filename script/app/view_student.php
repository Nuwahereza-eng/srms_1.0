<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$sn = new results_serial_numbers_controller;
$classes = new classes_controller;
$terms = new academic_terms_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN' && !empty($_GET['reg'])) {

$std_profile = $students->show($_GET['reg']);
$page = $utility->get_page();

if (!empty($std_profile)) {
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - '.$_GET['reg']; ?></title>
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
<h3 class="block-title text-center">
<?php echo $std_profile['first_name'].' '.$profile['last_name'].' ('.$std_profile['reg_no'].')' ; ?>
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">

<div class="block-content block-content-full text-center bg-image">
<img class="img-avatar img-avatar-thumb img-avatar128" src="storage/images/students/<?php echo empty($std_profile['display_img']) ? $std_profile['gender'].'.png' : $std_profile['display_img']; ?>">
</div>
<div class="block-content block-content-full block-content-sm bg-body-light text-center">
<div class="fw-semibold"><?php echo $std_profile['first_name'].' '.$profile['last_name']; ?></div>
<div class="fs-sm text-muted"><?php echo $std_profile['reg_no']; ?></div>
<div class="fs-sm text-muted"><b>Gender</b> : <?php echo $std_profile['gender']; ?></div>
<div class="fs-sm text-muted"><b>Email</b> : <?php echo $std_profile['email']; ?></div>
<div class="fs-sm text-muted"><b>Class</b> : <?php echo $classes->show($std_profile['class'])['name']; ?></div>
</div>

<div class="table-responsive mt-3">
<table class="table table-bordered table-striped table-vcenter table-sm">
<thead>
<tr>
<th>Examination Class</th>
<th>Examination Term</th>
<th>Serial Number</th>
<th width="180" align="center">Examination Report</th>
</tr>
</thead>
<tbody>

<?php
$madarasa_aliyofanyia_mtihani = $students->runQuery("SELECT class_id FROM examination_results
WHERE reg_no = ? GROUP BY class_id", array($std_profile['reg_no']));

foreach ($madarasa_aliyofanyia_mtihani as $key => $value) {

$tem_alizofanyia_mtihani_kwenye_darasa = $students->runQuery("SELECT term
FROM examination_results JOIN academic_terms ON examination_results.term = academic_terms.id
WHERE reg_no = ? AND class_id = ? GROUP BY term", array($std_profile['reg_no'], $value['class_id']));


foreach ($tem_alizofanyia_mtihani_kwenye_darasa as $key2 => $value2) {

$serial = $sn->show($std_profile['reg_no'], $madarasa_aliyofanyia_mtihani[0]['class_id'], $value2['term']);

if ((isset($_SERVER['HTTPS']) &&   (($_SERVER['HTTPS'] == 'on'))) || (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] == 443))
{
$actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
else
{
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}

$signature = $serial['serial_no'];
$actual_link = str_replace("app/view_student.php","documents?signature=$signature",$actual_link);

?>
<tr>
<td>
<?php echo $classes->show($value['class_id'])['name']; ?>
</td>
<td>
<?php echo $terms->show($value2['term'])['name']; ?>
</td>
<td>
<?php echo strtoupper($serial['serial_no']); ?>
</td>
<td align="center">
<a target="_blank" class="btn btn-sm btn-primary me-1" href="<?php echo $actual_link; ?>">Download</a>
</td>
</tr>
<?php
}

}
?>
</tbody>
</table>
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
<script>
$(".table-sm").DataTable({
layout: {
topStart: {
pageLength: {
menu: [10, 15, 20, 50, 100]
}
}
},

columnDefs: [{className: 'text-center', targets: [3]}],
pageLength: 10,
autoWidth: !1,
responsive: !0,
"ordering": false
})
</script>
</body>
</html>
<?php
}else{
header("location:manage_students");
}
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
