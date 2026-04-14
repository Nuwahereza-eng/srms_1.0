<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$students = new students_controller;
$staff = new staff_controller;
$session = new session;

$env = $school->index();
require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$csrf = $utility->csrf_generate('delete_student.php', 600);

$table = <<<EOT
(
SELECT a.reg_no, display_img, CONCAT(a.first_name, ' ',a.last_name) as name, a.gender, a.email, b.name as class, a.account_status
FROM students a JOIN classes b ON a.class = b.id ORDER BY name ASC
) temp
EOT;

$primaryKey = 'reg_no';
$orderColumn = 'name';
$orderType = 'ASC';


$columns = array(

array(
'db'        => 'display_img',
'dt'        => 0,
'formatter' => function( $d, $row ) {
if (empty($d)) {
return '<img style="width:50px; height:50px; object-fit:cover !important;" src="storage/images/students/'.$row[3].'.png">';
}else{
return '<img style="width:50px; height:50px; object-fit:cover !important;" src="storage/images/students/'.$d.'">';
}
}
),
array( 'db' => 'reg_no',   'dt' => 1 ),
array( 'db' => 'name',   'dt' => 2 ),
array( 'db' => 'gender',   'dt' => 3 ),
array( 'db' => 'email',   'dt' => 4 ),
array( 'db' => 'class',   'dt' => 5 ),
array(
'db'        => 'account_status',
'dt'        => 6,
'formatter' => function( $d, $row ) {
switch ($d) {
case 'ENABLED':
return '<span class="badge bg-success">ENABLED</span>';
break;

default:
return '<span class="badge bg-danger">DISABLED</span>';
break;
}
}
),
array(
'db'        => 'reg_no',
'dt'        => 7,
'formatter' => function( $d, $row ) {

$csrf = $GLOBALS['csrf'];
$e = $csrf['token'];
$f = $csrf['formId'];
$l = 'Delete Student?';
$y = 'Yes';
$n = 'No';

return "
<a href='app/view_student?reg=$d' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>
<a href='app/edit_student?reg=$d' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
<button onclick='drop(".htmlspecialchars_decode('&#039')."app/routes/delete_student?id=$d&csrf_token=$e&csrf_form_id=$f".htmlspecialchars_decode('&#039').",".htmlspecialchars_decode('&#039')."$l".htmlspecialchars_decode('&#039').",
".htmlspecialchars_decode('&#039')."$y".htmlspecialchars_decode('&#039').", ".htmlspecialchars_decode('&#039')."$n".htmlspecialchars_decode('&#039').");' type='button' class='btn btn-danger btn-sm'><i class='fa far fa-trash-can'></i></button>
";
}
)
);


$sql_details = array(
'user' => ($_ENV["DB_USERNAME"] ?? getenv("DB_USERNAME")),
'pass' => ($_ENV["DB_PASSWORD"] ?? getenv("DB_PASSWORD")),
'db'   => ($_ENV["DB_NAME"] ?? getenv("DB_NAME")),
'host' => ($_ENV["DB_HOST"] ?? getenv("DB_HOST"))
,'charset' => 'utf8'
);

require('includes/ssp.class.php');

echo json_encode(
SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $orderColumn, $orderType)
);

}else{

}
?>
