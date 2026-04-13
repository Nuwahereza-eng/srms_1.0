<?php
if ($session->is_logged() === true) {

if (!empty($_SESSION['logged_account']['reg_no'])) {
$profile = $students->show($_SESSION['logged_account']['reg_no']);
$is_staff = 0;
}else{
$profile = $staff->show($_SESSION['logged_account']['id']);
$is_staff = 1;
}


if (!empty($profile)) {

if ($profile['account_status'] == "ENABLED") {
$is_authenticated = 1;
}else{
$is_authenticated = 0;
}
}else{
$is_authenticated = 0;
}

}else{
$is_authenticated = 0;
}
?>
