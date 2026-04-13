<?php
chdir('../');
require_once 'autoload.php';
$staff = new staff_controller;
$students = new students_controller;
$session = new session;

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1) {

session_destroy();

!empty($profile['role']) ? header("location:../staff/login") : header("location:../");

}else{
header("location:../staff/login");
}
?>
