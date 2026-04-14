<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$exams = new examination_results_controller;
$grading_systems = new grading_systems_controller;
$terms = new academic_terms_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 0) {

$page = $utility->get_page();

$madarasa_aliyofanyia_mtihani = $students->runQuery("SELECT class_id FROM examination_results WHERE reg_no = ?
  GROUP BY class_id", array($profile['reg_no']));

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Examination Results'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Sserwanga Abdul">
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
<h3 class="block-title">Examination Results</small></h3>
</div>
<div class="block-content">
<div class="row">
<div class="col-lg-12 push">
<?php
if (count($madarasa_aliyofanyia_mtihani) < 1) {

print '<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0">You have not attended any examination on any class or results have not been published yet.</p>
</div>
</div>';

}

?>
<div id="accordion" role="tablist" aria-multiselectable="true">

<?php
foreach ($madarasa_aliyofanyia_mtihani as $key => $value) {
$scale_ya_grading = unserialize($grading_systems->show($classes->show($value['class_id'])['grading_system'])['details']);

$masomo_anayo_soma = $students->runQuery("SELECT d.id, d.code, d.name, d.is_principal, d.status FROM subject_combinations a JOIN classes b ON a.class_id = b.id
JOIN programmes c ON b.programme = c.id JOIN subjects d ON a.subject_id = d.id WHERE a.class_id = ?", array($value['class_id']));

$tem_alizofanyia_mtihani_kwenye_darasa = $students->runQuery("SELECT term
  FROM examination_results JOIN academic_terms ON examination_results.term = academic_terms.id
  WHERE reg_no = ? AND class_id = ? AND show_results = 'YES' GROUP BY term", array($profile['reg_no'], $value['class_id']));

?>
<div class="block block-rounded mb-1 news_div">
<div class="block-header block-header-default" role="tab" id="accordion_h<?php echo $key; ?>">
<a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q<?php echo $key; ?>" aria-expanded="true" aria-controls="accordion_q<?php echo $key; ?>">
<?php echo $classes->show($value['class_id'])['name']; ?>
</a>
</div>
<div id="accordion_q<?php echo $key; ?>" class="collapse" role="tabpanel" aria-labelledby="accordion_h<?php echo $key; ?>" data-bs-parent="#accordion">
<div class="block-content">
<div class="block block-rounded">
<ul class="nav nav-tabs nav-tabs-alt" role="tablist">

<?php
foreach ($tem_alizofanyia_mtihani_kwenye_darasa as $key2 => $value2) {

if ($key2 < 1) {

?>
<li class="nav-item" role="presentation">
<button class="nav-link active" id="btabs-alt-static-term<?php echo $value2['term']; ?>-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-term<?php echo $value2['term']; ?>" role="tab" aria-controls="btabs-alt-static-term<?php echo $value2['term']; ?>" aria-selected="true"><?php echo $terms->show($value2['term'])['name']; ?></button>
</li>
<?php
}else{
?>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-alt-static-term<?php echo $value2['term']; ?>-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-term<?php echo $value2['term']; ?>" role="tab" aria-controls="btabs-alt-static-term<?php echo $value2['term']; ?>" aria-selected="false" tabindex="-1"><?php echo $terms->show($value2['term'])['name']; ?></button>
</li>
<?php
}
}
?>

</ul>
<div class="block-content tab-content">


<?php

if (count($tem_alizofanyia_mtihani_kwenye_darasa) < 1) {

print '<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0">You have not attended any examination on this class or results have not been published yet.</p>
</div>
</div>';

}
?>
<?php
foreach ($tem_alizofanyia_mtihani_kwenye_darasa as $key2 => $value2) {

$ca_za_tem = unserialize($students->runQuery("SELECT ca FROM academic_terms WHERE id = ? AND show_results = ?", array($value2['term'], 'YES'))[0]['ca']);

$tebo = '';

foreach ($masomo_anayo_soma as $key3 => $value3) {
$data_za_ca = '';
$heda_za_ca = '';
$sum_za_ca = 0;

foreach ($ca_za_tem as $key4 => $value4) {

$record = $exams->check_record($profile['reg_no'], $value['class_id'], $value2['term'], $value4);

if (!empty($record)) {
$record_2 = unserialize($record['results']);


if (isset($record_2[$value3['id']])) {

$ca_score = $utility->score($record_2[$value3['id']]);

$sum_za_ca = $sum_za_ca + $ca_score;

}else{

$ca_score = 'x';

}

}else{
$ca_score = '-';
}

$data_za_ca = $data_za_ca.'
<td class="text-center">
<span>'.$ca_score.'</span>
</td>
';


$heda_za_ca = $heda_za_ca.'<th class="text-center">CA '.($key4 + 1).'</th>';

}

$sum_za_ca = $utility->score($sum_za_ca);
$grade_ya_somo = '-';
$remark_ya_somo = '-';

foreach($scale_ya_grading as $grade)
{

if (floor($sum_za_ca) >= $grade['min_score'] && floor($sum_za_ca) <= $grade['max_score']) {

$grade_ya_somo = $grade['grade'];
$remark_ya_somo = $grade['remark'];

}

}


$tebo = $tebo.'<tr>
<td>
<span class="fw-semibold">'.$value3['code'].'</span>
</td>
<td>
<span>'.$value3['name'].'</span>
</td>'.$data_za_ca.'
<td class="text-center">
<span>'.$sum_za_ca.'</span>
</td>
<td class="text-center">
<span>'.$grade_ya_somo.'</span>
</td>
<td class="text-center">
<span>'.$remark_ya_somo.'</span>
</td>
</tr>';

}




if ($key2 < 1) {

?>
<div class="tab-pane fade active show" id="btabs-alt-term<?php echo $value2['term']; ?>" role="tabpanel" aria-labelledby="btabs-alt-static-term<?php echo $value2['term']; ?>-tab" tabindex="0">
<table class="table table-striped table-hover table-bordered table-vcenter fs-sm table-sm">
<thead>
<tr class="">
<th width="140">SUBJECT CODE</th>
<th>SUBJECT NAME</th>
<?php echo $heda_za_ca; ?>
<th class="text-center">TOTAL</th>
<th class="text-center">GRADE</th>
<th class="text-center">REMARK</th>
</tr>
</thead>
<?php echo $tebo; ?>
</table>
<a target="_blank" href="app/report?term=<?php echo $value2['term']; ?>" class="btn btn-info btn-sm me-1 mb-3"><i class="fa fa-fw fa-download me-1"></i> Download Report</a>
</div>
<?php
}else{
?>
<div class="tab-pane fade" id="btabs-alt-term<?php echo $value2['term']; ?>" role="tabpanel" aria-labelledby="btabs-alt-static-term<?php echo $value2['term']; ?>-tab" tabindex="0">
<table class="table table-striped table-hover table-bordered table-vcenter fs-sm table-sm">
<thead>
<tr class="">
<th width="140">SUBJECT CODE</th>
<th>SUBJECT NAME</th>
<?php echo $heda_za_ca; ?>
<th class="text-center">TOTAL</th>
<th class="text-center">GRADE</th>
<th class="text-center">REMARK</th>
</tr>
</thead>
<?php echo $tebo; ?>
</table>
<a target="_blank" href="app/report?term=<?php echo $value2['term']; ?>" class="btn btn-info btn-sm me-1 mb-3"><i class="fa fa-fw fa-download me-1"></i> Download Report</a>
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
