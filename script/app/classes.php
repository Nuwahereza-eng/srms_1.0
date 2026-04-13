<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$programmes = new programmes_controller;
$gs = new grading_systems_controller;
$ds = new division_systems_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1) {

$page = $utility->get_page();
$programmes_list = $programmes->index();
$gs_list = $gs->index();
$ds_list = $ds->index();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Classes'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Bwire Mashauri">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/select2/css/select2.min.css">
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
Classes
</h3>
<?php
if ($profile['role'] == 'ADMIN') {
?>
<div class="block-options">
<div class="block-options-item">
<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add" data-bs-keyboard="false" data-bs-backdrop="static"><i class="fa fa-plus"></i> Add</button>
</div>
</div>
<?php
}
?>
</div>
<div class="block-content block-content-full overflow-x-auto">

<?php
if ($profile['role'] == 'ADMIN') {
?>
<table class="table table-bordered table-striped table-vcenter srms_table table-sm">
<thead>
<tr>
<th>Name</th>
<th>Programme</th>
<th>Grading System</th>
<th>Division System</th>
<th>Award Method</th>
<th width="100">Status</th>
<th width="100"></th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?php
}else{
?>
<table class="table table-bordered table-striped table-vcenter srms_table table-sm">
<thead>
<tr>
<th>Name</th>
<th>Programme</th>
<th>Grading System</th>
<th>Division System</th>
<th>Award Method</th>
<th width="100">Status</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?php
}
?>

<div class="modal fade" id="modal-add" role="dialog" aria-labelledby="modal-add"  data-bs-keyboard="false" data-bs-backdrop="static">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="block block-rounded block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h4 class="block-title">Add Classes</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/add_class" method="POST">
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" required class="form-control" name="name" placeholder="Enter class name">
</div>
<div class="mb-2">
<label class="form-label">Programme</label>
<select required class="form-control select_2" name="programme" onchange="start_combination(this.value);" style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($programmes_list as $key => $value) {
?><option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div id="sub_lists"></div>
<div class="mb-2">
<label class="form-label">Grading System</label>
<select required class="form-control" name="grading_system"  style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($gs_list as $key => $value) {
?><option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div class="mb-2">
<label class="form-label">Division System</label>
<select class="form-control" name="division_system"  style="width:100%">
<option disabled selected>Select Option</option>
<?php
foreach ($ds_list as $key => $value) {
?><option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option><?php
}
?>
</select>
</div>
<div class="mb-2">
<label class="form-label">Award System</label>
<select required class="form-control" name="award_method">
<option value="" selected disabled>Select Option</option>
<option value="AVERAGE">AVERAGE</option>
<option value="DIVISION">DIVISION</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Status</label>
<select required class="form-control" name="status">
<option value="" selected disabled>Select Option</option>
<option value="ENABLED">ENABLED</option>
<option value="DISABLED">DISABLED</option>
</select>
</div>
<?= $utility->csrf_field('add_class.php', 600) ?>
<div class="mb-4">
<button type="submit" class="btn btn-primary">Save</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modal-edit" role="dialog" aria-labelledby="modal-add"  data-bs-keyboard="false" data-bs-backdrop="static">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="block block-rounded block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h4 class="block-title">Edit Class</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/update_class" method="POST">
<div id="ajax_response"></div>
<?= $utility->csrf_field('update_class.php', 600) ?>
</form>
</div>
</div>
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
$(".srms_table").DataTable({
layout: {
topStart: {
pageLength: {
menu: [10, 15, 20, 50, 100]
}
}
},

ajax: {
url: 'ajax_tables/class_list',
type: "GET"
},

<?php
if ($profile['role'] == 'ADMIN') {
?>
columnDefs: [{className: 'text-center', targets: [4,5,6]}],
<?php
}else{
?>
columnDefs: [{className: 'text-center', targets: [4,5]}],
<?php
}
?>



processing: true,
serverSide: true,
pageLength: 10,
autoWidth: !1,
responsive: !0,
"ordering": false
})

$(".select_2").select2({dropdownParent: document.querySelector("#modal-add")})
</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
