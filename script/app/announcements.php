<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Announcements'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Sserwanga Abdul">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
<link href="summernote/dist/summernote-lite.css" rel="stylesheet" />
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
Announcements
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
<th>Title</th>
<th width="220">Audience</th>
<th width="220">Date Published</th>
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
<h4 class="block-title">Add Announcements</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/add_announcements" method="POST">
<div class="mb-2">
<label class="form-label">Announcement Title</label>
<input type="text" required class="form-control txt_cap" name="title" placeholder="Enter announcement title">
</div>
<div class="mb-2">
<label class="form-label">Audience</label>
<select required class="form-control" name="audience">
<option value="" selected disabled>Select Audience</option>
<option value="Teachers">Teachers</option>
<option value="Students">Students</option>
<option value="Both">Teachers & Students</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Announcement</label>
<textarea name="announcement" class="form-control editor" placeholder="Enter announcement here" required></textarea>
</div>
<?= $utility->csrf_field('add_announcements.php', 600) ?>
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
<h4 class="block-title">Edit Announcement</h4>
</div>
<div class="block-content">
<form autocomplete="off" class="app_frm" action="app/routes/update_announcement" method="POST">
<div id="ajax_response"></div>
<?= $utility->csrf_field('update_announcement.php', 600) ?>
</form>
</div>
</div>
</div>
</div>
</div>
<?php
}else{


}
?>
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
<script src="summernote/dist/summernote-lite.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script src="assets/js/plugins/select2/js/select2.full.min.js"></script>
<script>
<?php

if ($profile['role'] == 'ADMIN') {
?>
$(".srms_table").DataTable({
layout: {
topStart: {
pageLength: {
menu: [10, 15, 20, 50, 100]
}
}
},

ajax: {
url: 'ajax_tables/announcements_list',
type: "GET"
},

columnDefs: [{className: 'text-center', targets: [3]}],


processing: true,
serverSide: true,
pageLength: 10,
autoWidth: !1,
responsive: !0,
"ordering": false
})

var customButtons = [
['font', ['bold', 'italic', 'underline', 'clear']],
['para', ['ul', 'ol', 'paragraph']],
['view', ['codeview']]
];

$('.editor').summernote({
toolbar: customButtons,
tabsize: 2,
height: 200
});
<?php
}
?>
</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
