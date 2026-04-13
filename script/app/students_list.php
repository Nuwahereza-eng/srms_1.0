<?php
chdir('../');
error_reporting(0);
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();
date_default_timezone_set($info['timezone']);

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN' && !empty($_SESSION['export_data'])) {

require_once('tcpdf/tcpdf.php');

function numberToZeros($number) {
return strlen((string)$number);
}

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
$pdf->SetTitle('REGISTRED STUDENTS LIST');
$pdf->SetSubject('REGISTRED STUDENTS LIST');
$pdf->SetKeywords('REGISTRED STUDENTS LIST');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

$pdf->AddPage();

$logo = 'storage/images/misc/'.$info['logo'].'';

$phones = !empty($info['phone_2']) ? $info['phone_1'].', '.$info['phone_2'] : $info['phone_1'];
$emails = !empty($info['email_2']) ? $info['email_1'].', '.$info['email_2'] : $info['email_1'];

$list = implode(",", unserialize($_SESSION['export_data']));

$query = "SELECT a.reg_no, CONCAT(a.first_name, ' ',a.last_name) as name, a.gender, a.email, b.name as class FROM
students a JOIN classes b ON a.class = b.id WHERE a.class IN($list) ORDER BY name ASC";
$param = array();
$results = $students->runQuery($query, $param);
$total = count($results);

$std_data = '';

if($total < 1) {

}else{

foreach ($results as $key => $value) {
$n = sprintf('%0'.numberToZeros($total).'d', $key+1);
$bg = ($key % 2 == 1) ? 'background-color:lightgrey;' : '';
$std_data = $std_data.'
<tr style="'.$bg.'">
<td width="8%" align="center">'.$n.'</td>
<td width="15%">'.$value['reg_no'].'</td>
<td width="21%">'.$value['name'].'</td>
<td width="7%">'.$value['gender'].'</td>
<td width="24%">'.$value['email'].'</td>
<td width="25%">'.$value['class'].'</td>
</tr>
';
}

}
$html = '
<style>
.header {
text-align: center;
line-height: 1.4;
}
.header img {
width: 60px;
}
.school-name {
font-size: 16pt;
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
border: 1px solid #000;
padding: 5px;
}
td {
border: 1px solid #000;
padding: 5px;
}

</style>

<div class="header">
<img src="' . $logo . '" alt="School Logo">
<h5>'.strtoupper($info['name']).'</h5>
<p class="school-info" style="margin-top:-10px;">'.$info['address'].'<br>
Tel: '.$phones.'  | Email: '.$emails.'
</p>
<div class="report-title">REGISTRED STUDENTS LIST</div>
</div>

<table cellpadding="2">
<thead>
<tr>
<th width="8%"  align="center">#</th>
<th width="15%">Registration Number</th>
<th width="21%">Full Name</th>
<th width="7%">Gender</th>
<th width="24%">Email</th>
<th width="25%">Class</th>
</tr>
</thead>
<tbody>
'.$std_data.'
</tbody>
</table>

<br><br>
<div style="text-align:right; font-size:9pt;">
<em>Generated on: ' . date("F j, Y G:i:s") . '</em>
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('REGISTRED_STUDENTS_LIST.pdf', 'I');

}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
