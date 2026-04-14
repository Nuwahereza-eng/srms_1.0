<nav id="sidebar" aria-label="Main Navigation">
<div class="bg-header-dark">
<div class="content-header bg-white-5">
<a class="fw-semibold text-white tracking-wide" href="./app/dashboard">
<span class="smini-hidden">
SRMS
</span>
</a>
<div class="d-flex align-items-center gap-1">
<span class="smini-hidden badge bg-white-10 text-white-75 fw-normal" style="font-size:.6rem;letter-spacing:.5px;">v1.0</span>
<button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
<i class="fa fa-times-circle"></i>
</button>
</div>
</div>
</div>
<div class="js-sidebar-scroll">
<div class="content-side">
<div class="text-center">
<img class="mb-2 center_img" src="storage/images/misc/<?php echo $info['logo']; ?>" height="120" alt="School Logo">
<div class="mb-3">
<div class="fw-semibold text-white" style="font-size:.82rem;"><?php echo $info['name']; ?></div>
<div class="text-white-50" style="font-size:.68rem;letter-spacing:.3px;">Results Management System</div>
</div>
</div>

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
<li class="nav-main-item <?php echo $utility->check_menu($page, 'analytics,predictor'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'analytics,predictor'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-chart-line"></i>
<span class="nav-main-link-name">AI & Analytics</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'analytics'); ?>" href="app/analytics">
<span class="nav-main-link-name">Analytics Dashboard</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'predictor'); ?>" href="app/predictor">
<span class="nav-main-link-name">Performance Predictor</span>
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

<li class="nav-main-item <?php echo $utility->check_menu($page, 'analytics,predictor'); ?>">
<a class="nav-main-link nav-main-link-submenu <?php echo $utility->check_menu($page, 'analytics,predictor'); ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-chart-line"></i>
<span class="nav-main-link-name">AI & Analytics</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'analytics'); ?>" href="app/analytics">
<span class="nav-main-link-name">Analytics Dashboard</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php echo $utility->check_menu($page, 'predictor'); ?>" href="app/predictor">
<span class="nav-main-link-name">Performance Predictor</span>
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

<!-- Global Search -->
<div class="d-none d-md-block flex-grow-1 mx-3" style="max-width: 480px; position: relative;">
    <div class="position-relative" id="globalSearchWrap">
        <span class="position-absolute top-50 translate-middle-y" style="left: 12px; color: var(--bs-gray-500); pointer-events: none; font-size: 0.85rem;">
            <i class="fa fa-search"></i>
        </span>
        <input type="text" id="globalSearchInput" class="form-control form-control-sm" placeholder="Search students, classes, subjects…" autocomplete="off"
            onkeydown="if(event.key==='Enter'){event.preventDefault();event.stopPropagation();var e=new CustomEvent('searchnow');this.dispatchEvent(e);return false;}"
            style="padding-left: 34px; border-radius: 20px; background-color: #ffffff; border: 1px solid #d1d5db; color: #343a40; font-size: 0.85rem; height: 36px;">
        <kbd class="position-absolute top-50 translate-middle-y d-none d-lg-inline-block" style="right: 10px; font-size: 0.65rem; color: var(--bs-gray-500); border: 1px solid var(--bs-gray-300); border-radius: 4px; padding: 1px 6px; background: #fff; pointer-events: none;">Ctrl+K</kbd>
        <!-- Results dropdown -->
        <div id="globalSearchResults" class="position-absolute w-100 bg-white shadow-lg border rounded-3 mt-1" style="z-index: 1060; display: none; max-height: 400px; overflow-y: auto; top: 100%; left: 0;">
        </div>
    </div>
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
<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown" style="min-width:220px;">
<div class="px-3 py-3 text-center" style="background:linear-gradient(135deg,#0665d0,#3c90df);border-radius:.375rem .375rem 0 0;">
<img class="img-avatar img-avatar-thumb mb-2" style="width:52px;height:52px;border:2px solid rgba(255,255,255,.4);"
<?php if (!empty($profile['reg_no'])): ?>
src="storage/images/students/<?php echo empty($profile['display_img']) ? $profile['gender'].'.png' : $profile['display_img']; ?>"
<?php else: ?>
src="storage/images/staff/<?php echo $profile['gender']; ?>.png"
<?php endif; ?>>
<div class="fw-semibold text-white"><?php echo $profile['first_name'].' '.$profile['last_name']; ?></div>
<div class="text-white-75" style="font-size:.75rem;"><?php echo !empty($profile['reg_no']) ? $profile['reg_no'] : ($profile['role'] ?? ''); ?></div>
<div class="text-white-50" style="font-size:.7rem;"><?php echo $profile['email'] ?? ''; ?></div>
</div>
<div class="p-2">
<a class="dropdown-item d-flex align-items-center" href="app/account">
<i class="fa fa-fw fa-user-gear me-2 text-primary"></i> Account Settings
</a>
<div role="separator" class="dropdown-divider"></div>
<a class="dropdown-item d-flex align-items-center text-danger" href="app/logout">
<i class="fa fa-fw fa-right-from-bracket me-2"></i> Logout
</a>
</div>
</div>
</div>
</div>
</div>
</header>

<style>
#globalSearchResults .gs-item { display: flex; align-items: center; gap: 10px; padding: 9px 14px; text-decoration: none; color: var(--bs-body-color); transition: background 0.12s; cursor: pointer; border-bottom: 1px solid var(--bs-gray-100); }
#globalSearchResults .gs-item:last-child { border-bottom: none; }
#globalSearchResults .gs-item:hover, #globalSearchResults .gs-item.gs-active { background: var(--bs-primary-bg-subtle); }
#globalSearchResults .gs-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0; }
#globalSearchResults .gs-icon.student { background: var(--bs-primary-bg-subtle); color: var(--bs-primary); }
#globalSearchResults .gs-icon.class { background: var(--bs-success-bg-subtle); color: var(--bs-success); }
#globalSearchResults .gs-icon.subject { background: var(--bs-warning-bg-subtle); color: var(--bs-warning); }
#globalSearchResults .gs-icon.teacher { background: var(--bs-info-bg-subtle); color: var(--bs-info); }
#globalSearchResults .gs-title { font-weight: 600; font-size: 0.85rem; line-height: 1.2; }
#globalSearchResults .gs-sub { font-size: 0.75rem; color: var(--bs-gray-600); }
#globalSearchResults .gs-type { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: var(--bs-gray-500); padding: 2px 8px; background: var(--bs-gray-100); border-radius: 4px; margin-left: auto; flex-shrink: 0; }
#globalSearchResults .gs-empty { padding: 20px; text-align: center; color: var(--bs-gray-500); font-size: 0.85rem; }
#globalSearchResults .gs-loading { padding: 16px; text-align: center; color: var(--bs-gray-500); font-size: 0.85rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('globalSearchInput');
    var resultsBox = document.getElementById('globalSearchResults');
    if (!input || !resultsBox) return;

    var debounceTimer = null;
    var activeIdx = -1;
    var currentItems = [];

    function doSearch(q) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/getter/global_search.php?q=' + encodeURIComponent(q), true);
        xhr.withCredentials = true;
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4) return;
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.error) {
                        resultsBox.innerHTML = '<div class="gs-empty"><i class="fa fa-lock me-1"></i> Session expired — please refresh</div>';
                    } else {
                        renderResults(data.results || []);
                    }
                } catch(e) {
                    resultsBox.innerHTML = '<div class="gs-empty"><i class="fa fa-exclamation-circle me-1"></i> Search error</div>';
                }
            } else {
                resultsBox.innerHTML = '<div class="gs-empty"><i class="fa fa-exclamation-circle me-1"></i> Please refresh the page</div>';
            }
        };
        xhr.send();
    }

    // Ctrl+K shortcut
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            input.focus();
            input.select();
        }
        // Escape closes
        if (e.key === 'Escape') {
            resultsBox.style.display = 'none';
            input.blur();
        }
    });

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var q = input.value.trim();
        if (q.length < 2) {
            resultsBox.style.display = 'none';
            return;
        }
        resultsBox.innerHTML = '<div class="gs-loading"><i class="fa fa-spinner fa-spin me-1"></i> Searching…</div>';
        resultsBox.style.display = 'block';
        activeIdx = -1;

        debounceTimer = setTimeout(function() { doSearch(q); }, 250);
    });

    input.addEventListener('focus', function() {
        if (input.value.trim().length >= 2 && resultsBox.innerHTML.trim() !== '') {
            resultsBox.style.display = 'block';
        }
    });

    // Enter key handler — fires via inline onkeydown custom event (bulletproof, no form submission)
    input.addEventListener('searchnow', function() {
        // If a result is highlighted, navigate to it
        if (resultsBox.style.display !== 'none' && activeIdx >= 0 && currentItems[activeIdx]) {
            window.location.href = currentItems[activeIdx].url;
            return;
        }
        // If only one result exists, navigate to it directly
        if (currentItems.length === 1) {
            window.location.href = currentItems[0].url;
            return;
        }
        // Otherwise trigger an immediate search
        var q = input.value.trim();
        if (q.length >= 2) {
            clearTimeout(debounceTimer);
            resultsBox.innerHTML = '<div class="gs-loading"><i class="fa fa-spinner fa-spin me-1"></i> Searching…</div>';
            resultsBox.style.display = 'block';
            activeIdx = -1;
            doSearch(q);
        }
    });

    // Arrow key navigation
    input.addEventListener('keydown', function(e) {
        if (resultsBox.style.display === 'none') return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = Math.min(activeIdx + 1, currentItems.length - 1);
            highlightItem();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = Math.max(activeIdx - 1, 0);
            highlightItem();
        }
    });

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#globalSearchWrap')) {
            resultsBox.style.display = 'none';
        }
    });

    function highlightItem() {
        var items = resultsBox.querySelectorAll('.gs-item');
        items.forEach(function(el, i) {
            el.classList.toggle('gs-active', i === activeIdx);
        });
        if (items[activeIdx]) items[activeIdx].scrollIntoView({ block: 'nearest' });
    }

    function renderResults(results) {
        currentItems = results;
        activeIdx = -1;
        if (results.length === 0) {
            resultsBox.innerHTML = '<div class="gs-empty"><i class="fa fa-search me-1"></i> No results for "<b>' + escHtml(input.value) + '</b>"</div>';
            return;
        }
        var html = '';
        for (var i = 0; i < results.length; i++) {
            var r = results[i];
            html += '<a href="' + r.url + '" class="gs-item" data-idx="' + i + '">' +
                '<div class="gs-icon ' + r.type + '"><i class="fa ' + r.icon + '"></i></div>' +
                '<div><div class="gs-title">' + escHtml(r.title) + '</div><div class="gs-sub">' + escHtml(r.sub) + '</div></div>' +
                '<span class="gs-type">' + r.type + '</span>' +
                '</a>';
        }
        resultsBox.innerHTML = html;
    }

    function escHtml(s) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(s));
        return d.innerHTML;
    }
});
</script>
