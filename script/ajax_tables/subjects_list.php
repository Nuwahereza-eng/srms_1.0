<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$students = new students_controller;
$staff = new staff_controller;
$session = new session;

$env = $school->index();
require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1) {

$csrf = $utility->csrf_generate('delete_subject.php', 600);

if (!empty($profile['role']) && $profile['role'] == 'ADMIN') {
$table = <<<EOT
(
SELECT * FROM subjects
) temp
EOT;
}elseif(!empty($profile['role']) && $profile['role'] == 'TEACHER'){
$my_id = $profile['id'];
$table = <<<EOT
(
SELECT a.id, d.code, d.name, d.is_principal, d.status FROM subject_combinations a JOIN classes b ON a.class_id = b.id
JOIN programmes c ON b.programme = c.id JOIN subjects d ON a.subject_id = d.id WHERE a.teacher = $my_id
) temp
EOT;
}else{
$my_id = $profile['class'];
$table = <<<EOT
(
SELECT a.id, d.code, d.name, d.is_principal, d.status FROM subject_combinations a JOIN classes b ON a.class_id = b.id
JOIN programmes c ON b.programme = c.id JOIN subjects d ON a.subject_id = d.id WHERE a.class_id = $my_id
) temp
EOT;
}


$primaryKey = 'id';
$orderColumn = 'code';
$orderType = 'ASC';


if (!empty($profile['role']) && $profile['role'] == 'ADMIN') {
$columns = array(
array( 'db' => 'code',   'dt' => 0 ),
array( 'db' => 'name',   'dt' => 1 ),
array(
'db'        => 'is_principal',
'dt'        => 2,
'formatter' => function( $d, $row ) {
switch ($d) {
case 'YES':
return '<span class="badge bg-success">YES</span>';
break;

default:
return '<span class="badge bg-primary">NO</span>';
break;
}
}
),

array(
'db'        => 'status',
'dt'        => 3,
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
'db'        => 'id',
'dt'        => 4,
'formatter' => function( $d, $row ) {

$csrf = $GLOBALS['csrf'];
$e = $csrf['token'];
$f = $csrf['formId'];
$l = 'Delete Subject?';
$y = 'Yes';
$n = 'No';

return "
<button onclick='get_subject($d);' data-pc-animate='3d-rotate-InLeft' type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal-edit'><i class='fa fa-edit'></i></button>
<button onclick='drop(".htmlspecialchars_decode('&#039')."app/routes/delete_subject?id=$d&csrf_token=$e&csrf_form_id=$f".htmlspecialchars_decode('&#039').",".htmlspecialchars_decode('&#039')."$l".htmlspecialchars_decode('&#039').",
".htmlspecialchars_decode('&#039')."$y".htmlspecialchars_decode('&#039').", ".htmlspecialchars_decode('&#039')."$n".htmlspecialchars_decode('&#039').");' type='button' class='btn btn-danger btn-sm'><i class='fa far fa-trash-can'></i></button>
";
}
)
);
}else{
$columns = array(
array( 'db' => 'code',   'dt' => 0 ),
array( 'db' => 'name',   'dt' => 1 ),
array(
'db'        => 'is_principal',
'dt'        => 2,
'formatter' => function( $d, $row ) {
switch ($d) {
case 'YES':
return '<span class="badge bg-success">YES</span>';
break;

default:
return '<span class="badge bg-primary">NO</span>';
break;
}
}
),

array(
'db'        => 'status',
'dt'        => 3,
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
)
);
}


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
