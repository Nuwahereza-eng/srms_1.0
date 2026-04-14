<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();
$class_list = $classes->index();

unset($_SESSION['current_image']);
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Register Students'; ?></title>
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
<form enctype="multipart/form-data" class="app_frm" action="app/routes/add_student" method="POST" autocomplete="off">
<div class="row">

<div class="col-xl-3">
<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
STUDENT IMAGE
</h3>
</div>
<div class="block-content block-content-full space-y-3">
<div class="content content-full">
<div class="py-2 text-center">
<center><img id="image_preview" class="img_student mb-5 pre_capture_frame" src="storage/images/misc/blank.jpg" alt=""></center>

<button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#modal-camera" data-bs-keyboard="false" data-bs-backdrop="static">
<i class="fa fa-fw fa-camera opacity-50"></i> Take from Camera
</button>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-9">
<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
STUDENT DETAILS
</h3>
</div>
<div class="block-content block-content-full ">

<div class="row mb-2">
<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">First Name</label>
<div class="col-sm-12">
<input name="first_name" required type="text" placeholder="Enter first name" class="form-control txt_cap">
</div>
</div>
</div>
<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">Last Name</label>
<div class="col-sm-12">
<input name="last_name" required type="text" placeholder="Enter last name" class="form-control txt_cap">
</div>
</div>
</div>
</div>


<div class="row mb-2">
<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">Gender</label>
<div class="col-sm-12">
<select class="form-control"  name="gender" required>
<option value="" selected disabled>Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
</div>

<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">Display Image</label>
<div class="col-sm-12">
<input name="file" type="file" accept=".png,.jpg,.jpeg" id="imageInput" class="form-control ">
</div>
</div>
</div>
</div>


<div class="row mb-2">
<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">Email Address</label>
<div class="col-sm-12">
<input name="email" required type="email" placeholder="Enter email address" class="form-control ">
</div>
</div>
</div>
<div class="col-6">
<div class="">
<label class="col-sm-12 col-form-label">Status</label>
<div class="col-sm-12">
<select class="form-control" name="account_status" required>
<option value="" selected disabled>Select Status</option>
<option value="ENABLED">ENABLED</option>
<option value="DISABLED">DISABLED</option>
</select>
</div>
</div>
</div>
</div>


<div class="row mb-3">
<label class="col-sm-12 col-form-label">Class</label>
<div class="col-sm-12">
<select style="width:100%;" class="form-control select_2" name="class" required>
<option value="" selected disabled>Select One</option>
<?php
foreach ($class_list as $list) {
?><option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option><?php
}
?>
</select>
</div>
</div>
<button type="submit" class="btn  btn-primary app_btn">Register Student</button>
</div>
</div>
</div>
<?= $utility->csrf_field('add_student.php', 600) ?>
</form>
</div>
</div>


<div class="modal fade" id="modal-camera" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-camera" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Capture Image</h5>
<button id="btn"  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="container">
<div class="row">
<div class="col-lg-12">
<label class="col-sm-12 col-form-label">Change Camera</label>
<select class="form-control mb-3" id="videoSource"></select>
</div>
<div class="col-lg-6" align="center">
<label><h5>PREVIEW</h5></label>
<div id="my_camera" class="pre_capture_frame" >
Connecting.....
</div>
<input type="hidden" name="captured_image_data" id="captured_image_data">
<br>
<input type="button" class="btn btn-primary btn-round btn-file" value="Take Snapshot" onClick="take_snapshot()">
</div>
<div class="col-lg-6" align="center">
<label><h5>RESULTS</h5></label>
<div id="results" >
<img id="cam_capture" class="pre_capture_frame" src="storage/images/misc/blank.jpg" />
</div>
<br>
<button id="capture_btn" type="button" class="btn btn-primary" disabled onclick="saveSnap()">Save Picture</button>
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
<script src="assets/js/webcam.js"></script>
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
url: 'ajax_tables/teachers_list',
type: "GET"
},

columnDefs: [{className: 'text-center', targets: [3,4]}],


processing: true,
serverSide: true,
pageLength: 10,
autoWidth: !1,
responsive: !0,
"ordering": false
})

$(".select_2").select2();

document.getElementById("imageInput").addEventListener("change", function(event) {
const file = event.target.files[0];
const preview = document.getElementById("image_preview");

if (!file) {
preview.src = 'storage/images/misc/blank.jpg';
return;
}

if (!file.type.startsWith("image/")) {
preview.src = 'storage/images/misc/blank.jpg';
return;
}

const reader = new FileReader();
reader.onload = function(e) {
preview.src = e.target.result;
};
reader.onerror = function() {
preview.src = 'storage/images/misc/blank.jpg';
};
reader.readAsDataURL(file);
});

Webcam.set({
width: 400,
height: 300,
dest_width: 400,
dest_height: 300,
crop_width: 240,
crop_height: 240,
image_format: 'jpeg',
jpeg_quality: 100
});

$("#modal-camera").on('shown.bs.modal', function() {
Webcam.attach('#my_camera');
$("#capture_btn").prop("disabled", true);
});

$("#modal-camera").on('hide.bs.modal', function() {
Webcam.reset('#my_camera');
$("#capture_btn").prop("disabled", true);
});

const shutter = new Audio();
shutter.autoplay = false;

shutter.src = "storage/sounds/camera-shutter-click-01.bwire";

function take_snapshot() {
$("#capture_btn").prop("disabled", false);

try { shutter.currentTime = 0; shutter.play(); } catch(e) {}

Webcam.snap(function(data_uri) {
document.getElementById('results').innerHTML =
'<img class="after_capture_frame" src="' + data_uri + '"/>';
$("#captured_image_data").val(data_uri);
});
}

$('#videoSource').on('change', function() {
let deviceId = $(this).val();

Webcam.reset();

const cameraDiv = document.getElementById('my_camera');
cameraDiv.innerHTML = 'Connecting.....';

setTimeout(() => {
Webcam.set({
width: 400,
height: 300,
dest_width: 400,
dest_height: 300,
crop_width: 240,
crop_height: 240,
image_format: 'jpeg',
jpeg_quality: 100,
constraints: {
deviceId: { exact: deviceId }
}
});
Webcam.attach('#my_camera');
}, 800);
});

navigator.mediaDevices.enumerateDevices().then(function(devices) {
devices.forEach(function(device, i) {
if (device.kind === 'videoinput') {
let option = document.createElement('option');
option.value = device.deviceId;
option.text = device.label || `Camera ${i + 1}`;
document.querySelector('select#videoSource').appendChild(option);
}
});

const first = $('#videoSource option:first').val();
if (first) $('#videoSource').val(first);
});

function saveSnap(){
var base64data = $("#captured_image_data").val();
$('#image_preview').attr('src', base64data);
$("#modal-camera").modal('hide');

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: '',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}

$.ajax({
type: "POST",
dataType: "json",
url: "getter/capture_image.php",
data: {image: base64data},
success: function(data) {
$('.app_frm').waitMe('hide');
}
});

}
</script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
