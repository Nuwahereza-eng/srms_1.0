<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$mail = new smtp_settings_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 1 && $profile['role'] == 'ADMIN') {

$page = $utility->get_page();
$smtp = $mail->index();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Email Settings'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?> enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">

<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
Email Settings
</h3>
</div>
<div class="block-content block-content-full overflow-x-auto">
<form autocomplete="off" class="app_frm" action="app/routes/update_email" method="POST">
<div class="mb-2">
<label class="form-label">Server</label>
<input type="text" value="<?php echo $smtp['server']; ?>" required class="form-control" name="server" placeholder="Enter server address">
</div>
<div class="mb-2">
<label class="form-label">Username</label>
<input type="text" value="<?php echo $smtp['username']; ?>" required class="form-control" name="username" placeholder="Enter server username">
</div>
<div class="mb-2">
<label class="form-label">Password</label>
<input type="text" value="<?php echo $smtp['password']; ?>" required class="form-control" name="password" placeholder="Enter server password">
</div>
<div class="mb-2">
<label class="form-label">Port</label>
<input type="text" value="<?php echo $smtp['port']; ?>" required class="form-control" name="port" placeholder="Enter server port"  onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
</div>
<div class="mb-3">
<label class="form-label">Encryption</label>
<select required class="form-control" name="encryption">
<option <?php echo $smtp['encryption'] == 'tls' ? ' selected ' : ''; ?> value="tls">TLS</option>
<option <?php echo $smtp['encryption'] == 'ssl' ? ' selected ' : ''; ?> value="ssl">SSL</option>
</select>
</div>
<?= $utility->csrf_field('update_email.php', 600) ?>
<div class="mb-2">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>
</div>

</div>
</main>
<?php require_once 'includes/footer.php'; ?>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/core.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/plugins/datatables/dataTables.min.js"></script>
<script src="assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
</body>
</html>
<?php
}else{
header("location:../staff/login");
}
require_once('includes/check_reply.php');
?>
