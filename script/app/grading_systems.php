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
<title><?php echo $info['name'].' - Grading Systems'; ?></title>
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
Grading Systems
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

<table class="table table-bordered table-striped table-vcenter srms_table table-sm">
<thead>
<tr>
<th>Name</th>
<th width="100">Status</th>
<th width="100"></th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<div class="modal fade" id="modal-add" role="dialog" aria-labelledby="modal-add"  data-bs-keyboard="false" data-bs-backdrop="static">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="block block-rounded block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h4 class="block-title">Add Grading System</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/add_grading_system" method="POST">
<div class="mb-2">
<label class="form-label">Name</label>
<input type="text" required class="form-control" name="name" placeholder="Enter grading system name">
</div>

<div class="grade_div">
<div class="row">
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12">
<label class="form-label">Grade</label>
<input type="text" name="grade[]" class="form-control txt_upper" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Minimum Score</label>
<input type="text" name="min_score[]" class="form-control score-range" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Maximum Score</label>
<input type="text" name="max_score[]" class="form-control score-range" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Points</label>
<input type="text" name="points[]" class="form-control score-range" required>
</div>
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Remark</label>
<input type="text" name="remark[]" class="form-control txt_upper" required>
</div>

<div class="col-xl-6 col-l-6 col-md-12 col-sm-12 mb-2">
<label class="form-label">Class Teacher's Comment</label>
<input type="text" name="teacher_comment[]" class="form-control txt_cap" required>
</div>
<div class="col-xl-6 col-l-6 col-md-12 col-sm-12 mb-2">
<label class="form-label">Head Teacher's Comment</label>
<input type="text" name="head_teacher_comment[]" class="form-control txt_cap" required>
</div>

</div>
</div>

<div class="grading_details">

</div>

<div class="mb-3">
<label class="form-label">Status</label>
<select required class="form-control" name="account_status">
<option value="" selected disabled>Select Option</option>
<option value="ENABLED">ENABLED</option>
<option value="DISABLED">DISABLED</option>
</select>
</div>
<?= $utility->csrf_field('add_grading_system.php', 600) ?>
<div class="mb-4">
<button type="submit" class="btn btn-primary">Save</button>
<button type="button" onclick="add_scale('grading_details');" class="btn btn-success">Add Scale</button>
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
<h4 class="block-title">Edit Grading System</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/update_grading_system" method="POST">
<div id="ajax_response"></div>
<?= $utility->csrf_field('update_grading_system.php', 600) ?>
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
url: 'ajax_tables/grading_system_list',
type: "GET"
},

columnDefs: [{className: 'text-center', targets: [1,2]}],


processing: true,
serverSide: true,
pageLength: 10,
autoWidth: !1,
responsive: !0,
"ordering": false
})

function add_scale(element) {
var count = $('.scale_content').length + 1;
var id = "scale_" + count;

$('.'+element).append(`<div class="grade_div" id="${id}">
<div class="row">
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12">
<label class="form-label">Grade</label>
<input type="text" name="grade[]" class="form-control txt_upper" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Minimum Score</label>
<input type="text" name="min_score[]" class="form-control score-range" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Maximum Score</label>
<input type="text" name="max_score[]" class="form-control score-range" required>
</div>
<div class="col-xl-2 col-l-2 col-md-6 col-sm-12 mb-2">
<label class="form-label">Points</label>
<input type="text" name="points[]" class="form-control score-range" required>
</div>
<div class="col-xl-4 col-l-4 col-md-6 col-sm-12 mb-2">
<label class="form-label">Remark</label>
<input type="text" name="remark[]" class="form-control txt_upper" required>
</div>
<div class="col-xl-6 col-l-5 col-md-11 col-sm-11 mb-2">
<label class="form-label">Class Teacher's Comment</label>
<input type="text" name="teacher_comment[]" class="form-control txt_cap" required>
</div>
<div class="col-xl-5 col-l-5 col-md-11 col-sm-11 mb-2">
<label class="form-label">Head Teacher's Comment</label>
<input type="text" name="head_teacher_comment[]" class="form-control txt_cap" required>
</div>
<div class="col-xl-1 col-l-1 col-md-1 col-sm-1 mb-2">
<button type="button" class="btn btn-danger pull_right w-100 remove-scale">
<i class="fa fa-fw fa-trash"></i>
</button>
</div>
</div>
</div>`);
}


$(document).on('click', '.remove-scale', function() {
$(this).closest('.grade_div').remove();
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
