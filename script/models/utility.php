<?php
class utility {

public function __construct() {
$env = file_get_contents(".env");
$lines = explode("\n",$env);

foreach($lines as $line){
preg_match("/([^#]+)\=(.*)/",$line,$matches);
if(isset($matches[2])){ putenv(trim($line)); }
}
}

public function sanitize($input) {
$input = trim($input);
$input = stripslashes($input);
$input = htmlspecialchars($input);
$input = strip_tags($input);

return $input;
}

public function sanitize_request($request) {
$temp_Arr = array();
foreach ($request as $key => $value) {

if (is_array($value)) {

$temp_Arr[$key] = serialize($value);

}else{
if ($key !== 'csrf_token' AND $key !== 'id' AND $key !== 'csrf_form_id' AND $key !== 'submit'){
if ($key == 'fname' OR $key == 'lname' OR $key == 'name' OR $key == 'first_name' OR $key == 'last_name' OR $key == 'title') {
$temp_Arr[$key] = $this->sanitize(ucwords($value));
}elseif($key == 'code') {
$temp_Arr[$key] = $this->sanitize(strtoupper($value));
}else{
$key == 'hashed_pw' ? $temp_Arr[$key] = password_hash($value,PASSWORD_BCRYPT) : $temp_Arr[$key] = $this->sanitize($value);
}
}
}

}
return $temp_Arr;
}

public function setMessage($tpye, $message) {

$_SESSION['alert'] = array (array($tpye,$message));

}

public function uploader($path, $file, $file_name, $extensions) {

$target_dir = $path;
$ext = explode(",", $extensions);
$target_file_0 = $target_dir . basename($file["file"]["name"]);
$FileType = strtolower(pathinfo($target_file_0,PATHINFO_EXTENSION));
$target_file = $target_dir . $file_name.'.'.$FileType;

$file_status = 1;

if ($file["file"]["size"] > ((int)(ini_get('upload_max_filesize'))*1000000)) {
return "Sorry, your file is too large.";
}elseif (!in_array($FileType, $ext)) {
return "Sorry, only $extensions files are allowed";
}elseif (move_uploaded_file($file["file"]["tmp_name"], $target_file)) {
return "OK";
}else {
return "Sorry, there was an error uploading your file.";
}

}


public function extension($file) {

$target_file_0 = basename($file["file"]["name"]);
return strtolower(pathinfo($target_file_0,PATHINFO_EXTENSION));

}

public function strip_tags_content($string) {
$string = preg_replace ('/<[^>]*>/', ' ', $string);

$string = str_replace("\r", '', $string);
$string = str_replace("\n", ' ', $string);
$string = str_replace("\t", ' ', $string);

$string = trim(preg_replace('/ {2,}/', ' ', $string));
return $string;

}

public function delete_file($file) {
unlink($file);
}

public function get_red_link() {
return $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

public function check_menu($x, $y) {
$y = explode(",",$y);
if (in_array($x, $y))
{
return 'active open';
}
else
{
return '';
}
}

public function genRandString($length) {
$stringSpace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$pieces = [];
$max = mb_strlen($stringSpace, '8bit') - 1;
for ($i = 0; $i < $length; ++ $i) {
$pieces[] = $stringSpace[random_int(0, $max)];
}
return implode('', $pieces);
}

public function get_page() {
$x = explode("/",$_SERVER['REQUEST_URI']);
$y = count($x);
$z = ($y-1);
return $x[$z];
}

function csrf_generate($action = null, $expiry = 600) {
if (!isset($_SESSION['csrf_tokens']) || !is_array($_SESSION['csrf_tokens'])) {
$_SESSION['csrf_tokens'] = [];
}

foreach ($_SESSION['csrf_tokens'] as $id => $data) {
if (is_array($data) && isset($data['expires']) && $data['expires'] < time()) {
unset($_SESSION['csrf_tokens'][$id]);
}
}

$formId = bin2hex(random_bytes(8));
$token  = bin2hex(random_bytes(32));
$expiresAt = time() + $expiry;

$_SESSION['csrf_tokens'][$formId] = [
'token' => $token,
'expires' => $expiresAt,
'action' => $action
];

return ['token' => $token, 'formId' => $formId];
}


function csrf_validate($formId, $token, $action = null, $oneTimeUse = true) {
if (!isset($_SESSION['csrf_tokens'][$formId])) return false;

$stored = $_SESSION['csrf_tokens'][$formId];

if ($stored['expires'] < time()) {
unset($_SESSION['csrf_tokens'][$formId]);
return false;
}

if (!hash_equals($stored['token'], $token)) return false;

if ($action && (!isset($stored['action']) || $stored['action'] !== $action)) {
return false;
}

if ($oneTimeUse) unset($_SESSION['csrf_tokens'][$formId]);

return true;
}


function csrf_field($action, $expiry) {
$csrf = $this->csrf_generate($action, $expiry);
return '<input type="hidden" name="csrf_token" value="' . $csrf['token'] . '">' .
'<input type="hidden" name="csrf_form_id" value="' . $csrf['formId'] . '">';
}


public function action_name(): string {
if (php_sapi_name() === 'cli') {
return basename($_SERVER['argv'][0] ?? '');
}

$candidates = [
'SCRIPT_NAME',
'PHP_SELF',
'SCRIPT_FILENAME',
'REQUEST_URI'
];

foreach ($candidates as $key) {
if (empty($_SERVER[$key])) continue;
$path = $_SERVER[$key];

if ($key === 'REQUEST_URI') {
$path = parse_url($path, PHP_URL_PATH) ?: $path;
}

$name = basename($path);
if ($name !== '' && $name !== '/' && strpos($name, '.') !== false) {
return $name;
}
}

return '';
}

public function generate_reg_no($lastRegNo, $gender, $prefix) {
$currentYear = date('y');
$genderCode = $gender == 'Female' ? '1' : '2';
if (empty($lastRegNo)) {
$last_entry = $prefix.'/'.$currentYear.'/'.$genderCode.'/000001';
}else{
$last_entry = $prefix.'/'.$currentYear.'/'.$genderCode.'/'.sprintf("%06d", explode("/", $lastRegNo)[3]+1);
}
return $last_entry;
}

public function score($x) {
if ($x === null || $x === '' || $x === '-' || trim($x) === '') {
return '-';
}

if (is_numeric($x)) {
$x = (float)$x;

if ($x >= 100) {
return (int)$x;
}

if (fmod($x, 1) == 0) {
return number_format($x, 1);
}

return number_format($x, 1);
}

return $x;
}


public function generateSerialSecure() {
$prefix = 'SN';
$timestampPart = str_pad(substr(time(), -10), 10, '0', STR_PAD_LEFT);
return $prefix . $timestampPart . bin2hex(random_bytes(8));
}

public function points_from_score($score, $grading_system) {

$obtained_points = array();

foreach($grading_system as $grade)
{

foreach ($score as $key => $value) {

if (floor($value) >= $grade['min_score'] && floor($value) <= $grade['max_score']) {

array_push($obtained_points, $grade['points']);

}
}


}

return $obtained_points;
}

public function groupStudentResultsWithRanking($resultsArray, $studentsArray, $masomo_yanayohesabiwa, $scale_ya_division, $scale_ya_grading, $sortBy, $point_order) {
$grouped = [];

foreach ($studentsArray as $studentID) {
$studentResults = [];

foreach ($resultsArray as $key => $value) {
preg_match('/_RESULT(\d+)/', $key, $matches);
$subject_id = isset($matches[1]) ? intval($matches[1]) : null;

if (in_array($subject_id, $masomo_yanayohesabiwa)) {

if (strpos($key, $studentID . '_RESULT') === 0) {
$studentResults[] = floatval($value);
}
}
}

if (!empty($studentResults)) {

if (!empty($scale_ya_division)) {

$pointsArray = $this->points_from_score($studentResults, $scale_ya_grading);
$division_results = $this->getDivisionResult($pointsArray, $scale_ya_division);

$grouped[$studentID] = [
'results' => $studentResults,
'award' => $division_results['scale_name'],
'points' => $division_results['points'],
'total' => round($total, 2),
'average' => round($average, 2)
];

}else{

$total = array_sum($studentResults);
$average = number_format($total / count($studentResults),2);

$grouped[$studentID] = [
'results' => $studentResults,
'total' => round($total, 2),
'average' => $average
];

}

}
}

uasort($grouped, function ($a, $b) use ($sortBy) {

switch ($point_order) {
case 'Ascending':
return ($b[$sortBy]>$a[$sortBy])?-1:1;
break;

default:
return ($b[$sortBy]<$a[$sortBy])?-1:1;
break;
}

//return $b[$sortBy] <=> $a[$sortBy];
});

$ranked = [];
$position = 0;
$previousValue = null;
$actualRank = 0;

foreach ($grouped as $studentID => $data) {
$actualRank++;

if ($previousValue !== null && $data[$sortBy] == $previousValue) {
$rank = $position;
} else {
$rank = $actualRank;
$position = $rank;
}

$ranked[$studentID] = $data + ['position' => $rank];
$previousValue = $data[$sortBy];
}

return $ranked;
}




function getDivisionResult($pointsArray, $gradingScale) {
$totalPoints = array_sum($pointsArray);

$result = [
'scale_name' => 'Unknown',
'points' => $totalPoints,
'remark' => 'N/A',
'teacher_comment' => 'N/A',
'head_teacher_comment' => 'N/A'
];

foreach ($gradingScale as $scale) {
if ($totalPoints >= $scale['min_point'] && $totalPoints <= $scale['max_point']) {
$result = [
'scale_name' => strtoupper($scale['scale_name']),
'points' => $totalPoints,
'remark' => $scale['remark'],
'teacher_comment' => $scale['teacher_comment'],
'head_teacher_comment' => $scale['head_teacher_comment']
];
break;
}
}

return $result;
}


function getDivisionResultReport($totalPoints, $gradingScale) {

$result = [
'scale_name' => 'Unknown',
];

foreach ($gradingScale as $scale) {
if (floor($totalPoints) >= $scale['min_point'] && floor($totalPoints) <= $scale['max_point']) {
$result = [
'scale_name' => strtoupper($scale['scale_name']),
];
break;
}
}

return $result['scale_name'];
}





public function groupStudentResultsWithRankingReport($resultsArray, $studentsArray, $masomo_yanayohesabiwa, $masomo_yote, $scale_ya_division = null, $sortBy = 'points', $point_order) {
$grouped = [];

foreach ($studentsArray as $studentID) {
$studentResults = [];
$my_points = 0;


foreach ($resultsArray as $key => $value) {
preg_match('/_RESULT(\d+)/', $key, $matches);
$subject_id = isset($matches[1]) ? intval($matches[1]) : null;

foreach ($masomo_yote as $key12 => $value12) {
$subname = $value12['name'];
}

if (strpos($key, $studentID . '_NAME') === 0) {
$studentname = $value;
}

if (strpos($key, $studentID . '_POINTS') === 0) {
$my_points = $my_points + $value;
}


if (in_array($subject_id, $masomo_yanayohesabiwa)) {

if (strpos($key, $studentID . '_RESULT') === 0) {

$studentResults2[$subject_id] = floatval($value);
$studentResults[$subject_id] = $this->score($value);
}

}else{

if (strpos($key, $studentID . '_RESULT') === 0) {

$studentResults[$subject_id] = $this->score($value);
}

}
}

if (!empty($studentResults2)) {
$total = array_sum($studentResults2);
$average = number_format($total / count($studentResults2),2);


if (!empty($scale_ya_division)) {

$division = $this->getDivisionResultReport($my_points, $scale_ya_division);

$grouped[$studentID] = [
'name' => $studentname,
'award' => $division,
'points' =>$my_points,
'results' => $studentResults,
'total' => number_format($total, 2),
'average' => number_format($average, 2)
];

}else{

$grouped[$studentID] = [
'name' => $studentname,
'points' =>$my_points,
'results' => $studentResults,
'total' => number_format($total, 2),
'average' => number_format($average, 2)
];
}

}
}

uasort($grouped, function ($a, $b) use ($sortBy) {

switch ($point_order) {
case 'Ascending':
return ($b[$sortBy]>$a[$sortBy])?-1:1;
break;

default:
return ($b[$sortBy]<$a[$sortBy])?-1:1;
break;
}


//return $b[$sortBy] <=> $a[$sortBy];
});

$ranked = [];
$position = 0;
$previousValue = null;
$actualRank = 0;

foreach ($grouped as $studentID => $data) {
$actualRank++;

if ($previousValue !== null && $data[$sortBy] == $previousValue) {
$rank = $position;
} else {
$rank = $actualRank;
$position = $rank;
}

$ranked[$studentID] = $data + ['position' => $rank];
$previousValue = $data[$sortBy];
}

return $ranked;
}

}
?>
