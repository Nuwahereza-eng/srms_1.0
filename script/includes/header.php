<nav id="sidebar" aria-label="Main Navigation">
<div class="bg-header-dark">
<div class="content-header bg-white-5">
<a class="fw-semibold text-white tracking-wide" href="./app/dashboard">
<span class="smini-hidden">
Students Results Management System
</span>
</a>
<div class="d-flex align-items-center gap-1">
<button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
<i class="fa fa-times-circle"></i>
</button>
</div>
</div>
</div>
<div class="js-sidebar-scroll">
<div class="content-side">
<div class="text-center">
<img class="mb-4 center_img" src="storage/images/misc/<?php echo $info['logo']; ?>" height="140" alt="School Logo"></div>

<ul class="nav-main">

<?php
if (!empty($profile['role'])) {
?>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'dashboard'); ?>" href="app/dashboard">
<i class="nav-main-link-icon fa fa-dashboard"></i>
<span class="nav-main-link-name">Dashboard</span>
</a>
</li>
<?php

if ($profile['role'] == 'TEACHER') {
?>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'subjects'); ?>" href="app/subjects">
<i class="nav-main-link-icon fa fa-book"></i>
<span class="nav-main-link-name">Subjects</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'classes'); ?>" href="app/classes">
<i class="nav-main-link-icon fa fa-building"></i>
<span class="nav-main-link-name">Classes</span>
</a>
</li>
<li class="nav-main-item <?php echo $utility->check_menu($page, 'import_results,manage_results,perfomance_report'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'import_results,manage_results,perfomance_report'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon far fa-file-lines"></i>
<span class="nav-main-link-name">Examination Results</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'import_results'); ?>" href="app/import_results">
<span class="nav-main-link-name">Import Results</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'manage_results'); ?>" href="app/manage_results">
<span class="nav-main-link-name">Manage Results</span>
</a>
</li>
</ul>
</li>
<?php
}
}else{
?>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'home'); ?>" href="app/home">
<i class="nav-main-link-icon fa fa-house"></i>
<span class="nav-main-link-name">Home</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'subjects'); ?>" href="app/subjects">
<i class="nav-main-link-icon fa fa-book"></i>
<span class="nav-main-link-name">Subjects</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'results'); ?>" href="app/results">
<i class="nav-main-link-icon far fa-file-lines"></i>
<span class="nav-main-link-name">Examination Results</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'award'); ?>" href="app/award">
<i class="nav-main-link-icon fa fa-certificate"></i>
<span class="nav-main-link-name">Award Systems</span>
</a>
</li>
<?php
}


if (!empty($profile['role']) && $profile['role'] == 'ADMIN') {
?>

<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'subjects'); ?>" href="app/subjects">
<i class="nav-main-link-icon fa fa-book"></i>
<span class="nav-main-link-name">Subjects</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'cont_assessments'); ?>" href="app/cont_assessments">
<i class="nav-main-link-icon fa fa-bars-progress"></i>
<span class="nav-main-link-name">Cont. Assessments</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'programmes'); ?>" href="app/programmes">
<i class="nav-main-link-icon fa fa-book-open-reader"></i>
<span class="nav-main-link-name">Academic Programmes</span>
</a>
</li>
<li class="nav-main-item <?php echo $utility->check_menu($page, 'grading_systems,division_systems'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'grading_systems,division_systems'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-certificate"></i>
<span class="nav-main-link-name">Award Methods</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'grading_systems'); ?>" href="app/grading_systems">
<span class="nav-main-link-name">Grading Systems</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'division_systems'); ?>" href="app/division_systems">
<span class="nav-main-link-name">Division Systems</span>
</a>
</li>
</ul>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'terms'); ?>" href="app/terms">
<i class="nav-main-link-icon far fa-calendar-days"></i>
<span class="nav-main-link-name">Academic Terms</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'teachers'); ?>" href="app/teachers">
<i class="nav-main-link-icon fa fa-chalkboard-user"></i>
<span class="nav-main-link-name">Teachers</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'classes'); ?>" href="app/classes">
<i class="nav-main-link-icon fa fa-building"></i>
<span class="nav-main-link-name">Classes</span>
</a>
</li>
<li class="nav-main-item <?php echo $utility->check_menu($page, 'register_students,manage_students,import_students,export_students,promote_students'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'register_students,manage_students,import_students,export_students,promote_students'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-user-graduate"></i>
<span class="nav-main-link-name">Students</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'register_students'); ?>" href="app/register_students">
<span class="nav-main-link-name">Register Students</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'manage_students'); ?>" href="app/manage_students">
<span class="nav-main-link-name">Manage Students</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'import_students'); ?>" href="app/import_students">
<span class="nav-main-link-name">Import Students</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'export_students'); ?>" href="app/export_students">
<span class="nav-main-link-name">Export Students</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'promote_students'); ?>" href="app/promote_students">
<span class="nav-main-link-name">Students Promotion</span>
</a>
</li>
</ul>
</li>
<li class="nav-main-item <?php echo $utility->check_menu($page, 'import_results,manage_results,class_report'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'import_results,manage_results,class_report'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon far fa-file-lines"></i>
<span class="nav-main-link-name">Examination Results</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'import_results'); ?>" href="app/import_results">
<span class="nav-main-link-name">Import Results</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'manage_results'); ?>" href="app/manage_results">
<span class="nav-main-link-name">Manage Results</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'class_report'); ?>" href="app/class_report">
<span class="nav-main-link-name">Class Report</span>
</a>
</li>
</ul>
</li>

<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'announcements'); ?>" href="app/announcements">
<i class="nav-main-link-icon fa fa-bullhorn"></i>
<span class="nav-main-link-name">Announcements</span>
</a>
</li>

<li class="nav-main-item <?php echo $utility->check_menu($page, 'email_settings,signature_settings,general_settings'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'email_settings,signature_settings,general_settings'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-cog"></i>
<span class="nav-main-link-name">System Settings</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'email_settings'); ?>" href="app/email_settings">
<span class="nav-main-link-name">Email Settings</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'signature_settings'); ?>" href="app/signature_settings">
<span class="nav-main-link-name">Signature Settings</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'general_settings'); ?>" href="app/general_settings">
<span class="nav-main-link-name">General Settings</span>
</a>
</li>
</ul>
</li>
<?php
}
?>


</ul>
</div>
</div>
</nav>
<header id="page-header">
<div class="content-header">
<div class="space-x-1">
<button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
<i class="fa fa-fw fa-bars"></i>
</button>
</div>
<div class="space-x-1">
<div class="dropdown d-inline-block">
<button type="button" class="user_btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img class="img-avatar img-avatar32 img-avatar-thumb"
<?php
if (!empty($profile['reg_no'])) {
?>src="storage/images/students/<?php echo empty($profile['display_img']) ? $profile['gender'].'.png' : $profile['display_img']; ?>"<?php
}else{
?>src="storage/images/staff/<?php echo $profile['gender']; ?>.png"<?php
}
?>
>
<span class="d-none d-sm-inline-block"><?php echo $profile['first_name'].' '.$profile['last_name']; ?></span>
<i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
</button>
<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
<div class="p-2">
<a class="dropdown-item" href="app/account">
<i class="far fa-fw fa-user me-1"></i> Account Settings
</a>
<div role="separator" class="dropdown-divider"></div>
<a class="dropdown-item" href="app/logout">
<i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Logout
</a>
</div>
</div>
</div>
</div>
</div>
</header>
