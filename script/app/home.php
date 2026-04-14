<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$announcements = new announcements_controller;
$classes = new classes_controller;
$predictor = new predictor_controller;
$session = new session;
$info = $school->index();

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && $is_staff == 0) {

$page = $utility->get_page();
$latest_news = $announcements->get_latest('Students');

// Get prediction data for this student
$prediction = $predictor->predict_student_performance($profile['reg_no'], $profile['class']);
$class_info = $classes->show($profile['class']);
$class_name = $class_info ? $class_info['name'] : '';

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Dashboard'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="author" content="Abdul & Moses">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
.stat-card{border-radius:.5rem;padding:1.25rem;text-align:center;color:#fff;position:relative;overflow:hidden}
.stat-card .stat-value{font-size:2rem;font-weight:700;line-height:1.2}
.stat-card .stat-label{font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;opacity:.85;margin-top:.25rem}
.stat-card .stat-icon{position:absolute;right:12px;top:12px;font-size:1.5rem;opacity:.35}
.bg-primary-grad{background:linear-gradient(135deg,#0665d0 0%,#3c90df 100%)}
.bg-success-grad{background:linear-gradient(135deg,#6f9c40 0%,#8abb56 100%)}
.bg-warning-grad{background:linear-gradient(135deg,#e69f17 0%,#f0b840 100%)}
.bg-danger-grad{background:linear-gradient(135deg,#e04f1a 0%,#f07040 100%)}
.bg-info-grad{background:linear-gradient(135deg,#3c90df 0%,#5fa8f0 100%)}
.trend-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 10px;border-radius:20px;font-size:.8rem;font-weight:600}
.trend-improving{background:rgba(111,156,64,.15);color:#6f9c40}
.trend-declining{background:rgba(224,79,26,.15);color:#e04f1a}
.trend-stable{background:rgba(60,144,223,.15);color:#3c90df}
.subject-bar{height:8px;border-radius:4px;background:#e9ecef;overflow:hidden}
.subject-bar-fill{height:100%;border-radius:4px;transition:width .6s ease}
.tip-card{border-left:4px solid #0665d0;background:#f8f9fa;padding:12px 16px;border-radius:0 .375rem .375rem 0;margin-bottom:8px;font-size:.9rem}
</style>
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?> enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">

<!-- Welcome Header -->
<div class="d-flex align-items-center mb-4">
    <img class="img-avatar img-avatar-thumb me-3" src="storage/images/students/<?php echo empty($profile['display_img']) ? $profile['gender'].'.png' : $profile['display_img']; ?>" style="width:56px;height:56px;">
    <div>
        <h2 class="fw-bold mb-0" style="font-size:1.4rem;">Welcome, <?php echo $profile['first_name']; ?>!</h2>
        <div class="text-muted" style="font-size:.9rem;"><?php echo $profile['reg_no']; ?> &middot; <?php echo $class_name; ?></div>
    </div>
</div>

<?php if ($prediction): ?>
<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card bg-primary-grad">
            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
            <div class="stat-value"><?php echo $prediction['current_avg']; ?></div>
            <div class="stat-label">Current Average</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card <?php echo $prediction['predicted_score'] >= 50 ? 'bg-success-grad' : 'bg-danger-grad'; ?>">
            <div class="stat-icon"><i class="fa fa-brain"></i></div>
            <div class="stat-value"><?php echo $prediction['predicted_score']; ?></div>
            <div class="stat-label">Predicted Next</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <?php
        $risk_bg = 'bg-success-grad';
        if ($prediction['risk_level'] === 'HIGH') $risk_bg = 'bg-danger-grad';
        elseif ($prediction['risk_level'] === 'MEDIUM') $risk_bg = 'bg-warning-grad';
        ?>
        <div class="stat-card <?php echo $risk_bg; ?>">
            <div class="stat-icon"><i class="fa fa-shield-halved"></i></div>
            <div class="stat-value" style="font-size:1.5rem;"><?php echo $prediction['risk_level']; ?></div>
            <div class="stat-label">Risk Level</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <?php
        $trend_icon = '→'; $trend_bg = 'bg-info-grad';
        if ($prediction['trend'] === 'improving') { $trend_icon = '↑'; $trend_bg = 'bg-success-grad'; }
        elseif ($prediction['trend'] === 'declining') { $trend_icon = '↓'; $trend_bg = 'bg-danger-grad'; }
        ?>
        <div class="stat-card <?php echo $trend_bg; ?>">
            <div class="stat-icon"><i class="fa fa-arrow-trend-<?php echo $prediction['trend'] === 'declining' ? 'down' : 'up'; ?>"></i></div>
            <div class="stat-value" style="font-size:1.5rem;"><?php echo $trend_icon; ?> <?php echo abs($prediction['trend_change']); ?></div>
            <div class="stat-label"><?php echo ucfirst($prediction['trend']); ?> Trend</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <!-- Performance Trend Chart -->
    <div class="col-lg-7">
        <div class="block block-rounded mb-0 h-100">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-chart-area text-primary me-1"></i> Performance Trend</h3>
                <span class="badge rounded-pill" style="background:#0665d0;"><?php echo $prediction['confidence']; ?>% confidence</span>
            </div>
            <div class="block-content block-content-full">
                <canvas id="trendChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <!-- Subject Breakdown Chart -->
    <div class="col-lg-5">
        <div class="block block-rounded mb-0 h-100">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-chart-bar text-primary me-1"></i> Subject Scores</h3>
            </div>
            <div class="block-content block-content-full">
                <canvas id="subjectChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Subject Details + AI Recommendations -->
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="block block-rounded mb-0">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-book-open text-primary me-1"></i> Subject Details</h3>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th class="text-center" width="80">Score</th>
                                <th class="text-center" width="80">Predicted</th>
                                <th class="text-center" width="90">Trend</th>
                                <th width="120">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($prediction['subject_predictions'] as $sp):
                            $bar_color = '#6f9c40';
                            if ($sp['current'] < 40) $bar_color = '#e04f1a';
                            elseif ($sp['current'] < 60) $bar_color = '#e69f17';
                            $bar_w = min(100, max(0, $sp['current']));
                        ?>
                            <tr>
                                <td class="fw-semibold"><?php echo htmlspecialchars($sp['subject']); ?></td>
                                <td class="text-center">
                                    <span class="fw-bold" style="color:<?php echo $sp['current'] < 50 ? '#e04f1a' : '#333'; ?>">
                                        <?php echo $sp['current']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold" style="color:<?php echo $sp['predicted'] < 50 ? '#e04f1a' : '#6f9c40'; ?>">
                                        <?php echo $sp['predicted']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="trend-badge trend-<?php echo $sp['trend']; ?>">
                                        <?php if ($sp['trend'] === 'improving'): ?>↑ Up
                                        <?php elseif ($sp['trend'] === 'declining'): ?>↓ Down
                                        <?php else: ?>→ Steady<?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="subject-bar"><div class="subject-bar-fill" style="width:<?php echo $bar_w; ?>%;background:<?php echo $bar_color; ?>;"></div></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="block block-rounded mb-0 h-100">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-lightbulb text-warning me-1"></i> AI Recommendations</h3>
            </div>
            <div class="block-content">
                <?php if (!empty($prediction['recommendation'])): ?>
                    <?php foreach ($prediction['recommendation'] as $tip): ?>
                        <div class="tip-card"><?php echo htmlspecialchars($tip); ?></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No specific recommendations at this time.</p>
                <?php endif; ?>

                <?php if (!empty($prediction['failing_subjects'])): ?>
                <div class="alert alert-danger mt-3 mb-0">
                    <h6 class="alert-heading mb-1"><i class="fa fa-triangle-exclamation me-1"></i> Subjects Below Pass Mark</h6>
                    <?php foreach ($prediction['failing_subjects'] as $f): ?>
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <span><?php echo htmlspecialchars($f['subject']); ?></span>
                        <span class="badge bg-danger"><?php echo $f['score']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- No prediction data available -->
<div class="alert alert-info d-flex align-items-center" role="alert">
    <div class="flex-shrink-0"><i class="fa fa-fw fa-info-circle"></i></div>
    <div class="flex-grow-1 ms-3">
        <p class="mb-0">No examination results found yet. Your performance analytics and predictions will appear here once results are published.</p>
    </div>
</div>
<?php endif; ?>

<!-- Announcements -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title"><i class="fa fa-bullhorn text-primary me-1"></i> Announcements</h3>
    </div>
    <div class="block-content">
        <?php if (count($latest_news) < 1): ?>
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <div class="flex-shrink-0"><i class="fa fa-fw fa-info-circle"></i></div>
            <div class="flex-grow-1 ms-3"><p class="mb-0">No published announcements at the moment.</p></div>
        </div>
        <?php else: ?>
        <div id="accordion" role="tablist" aria-multiselectable="true">
            <?php foreach ($latest_news as $key => $value): ?>
            <div class="block block-rounded mb-1">
                <div class="block-header block-header-default" role="tab" id="accordion_h<?php echo $key; ?>">
                    <a class="fw-semibold <?php echo $key > 0 ? 'collapsed' : ''; ?>" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q<?php echo $key; ?>" aria-expanded="<?php echo $key === 0 ? 'true' : 'false'; ?>"><?php echo ($key+1).'. '.$value['title']; ?></a>
                </div>
                <div id="accordion_q<?php echo $key; ?>" class="collapse <?php echo $key === 0 ? 'show' : ''; ?>" role="tabpanel" aria-labelledby="accordion_h<?php echo $key; ?>" data-bs-parent="#accordion">
                    <div class="block-content">
                        <?php echo $value['announcement']; ?>
                        <div class="text-muted mt-2"><i><?php echo date("F d, Y g:i A", strtotime($value['date_published'])); ?></i></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

</div>
</main>
<?php require_once 'includes/footer.php'; ?>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/core.js"></script>
<?php if ($prediction): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var primaryColor = '#0665d0';
    var successColor = '#6f9c40';
    var dangerColor  = '#e04f1a';
    var warningColor = '#e69f17';
    var infoColor    = '#3c90df';

    // --- Performance Trend Chart ---
    var termHistory = <?php echo json_encode($prediction['term_history']); ?>;
    var trendLabels = termHistory.map(function(t){ return t.term_name; });
    var trendData   = termHistory.map(function(t){ return t.average; });

    // Add predicted point with a bridge from last real data
    trendLabels.push('Predicted');
    var predictedData = new Array(trendData.length).fill(null);
    predictedData[predictedData.length - 1] = trendData[trendData.length - 1];
    predictedData.push(<?php echo $prediction['predicted_score']; ?>);
    trendData.push(null);

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Average Score',
                data: trendData,
                borderColor: primaryColor,
                backgroundColor: primaryColor + '20',
                tension: 0.3,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: primaryColor
            },{
                label: 'Predicted',
                data: predictedData,
                borderColor: successColor,
                borderDash: [6, 4],
                tension: 0.3,
                fill: false,
                pointRadius: 7,
                pointStyle: 'star',
                pointBackgroundColor: successColor
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } } },
            scales: {
                y: { beginAtZero: false, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // --- Subject Scores Chart ---
    var subjects = <?php echo json_encode($prediction['subject_predictions']); ?>;
    var subLabels = subjects.map(function(s){ return s.subject; });
    var subCurrent = subjects.map(function(s){ return s.current; });
    var subPredicted = subjects.map(function(s){ return s.predicted; });
    var subColors = subCurrent.map(function(v){ return v < 40 ? dangerColor : v < 60 ? warningColor : successColor; });

    new Chart(document.getElementById('subjectChart'), {
        type: 'bar',
        data: {
            labels: subLabels,
            datasets: [{
                label: 'Current',
                data: subCurrent,
                backgroundColor: subColors,
                borderRadius: 4,
                barPercentage: 0.6
            },{
                label: 'Predicted',
                data: subPredicted,
                backgroundColor: infoColor + '50',
                borderColor: infoColor,
                borderWidth: 1,
                borderRadius: 4,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } } },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                y: { grid: { display: false } }
            }
        }
    });
});
</script>
<?php endif; ?>
</body>
</html>
<?php
}else{
header("location:../");
}
?>
