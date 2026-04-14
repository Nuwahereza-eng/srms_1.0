<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();
$analytics = new analytics_controller;

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && !empty($profile['role'])) {

$page = $utility->get_page();

// Get filter options
$all_classes = $analytics->get_classes();
$all_terms = $analytics->get_all_terms();
$all_cas = $analytics->get_cas();

// Default selections
$sel_class = isset($_GET['class_id']) ? intval($_GET['class_id']) : (!empty($all_classes) ? $all_classes[0]['id'] : 0);
$sel_term = isset($_GET['term']) ? intval($_GET['term']) : (!empty($all_terms) ? $all_terms[0]['id'] : 0);
$sel_ca = isset($_GET['ca']) ? intval($_GET['ca']) : (!empty($all_cas) ? $all_cas[0]['id'] : 0);

// Fetch data
$subject_avgs = $analytics->subject_averages($sel_class, $sel_term, $sel_ca);
$gender_data = $analytics->gender_analysis($sel_class, $sel_term, $sel_ca);
$grade_dist = $analytics->grade_distribution($sel_class, $sel_term, $sel_ca);
$top_list = $analytics->top_students($sel_class, $sel_term, $sel_ca, 10);
$term_trends = $analytics->term_trends($sel_class, $sel_ca);
$class_comp = $analytics->class_comparison($sel_term, $sel_ca);
$stats = $analytics->overview_stats();

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - Analytics Dashboard'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
.chart-container { position: relative; height: 320px; width: 100%; }
.stat-card-analytics { border-left: 4px solid; }
.stat-card-analytics.purple { border-color: var(--bs-purple); }
.stat-card-analytics.blue { border-color: var(--bs-primary); }
.stat-card-analytics.green { border-color: var(--bs-success); }
.trend-up { color: var(--bs-success); }
.trend-down { color: var(--bs-danger); }
.trend-stable { color: var(--bs-warning); }
</style>
</head>
<body>
<div id="page-loader" class="show"></div>
<div id="page-container" class="sidebar-o <?php echo $info['sidebar'];?> enable-page-overlay side-scroll page-header-fixed page-footer-fixed">
<?php require_once 'includes/header.php'; ?>
<main id="main-container">
<div class="content">

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="content-heading mb-0">
            <i class="fa fa-chart-line text-primary me-2"></i>Analytics Dashboard
        </h2>
        <p class="text-muted mb-0">Visual insights into student performance and academic trends</p>
    </div>
</div>

<!-- Overview Stat Cards -->
<div class="row items-push mb-2">
    <div class="col-sm-6 col-xl-4">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 stat-card-analytics purple">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item item-circle bg-body-light mx-auto">
                    <i class="fa fa-2x fa-file-lines text-primary"></i>
                </div>
                <div class="fs-3 fw-bold"><?php echo number_format($stats['total_results']); ?></div>
                <div class="text-muted mb-3">Total Result Records</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 stat-card-analytics blue">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item item-circle bg-body-light mx-auto">
                    <i class="fa fa-2x fa-user-graduate text-primary"></i>
                </div>
                <div class="fs-3 fw-bold"><?php echo number_format($stats['total_students']); ?></div>
                <div class="text-muted mb-3">Students with Results</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 stat-card-analytics green">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item item-circle bg-body-light mx-auto">
                    <i class="fa fa-2x fa-building text-primary"></i>
                </div>
                <div class="fs-3 fw-bold"><?php echo number_format($stats['total_classes']); ?></div>
                <div class="text-muted mb-3">Classes with Results</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title"><i class="fa fa-filter me-1"></i> Filter Results</h3>
    </div>
    <div class="block-content">
        <form method="GET" action="app/analytics" class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Class</label>
                <select name="class_id" class="form-select">
                    <?php foreach ($all_classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php echo $sel_class == $c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Term</label>
                <select name="term" class="form-select">
                    <?php foreach ($all_terms as $t): ?>
                    <option value="<?php echo $t['id']; ?>" <?php echo $sel_term == $t['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($t['term']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Assessment</label>
                <select name="ca" class="form-select">
                    <?php foreach ($all_cas as $a): ?>
                    <option value="<?php echo $a['id']; ?>" <?php echo $sel_ca == $a['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($a['assessment']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Charts Row 1: Subject Averages + Grade Distribution -->
<div class="row">
    <div class="col-lg-8">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-chart-bar me-1"></i> Subject Performance (Average Scores)</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="chart-container">
                    <canvas id="subjectChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-chart-pie me-1"></i> Grade Distribution</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="chart-container">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2: Term Trends + Class Comparison -->
<div class="row">
    <div class="col-lg-6">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-chart-line me-1"></i> Performance Trend Across Terms</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-ranking-star me-1"></i> Class Comparison</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="chart-container">
                    <canvas id="classCompChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 3: Gender Analysis + Top Students -->
<div class="row">
    <div class="col-lg-4">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-venus-mars me-1"></i> Gender Analysis</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-trophy me-1"></i> Top 10 Students</h3>
            </div>
            <div class="block-content block-content-full">
                <?php if (count($top_list) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Student</th>
                                <th>Reg No</th>
                                <th>Gender</th>
                                <th class="text-center">Subjects</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Average</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_list as $i => $st): ?>
                            <tr>
                                <td class="text-center fw-bold">
                                    <?php 
                                    if ($i == 0) echo '<span class="badge bg-warning text-dark"><i class="fa fa-trophy"></i> 1</span>';
                                    elseif ($i == 1) echo '<span class="badge bg-secondary">2</span>';
                                    elseif ($i == 2) echo '<span class="badge bg-info">3</span>';
                                    else echo ($i + 1);
                                    ?>
                                </td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($st['name']); ?></td>
                                <td><?php echo htmlspecialchars($st['reg_no']); ?></td>
                                <td>
                                    <i class="fa <?php echo $st['gender'] == 'Male' ? 'fa-mars text-primary' : 'fa-venus text-danger'; ?>"></i>
                                    <?php echo $st['gender']; ?>
                                </td>
                                <td class="text-center"><?php echo $st['subjects']; ?></td>
                                <td class="text-center fw-bold"><?php echo $st['total']; ?></td>
                                <td class="text-center">
                                    <span class="badge <?php echo $st['average'] >= 70 ? 'bg-success' : ($st['average'] >= 50 ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                        <?php echo $st['average']; ?>%
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <div class="flex-shrink-0"><i class="fa fa-fw fa-info-circle"></i></div>
                    <div class="flex-grow-1 ms-3"><p class="mb-0">No results data found for the selected filters.</p></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</div>
</main>
<?php require_once 'includes/footer.php'; ?>
</div>

<script src="assets/js/core.js"></script>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Color palette
    const colors = {
        primary: '#0665d0',
        success: '#6f9c40',
        warning: '#e69f17',
        danger: '#e04f1a',
        info: '#3c90df',
        purple: '#6f42c1',
        pink: '#d63384',
        indigo: '#6610f2',
        teal: '#20c997',
        orange: '#fd7e14'
    };
    const palette = Object.values(colors);

    // ─── Subject Performance Bar Chart ───
    const subjectLabels = <?php echo json_encode(array_column($subject_avgs, 'subject_name')); ?>;
    const subjectValues = <?php echo json_encode(array_column($subject_avgs, 'average')); ?>;
    
    new Chart(document.getElementById('subjectChart'), {
        type: 'bar',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Average Score',
                data: subjectValues,
                backgroundColor: subjectLabels.map((_, i) => palette[i % palette.length] + 'CC'),
                borderColor: subjectLabels.map((_, i) => palette[i % palette.length]),
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Average: ' + ctx.parsed.y + '%'
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: 'Average Score (%)' } },
                x: { ticks: { maxRotation: 45, minRotation: 0 } }
            }
        }
    });

    // ─── Grade Distribution Doughnut ───
    const gradeLabels = <?php echo json_encode(array_keys($grade_dist)); ?>;
    const gradeValues = <?php echo json_encode(array_values($grade_dist)); ?>;
    const gradeColors = ['#6f9c40', '#3c90df', '#0665d0', '#e69f17', '#fd7e14', '#e04f1a'];
    
    new Chart(document.getElementById('gradeChart'), {
        type: 'doughnut',
        data: {
            labels: gradeLabels,
            datasets: [{
                data: gradeValues,
                backgroundColor: gradeColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 8, font: { size: 11 } } }
            }
        }
    });

    // ─── Term Trend Line Chart ───
    const trendLabels = <?php echo json_encode(array_column($term_trends, 'term_name')); ?>;
    const trendValues = <?php echo json_encode(array_column($term_trends, 'average')); ?>;
    
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Class Average',
                data: trendValues,
                borderColor: colors.primary,
                backgroundColor: colors.primary + '22',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Average: ' + ctx.parsed.y + '%'
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: 'Average Score (%)' } }
            }
        }
    });

    // ─── Class Comparison Horizontal Bar ───
    const classLabels = <?php echo json_encode(array_column($class_comp, 'class_name')); ?>;
    const classValues = <?php echo json_encode(array_column($class_comp, 'average')); ?>;
    
    new Chart(document.getElementById('classCompChart'), {
        type: 'bar',
        data: {
            labels: classLabels,
            datasets: [{
                label: 'Class Average',
                data: classValues,
                backgroundColor: classLabels.map((_, i) => palette[i % palette.length] + 'CC'),
                borderColor: classLabels.map((_, i) => palette[i % palette.length]),
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Average: ' + ctx.parsed.x + '%'
                    }
                }
            },
            scales: {
                x: { beginAtZero: true, max: 100, title: { display: true, text: 'Average Score (%)' } }
            }
        }
    });

    // ─── Gender Analysis Bar Chart ───
    const genderLabels = <?php echo json_encode(array_column($gender_data, 'gender')); ?>;
    const genderValues = <?php echo json_encode(array_column($gender_data, 'average')); ?>;
    const genderStudents = <?php echo json_encode(array_column($gender_data, 'students')); ?>;
    
    new Chart(document.getElementById('genderChart'), {
        type: 'bar',
        data: {
            labels: genderLabels,
            datasets: [{
                label: 'Average Score',
                data: genderValues,
                backgroundColor: ['#0665d0' + 'CC', '#d63384' + 'CC'],
                borderColor: ['#0665d0', '#d63384'],
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        afterLabel: function(ctx) {
                            return 'Students: ' + genderStudents[ctx.dataIndex];
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: 'Average Score (%)' } }
            }
        }
    });

});
</script>

<?php
} else {
    header("location: ./");
    exit();
}
?>
</body>
</html>
