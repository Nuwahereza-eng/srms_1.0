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

$csrf = $utility->csrf_generate('delete_teacher.php', 600);

$table = <<<EOT
(
SELECT id, CONCAT(first_name, ' ',last_name) as name, gender, email, account_status FROM staff WHERE role = 'TEACHER'
) temp
EOT;

$primaryKey = 'id';
$orderColumn = 'id';
$orderType = 'DESC';


$columns = array(
array( 'db' => 'name',   'dt' => 0 ),
array( 'db' => 'gender',   'dt' => 1 ),
array( 'db' => 'email',   'dt' => 2 ),
array(
'db'        => 'account_status',
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
$l = 'Delete Teacher?';
$y = 'Yes';
$n = 'No';

return "
<button onclick='get_teacher($d);' data-pc-animate='3d-rotate-InLeft' type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal-edit'><i class='fa fa-edit'></i></button>
<button onclick='drop(".htmlspecialchars_decode('&#039')."app/routes/delete_teacher?id=$d&csrf_token=$e&csrf_form_id=$f".htmlspecialchars_decode('&#039').",".htmlspecialchars_decode('&#039')."$l".htmlspecialchars_decode('&#039').",
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
