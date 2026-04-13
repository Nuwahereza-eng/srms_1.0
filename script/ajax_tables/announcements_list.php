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

$csrf = $utility->csrf_generate('delete_announcement.php', 600);

$table = <<<EOT
(
SELECT * FROM announcements
) temp
EOT;

$primaryKey = 'id';
$orderColumn = 'id';
$orderType = 'DESC';


$columns = array(
array( 'db' => 'title',   'dt' => 0 ),
array( 'db' => 'audience',   'dt' =>1 ),
array(
'db'        => 'date_published',
'dt'        => 2,
'formatter' => function( $d, $row ) {
return date("F d, Y G:i:s", strtotime($d));
}
),
array(
'db'        => 'id',
'dt'        => 3,
'formatter' => function( $d, $row ) {

$csrf = $GLOBALS['csrf'];
$e = $csrf['token'];
$f = $csrf['formId'];
$l = 'Delete Announcement?';
$y = 'Yes';
$n = 'No';

return "
<button onclick='get_announcement($d);' data-pc-animate='3d-rotate-InLeft' type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modal-edit'><i class='fa fa-edit'></i></button>
<button onclick='drop(".htmlspecialchars_decode('&#039')."app/routes/delete_announcement?id=$d&csrf_token=$e&csrf_form_id=$f".htmlspecialchars_decode('&#039').",".htmlspecialchars_decode('&#039')."$l".htmlspecialchars_decode('&#039').",
".htmlspecialchars_decode('&#039')."$y".htmlspecialchars_decode('&#039').", ".htmlspecialchars_decode('&#039')."$n".htmlspecialchars_decode('&#039').");' type='button' class='btn btn-danger btn-sm'><i class='fa far fa-trash-can'></i></button>
";
}
)
);


$sql_details = array(
'user' => getenv("DB_USERNAME"),
'pass' => getenv("DB_PASSWORD"),
'db'   => getenv("DB_NAME"),
'host' => getenv("DB_HOST")
,'charset' => 'utf8'
);

require('includes/ssp.class.php');

echo json_encode(
SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $orderColumn, $orderType)
);

}else{

}
?>
