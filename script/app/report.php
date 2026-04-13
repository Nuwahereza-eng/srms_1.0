<?php
chdir('../');
error_reporting(0);
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$exams = new examination_results_controller;
$grading_systems = new grading_systems_controller;
$division_systems = new division_systems_controller;
$sig = new signatures_controller;
$sn = new results_serial_numbers_controller;
$terms = new academic_terms_controller;
$classes = new classes_controller;
$session = new session;
$info = $school->index();
date_default_timezone_set($info['timezone']);

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 0 && !empty($_GET['term'])) {

$signatures = $sig->index();

$madarasa_aliyofanyia_mtihani = $students->runQuery("SELECT class_id FROM examination_results WHERE reg_no = ? AND term = ?
  GROUP BY class_id", array($profile['reg_no'], $_GET['term']));

if (empty($madarasa_aliyofanyia_mtihani)) {

header("location:results");

}else{

$serial = $sn->show($profile['reg_no'], $madarasa_aliyofanyia_mtihani[0]['class_id'], $_GET['term']);

if ((isset($_SERVER['HTTPS']) &&   (($_SERVER['HTTPS'] == 'on'))) || (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] == 443))
{
$actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
else
{
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}

$signature = $serial['serial_no'];
$actual_link = str_replace("app/report.php","documents?signature=$signature",$actual_link);

$students_in_class = [];

$full_matokeo = $students->runQuery("SELECT * FROM examination_results
  WHERE class_id = ? AND term = ?", array($madarasa_aliyofanyia_mtihani[0]['class_id'], $_GET['term']));


foreach ($full_matokeo as $key => $value) {

$reg_no = $value["reg_no"];

$results = unserialize($value["results"]);

foreach ($results as $key1 => $value1) {

$result_key = $reg_no.'_RESULT'.$key1;


if (isset($matokeo[$result_key])) {

$matokeo[$result_key] = $matokeo[$result_key] + $value1;

}else{

$matokeo[$result_key] = $value1;

}

}

if (!in_array($reg_no, $students_in_class)) {
array_push($students_in_class, $reg_no);
}

}

$masomo_yanayohesabiwa = $students->runQuery("SELECT b.subject_id, a.is_principal FROM subject_combinations b
JOIN subjects a ON b.subject_id = a.id WHERE b.class_id = ? AND a.is_principal = 'YES'", array($madarasa_aliyofanyia_mtihani[0]['class_id']));

$masomo_yanayohesabiwa2 = [];

foreach ($masomo_yanayohesabiwa as $key__sub => $value__sub) {
array_push($masomo_yanayohesabiwa2, $value__sub['subject_id']);
}


$award_method = $classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['award_method'];
$scale_ya_grading = unserialize($grading_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['grading_system'])['details']);

if ($award_method == 'DIVISION') {

$scale_ya_division = unserialize($division_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['division_system'])['details']);
$order_ya_division =  $division_systems->show($classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['division_system'])['points_sorting'];

$merged = $utility->groupStudentResultsWithRanking($matokeo, $students_in_class, $masomo_yanayohesabiwa2, $scale_ya_division, $scale_ya_grading, $sortBy = 'points', $order_ya_division);

}else{

$scale_ya_division = NULL;
$order_ya_division =  'Descending';

$merged = $utility->groupStudentResultsWithRanking($matokeo, $students_in_class, $masomo_yanayohesabiwa2, $scale_ya_division, $scale_ya_grading, $sortBy = 'average', $order_ya_division);

}





require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
public function Footer() {
$this->SetY(-15);
$this->SetFont('helvetica', 'B', 8);
$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C');
}
}


$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($info['name']);
$pdf->SetTitle('STUDENT REPORT CARD');
$pdf->SetSubject('STUDENT REPORT CARD');
$pdf->SetKeywords('STUDENT REPORT CARD');
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(TRUE, 15);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$logo = 'storage/images/misc/'.$info['logo'].'';
$std_photo = empty($profile['display_img']) ? 'storage/images/students/'.$profile['gender'].'.png' : 'storage/images/students/'.$profile['display_img'];

$phones = !empty($info['phone_2']) ? $info['phone_1'].', '.$info['phone_2'] : $info['phone_1'];
$emails = !empty($info['email_2']) ? $info['email_1'].', '.$info['email_2'] : $info['email_1'];

$sig_font = TCPDF_FONTS::addTTFfont('assets/fonts/Autography.ttf', 'TrueTypeUnicode', '', 96);

$html = '<style>
.header {
text-align: center;
line-height: 1.4;
}
.header img {
width: 60px;
}
.school-name {
font-size: 13pt;
font-weight: bold;
}
.school-info {
font-size: 10pt;
color: #333;
}
.report-title {
text-align: center;
font-weight: bold;
font-size: 10pt;
margin-bottom: 8px;
}
table {
border-collapse: collapse;
width: 100%;
font-size: 10pt;
}
th {
background-color: black;
color:white;
font-weight: bold;
padding: 5px;
}
td {
padding: 5px;
}

</style><div class="header" style="width:100%; text-align:center; line-height:1.2;">
<table width="100%" cellpadding="2">
<tr>
<td width="15%" align="left">
<img src="'.$logo.'" width="80" />
</td>
<td width="70%" align="center">
<div class="school-name">'.strtoupper($info['name']).'</div>
<div class="school-info" style="font-size:10pt;">
'.$info['address'].'<br>
Tel: '.$phones.' | Email: '.$emails.'
</div>
<div class="report-title" style="margin-top:5px;">STUDENT REPORT CARD</div>
</td>
<td width="15%" align="right">
<img src="'.$std_photo.'" width="80" />
</td>
</tr>
</table>
</div>';

$pdf->writeHTML($html, true, false, true, false, '');


$html = '<table width="100%"  style="font-size:10px;">
<tr>
<td width="75%">
<div class="student-info">
<b>Name:</b> '.$profile['first_name'].' '.$profile['last_name'].'<br>
<b>Student ID:</b> '.$profile['reg_no'].'<br>
<b>Class:</b> '.$classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['name'].'<br>
<b>Term:</b> '.$terms->show($_GET['term'])['name'].'
</div>
</td>
<td width="25%">

</td>

</tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$style = array(
'border' => false,
'padding' => 0,
'fgcolor' => array(0,0,0),
'bgcolor' => false
);

$y = $pdf->GetY() - 25;

$pdf->write2DBarcode($actual_link, 'QRCODE,H', 264, $y, 25, 25, $style, 'N');


foreach ($madarasa_aliyofanyia_mtihani as $key => $value) {

$scale_ya_grading = unserialize($grading_systems->show($classes->show($value['class_id'])['grading_system'])['details']);

$masomo_anayo_soma = $students->runQuery("SELECT d.id, d.code, d.name, d.is_principal, d.status FROM subject_combinations a JOIN classes b ON a.class_id = b.id
JOIN programmes c ON b.programme = c.id JOIN subjects d ON a.subject_id = d.id WHERE a.class_id = ?", array($value['class_id']));

$tem_alizofanyia_mtihani_kwenye_darasa = $students->runQuery("SELECT term
  FROM examination_results JOIN academic_terms ON examination_results.term = academic_terms.id
  WHERE reg_no = ? AND class_id = ? AND show_results = 'YES' AND term = ? GROUP BY term", array($profile['reg_no'], $value['class_id'], $_GET['term']));


foreach ($tem_alizofanyia_mtihani_kwenye_darasa as $key2 => $value2) {

$obtained_marks = 0;
$obtained_points = [];

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

if ($value3['is_principal'] == 'YES') {
$obtained_marks = $obtained_marks + $ca_score;
}

$sum_za_ca = $sum_za_ca + $ca_score;

}else{

$ca_score = '-';

}

}else{
$ca_score = '-';
}

$data_za_ca = $data_za_ca.'
<td align="center" width="5%">
'.$ca_score.'
</td>
';


$heda_za_ca = $heda_za_ca.'<th align="center" width="5%"><b>CA '.($key4 + 1).'</b></th>';

}

$sum_za_ca = $utility->score($sum_za_ca);
$grade_ya_somo = '-';
$remark_ya_somo = '-';


foreach($scale_ya_grading as $grade)
{

if (floor($sum_za_ca) >= $grade['min_score'] && floor($sum_za_ca) <= $grade['max_score']) {

$grade_ya_somo = $grade['grade'];
$remark_ya_somo = $grade['remark'];

if ($value3['is_principal'] == 'YES') {
array_push($obtained_points, $grade['points']);
}


}

}

$total_cas = (count($ca_za_tem)) * 5;
$zilizotumika = 30 + $total_cas;
$remain_columns = 100 - $zilizotumika;

$tebo = $tebo.'<tr>
<td width="10%"><b>
'.$value3['code'].'
</b></td>
<td width="'.$remain_columns.'%">
'.$value3['name'].'
</td>'.$data_za_ca.'
<td align="center" width="5%">
'.$sum_za_ca.'
</td>
<td align="center" width="5%">
'.$grade_ya_somo.'
</td>
<td align="center" width="10%">
'.$remark_ya_somo.'
</td>
</tr>';

}



$html = '<br><br><table width="100%" style="font-size:9px;" border="1">
<thead>
<tr>
<th width="10%"><b>SUBJECT CODE</b></th>
<th width="'.$remain_columns.'%"><b>SUBJECT NAME</b></th>'.$heda_za_ca.'
<th align="center" width="5%"><b>TOTAL</b></th>
<th align="center" width="5%"><b>GRADE</b></th>
<th align="center" width="10%"><b>REMARK</b></th>
</tr>
</thead>'.$tebo.'</table>';

}

}



$pdf->writeHTML($html, true, false, true, false, '');



$award_method = $classes->show($madarasa_aliyofanyia_mtihani[0]['class_id'])['award_method'];



if ($award_method == 'AVERAGE') {

$average = number_format($obtained_marks/count($masomo_anayo_soma),2);
$grade_ya_remark = '-';
$teachers_comment = '-';
$head_teachers_comment = '-';

foreach($scale_ya_grading as $grade)
{

if (floor($average) >= $grade['min_score'] && floor($average) <= $grade['max_score']) {

$grade_ya_remark = $grade['grade'];
$teachers_comment = $grade['teacher_comment'];
$head_teachers_comment = $grade['head_teacher_comment'];

}

}

$html = '<style>
.summary {
margin-top:15px;
font-size:9pt;
}

.comments {
margin-top:10px;
padding:20px;
font-size:9pt;
}</style><div class="summary">
<b>Total Marks:</b> '.$obtained_marks.'
<b>Average:</b> '.$average.'
<b>Final Grade:</b> '.$grade_ya_remark.'
<b>Position in class: </b>'.$merged[$profile['reg_no']]['position'].' / '.count($merged).'
</div>

<div class="comments">
<b>Class Teacher’s Comments: </b>'.$teachers_comment.'<br><br>
<b>Head Teacher’s Comments: </b>'.$head_teachers_comment.'
</div>';

}else{

$scale_ya_division = unserialize($division_systems->show($classes->show($value['class_id'])['division_system'])['details']);
$division = $utility->getDivisionResult($obtained_points, $scale_ya_division);

$teachers_comment = $division['teacher_comment'];
$head_teachers_comment = $division['head_teacher_comment'];

$html = '<style>
.summary {
margin-top:15px;
font-size:9pt;
}

.comments {
margin-top:10px;
padding:20px;
font-size:9pt;
}</style><div class="summary">
<b>Award: </b>'.$division['scale_name'].'
<b>Aggregated Points: </b>'.$division['points'].'
<b>Position in class: </b>'.$merged[$profile['reg_no']]['position'].' / '.count($merged).'
</div>

<div class="comments">
<b>Class Teacher’s Comments: </b>'.$teachers_comment.'<br><br>
<b>Head Teacher’s Comments: </b>'.$head_teachers_comment.'
</div>';
}
$pdf->writeHTML($html, true, false, true, false, '');


if ($signatures['1_enabled'] == 'YES') {

$sig_1 = '<th align="left" width="40%">
'.$signatures['signature_1'].'
<div style="font-family: helvetica; font-size: 10pt; color: #000000;">
<b>'.$signatures['name_1'].'</b> - '.$signatures['title_1'].'
</div>
</th>';
}else{
$sig_1 = '<th align="left" width="40%">

</th>';
}



if ($signatures['2_enabled'] == 'YES') {

$sig_2 = '<th align="right" width="40%">
'.$signatures['signature_2'].'
<div style="font-family: helvetica; font-size: 10pt; color: #000000;">
<b>'.$signatures['name_2'].'</b> - '.$signatures['title_2'].'
</div>
</th>';
}else{
$sig_2 = '<th align="right" width="40%">

</th>';
}


if ($info['stamp_enabled'] == 'YES') {
$stamp = '<img height="80" src="storage/images/misc/'.$info['stamp'].'">';
}else{
$stamp = '';
}

$html = '<style>    .footer {
position: absolute;
bottom: 25px;
width: 100%;
text-align:center;
font-size:9pt;
color:#555;
}</style><br><table>
<tr>
'.$sig_1.'
<th align="center" width="20%">
'.$stamp.'
</th>
'.$sig_2.'
</tr>
</table><div class="footer" style="font-family: helvetica; font-size: 10pt; color: #000000;">
Generated on '.date("F j, Y G:i:s A").'
</div>';

$pdf->SetTextColor(0, 0, 255);
$pdf->SetFont($sig_font, '', 25, '', true);
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('STUDENT_REPORT_CARD.pdf', 'I');

}

}else{
header("location:../");
}
?>
