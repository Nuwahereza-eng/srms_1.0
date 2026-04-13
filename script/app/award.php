<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$grading_systems = new grading_systems_controller;
$division_systems = new division_systems_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 0) {

$page = $utility->get_page();

$scale_ya_grading = unserialize($grading_systems->show($classes->show($profile['class'])['grading_system'])['details']);

if ($classes->show($profile['class'])['award_method'] == 'DIVISION') {
$scale_ya_division = unserialize($division_systems->show($classes->show($profile['class'])['division_system'])['details']);
}else{
$scale_ya_division = array();
}



?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Award Systems'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Bwire Mashauri">
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

<div class="col-lg-12">
<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">Award Systems</small></h3>
</div>
<div class="block-content">
<div class="row">
<div class="col-lg-12 push">
<table class="table table-bordered table-vcenter table-sm">
<thead>
<tr>
<th>Grade</th>
<th>Score Range</th>
<th>Remark</th>
</tr>
</thead>
<tbody>
<?php
foreach ($scale_ya_grading as $key => $value) {
?>
<tr>
<td><?php echo $value['grade']; ?></td>
<td width="200"><?php echo $value['min_score'].' - '.$value['max_score']; ?></td>
<td width="200"><?php echo $value['remark']; ?></td>
</tr>
<?php
}
?>
</tbody>
</table>


<?php
if (count($scale_ya_division) > 0) {

?>
<table class="table table-bordered table-vcenter table-sm">
<thead>
<tr>
<th>Award</th>
<th>Point Range</th>
<th>Remark</th>
</tr>
</thead>
<tbody>
<?php
foreach ($scale_ya_division as $key => $value) {
?>
<tr>
<td><?php echo strtoupper($value['scale_name']); ?></td>
<td width="200"><?php echo $value['min_point'].' - '.$value['max_point']; ?></td>
<td width="200"><?php echo $value['remark']; ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
<?php
}
?>
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
</body>
</html>
<?php
}else{
header("location:../");
}
?>
