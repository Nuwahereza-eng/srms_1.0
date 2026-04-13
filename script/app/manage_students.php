<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Manage Students'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Bwire Mashauri">
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
Manage Students
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">

<table class="table table-bordered table-striped table-vcenter srms_table table-sm">
<thead>
<tr>
<th width="50"></th>
<th>Reg. Number</th>
<th>Name</th>
<th>Gender</th>
<th>Email Address</th>
<th>Class</th>
<th width="100">Status</th>
<th width="130"></th>
</tr>
</thead>
<tbody>
</tbody>
</table>
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
$(".srms_table").DataTable({
layout: {
topStart: {
pageLength: {
menu: [10, 15, 20, 50, 100]
}
}
},

ajax: {
url: 'ajax_tables/students_list',
type: "GET"
},

columnDefs: [{className: 'text-center', targets: [0,6,7]}],


processing: true,
serverSide: true,
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
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
