<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$students = new students_controller;
$staff = new staff_controller;
$session = new session;

$env = $school->index();
require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1) {

$csrf = $utility->csrf_generate('delete_class.php', 600);

if ($profile['role'] == 'ADMIN') {
$table = <<<EOT
(
SELECT a.id, a.name, b.name as programme, c.name as grading_system, d.name as division_system, a.award_method, a.status FROM classes a
JOIN programmes b ON a.programme = b.id JOIN grading_systems c ON a.grading_system = c.id
LEFT JOIN division_systems d ON a.division_system = d.id
) temp
EOT;
}else{
$my_id = $profile['id'];
$table = <<<EOT
(
SELECT b.id, b.name, c.name as programme, e.name as grading_system, f.name as division_system, d.name as subject, b.award_method, b.status
FROM subject_combinations a
JOIN classes b ON a.class_id = b.id
JOIN grading_systems e ON b.grading_system = e.id
LEFT JOIN division_systems f ON b.division_system = f.id
JOIN programmes c ON b.programme = c.id JOIN subjects d ON a.subject_id = d.id WHERE a.teacher = $my_id
) temp
EOT;
}


$primaryKey = 'id';
$orderColumn = 'id';
$orderType = 'ASC';


if ($profile['role'] == 'ADMIN') {
$columns = array(
array( 'db' => 'name',   'dt' => 0 ),
array( 'db' => 'programme',   'dt' => 1 ),
array( 'db' => 'grading_system',   'dt' => 2 ),
array( 'db' => 'division_system',   'dt' => 3 ),
array( 'db' => 'award_method',   'dt' => 4 ),
array(
'db'        => 'status',
'dt'        => 5,
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
'dt'        => 6,
'formatter' => function( $d, $row ) use ($csrf) {

$e = $csrf['token'];
$f = $csrf['formId'];
$l = 'Delete Class?';
$y = 'Yes';
$n = 'No';

return "
<button onclick='get_class($d);' data-pc-animate='3d-rotate-InLeft' type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal-edit'><i class='fa fa-edit'></i></button>
<button onclick='drop(".htmlspecialchars_decode('&#039')."app/routes/delete_class?id=$d&csrf_token=$e&csrf_form_id=$f".htmlspecialchars_decode('&#039').",".htmlspecialchars_decode('&#039')."$l".htmlspecialchars_decode('&#039').",
".htmlspecialchars_decode('&#039')."$y".htmlspecialchars_decode('&#039').", ".htmlspecialchars_decode('&#039')."$n".htmlspecialchars_decode('&#039').");' type='button' class='btn btn-danger btn-sm'><i class='fa far fa-trash-can'></i></button>
";
}
)
);
}else{
$columns = array(
array( 'db' => 'name',   'dt' => 0 ),
array( 'db' => 'programme',   'dt' => 1 ),
array( 'db' => 'grading_system',   'dt' => 2 ),
array( 'db' => 'division_system',   'dt' => 3 ),
array( 'db' => 'award_method',   'dt' => 4 ),
array(
'db'        => 'status',
'dt'        => 5,
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
echo json_encode(['draw'=>intval($_GET['draw']??0),'recordsTotal'=>0,'recordsFiltered'=>0,'data'=>[]]);
}
?>
