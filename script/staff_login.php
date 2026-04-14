<?php
require_once 'autoload.php';
$school = new school_controller;
$info = $school->index();
?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Staff Login'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<style>
    .login-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #1a3a5c 0%, #0f2441 50%, #0a1628 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .login-bg::before {
        content: '';
        position: absolute;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(60,144,223,0.12) 0%, transparent 70%);
        top: -200px; left: -100px;
        border-radius: 50%;
    }
    .login-bg::after {
        content: '';
        position: absolute;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(6,101,208,0.1) 0%, transparent 70%);
        bottom: -150px; right: -100px;
        border-radius: 50%;
    }
    .login-card {
        background: rgba(255,255,255,0.97);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3), 0 1px 3px rgba(0,0,0,0.1);
        max-width: 420px;
        width: 100%;
        z-index: 2;
        overflow: hidden;
    }
    .login-card-header {
        background: linear-gradient(135deg, #1a3a5c 0%, #0665d0 100%);
        padding: 28px 32px 22px;
        text-align: center;
    }
    .login-card-header img {
        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.25));
    }
    .login-card-header h4 {
        color: #fff;
        font-size: 0.92rem;
        font-weight: 600;
        margin: 12px 0 4px;
        letter-spacing: 0.3px;
    }
    .login-card-header p {
        color: rgba(255,255,255,0.7);
        font-size: 0.78rem;
        margin: 0;
    }
    .login-card-body {
        padding: 28px 32px 24px;
    }
    .login-card { background: #fff !important; color: #343a40 !important; }
    .login-card-body .form-label { font-size: 0.8rem; font-weight: 600; color: #4a5568 !important; margin-bottom: 4px; }
    .login-card-body .form-control {
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 9px 14px;
        border: 1px solid #e2e8f0 !important;
        background-color: #fff !important;
        color: #343a40 !important;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .login-card-body .form-control::placeholder { color: #a0aec0 !important; }
    .login-card-body .form-control:focus {
        border-color: #0665d0 !important;
        box-shadow: 0 0 0 3px rgba(6,101,208,0.12);
        background-color: #fff !important;
        color: #343a40 !important;
    }
    .login-card-body .input-group-text {
        border-radius: 0 8px 8px 0;
        background: #f7fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-left: 0;
        color: #a0aec0;
    }
    .login-card-body .btn-primary {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 10px;
        background: linear-gradient(135deg, #1a3a5c, #0665d0);
        border: none;
        box-shadow: 0 4px 14px rgba(6,101,208,0.3);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .login-card-body .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(6,101,208,0.4);
    }
    .login-footer {
        text-align: center;
        z-index: 2;
        margin-top: 20px;
        font-size: 0.72rem;
        color: rgba(255,255,255,0.45);
    }
    .login-footer a { color: rgba(255,255,255,0.65); text-decoration: none; }
    .login-footer a:hover { color: #fff; }
    .login-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(26,58,92,0.08);
        color: #1a3a5c;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 18px;
    }
</style>
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" style="display:none"><nav id="sidebar"></nav><header id="page-header"></header><main id="main-container"></main></div>

<div class="login-bg">
    <div class="login-card">
        <div class="login-card-header">
            <img src="storage/images/misc/<?php echo $info['logo']; ?>" height="100" alt="School Logo">
            <h4><?php echo $info['name']; ?></h4>
            <p>Students Results Management System</p>
        </div>
        <div class="login-card-body">
            <div class="text-center">
                <span class="login-role-badge"><i class="fa fa-user-shield"></i> Staff Portal</span>
            </div>
            <form autocomplete="off" class="app_frm" action="routes/staff_auth" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <input required type="email" class="form-control" name="email" placeholder="e.g. name@school.com">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input required type="password" class="form-control" name="password" placeholder="Enter your password">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 0.8rem;">
                    <a href="staff/reset_pw" class="text-primary fw-semibold">Forgot Password?</a>
                    <a href="./" class="text-muted fw-semibold"><i class="fa fa-arrow-left fa-xs me-1"></i> Student Login</a>
                </div>

                <div class="mb-1">
                    <button type="submit" name="submit" value="1" class="btn w-100 btn-primary app_btn">
                        <i class="fa fa-right-to-bracket me-1"></i> Sign In
                    </button>
                </div>
                <?= $utility->csrf_field('staff_auth.php', 600) ?>
            </form>
        </div>
    </div>
    <div class="login-footer">
        <span>&copy; <?php echo date('Y'); ?> <?php echo $info['name']; ?></span> &middot;
        <span>Developed by <a>Abdul & Moses</a></span>
    </div>
</div>

<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/core.js"></script>
<script src="assets/js/form.js"></script>
<script src="assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<?php require_once('includes/check_reply.php'); ?>
</body>
</html>
