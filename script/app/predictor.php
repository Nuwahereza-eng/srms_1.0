<?php
chdir('../');
require_once 'autoload.php';
$school = new school_controller;
$staff = new staff_controller;
$students = new students_controller;
$session = new session;
$info = $school->index();
$predictor = new predictor_controller;

require_once 'includes/session_validator.php';

if (!empty($is_authenticated) && $is_authenticated == 1 && !empty($profile['role'])) {

$page = $utility->get_page();

// Filter options
$all_classes = $predictor->get_classes();
$all_cas = $predictor->get_cas();

// Defaults
$sel_class = isset($_GET['class_id']) ? intval($_GET['class_id']) : (!empty($all_classes) ? $all_classes[0]['id'] : 0);
$sel_ca = isset($_GET['ca']) ? intval($_GET['ca']) : (!empty($all_cas) ? $all_cas[0]['id'] : 0);

// Run predictions
$predictions = $predictor->predict_class_performance($sel_class, $sel_ca);
$summary = $predictor->class_prediction_summary($predictions);

?>
<!doctype html>
<html lang="en" class="remember-theme">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo $info['name'].' - AI Performance Predictor'; ?></title>
<meta name="description" content="Students Results Management System">
<meta name="robots" content="index, follow">
<base href="../">
<link rel="shortcut icon" href="storage/images/misc/<?php echo $info['icon']; ?>">
<link rel="stylesheet" id="css-main" href="assets/css/core.css"><?php echo $info['theme'] !== '0' ? '<link type="text/css" rel="stylesheet" id="css-theme" href="assets/css/themes/'.$info['theme'].'.css">' : '' ; ?>
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
.text-pink { color: #d63384 !important; }
.risk-high { background: var(--bs-danger-bg-subtle); border-left: 4px solid var(--bs-danger); }
.risk-medium { background: var(--bs-warning-bg-subtle); border-left: 4px solid var(--bs-warning); }
.risk-low { background: var(--bs-success-bg-subtle); border-left: 4px solid var(--bs-success); }
.risk-badge-high { background: var(--bs-danger); color: #fff; }
.risk-badge-medium { background: var(--bs-warning); color: #fff; }
.risk-badge-low { background: var(--bs-success); color: #fff; }
.trend-arrow { font-size: 1.2rem; font-weight: bold; }
.trend-improving { color: var(--bs-success); }
.trend-declining { color: var(--bs-danger); }
.trend-stable { color: var(--bs-warning); }
.prediction-card { transition: all 0.2s; }
.prediction-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.sparkline-container { display: inline-block; width: 120px; height: 35px; }
.ai-badge { 
    background: linear-gradient(135deg, #044792, var(--bs-primary)); 
    color: white; 
    font-size: 0.7rem; 
    padding: 2px 8px; 
    border-radius: 12px; 
    font-weight: 600;
    letter-spacing: 0.5px;
}
.summary-ring {
    width: 80px; height: 80px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; font-weight: bold;
}
.confidence-bar {
    height: 6px;
    border-radius: 3px;
    background: var(--bs-gray-200);
    overflow: hidden;
}
.confidence-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.5s;
}
.failing-subject-pill {
    display: inline-block;
    background: var(--bs-danger-bg-subtle);
    color: var(--bs-danger);
    border: 1px solid var(--bs-danger-border-subtle);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    margin: 1px;
}
.fail-count-badge {
    cursor: pointer;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--bs-danger-bg-subtle);
    color: var(--bs-danger);
    border: 1px solid var(--bs-danger-border-subtle);
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.15s;
}
.fail-count-badge:hover { background: var(--bs-danger-border-subtle); }
.fail-popover {
    display: none;
    position: absolute;
    z-index: 1050;
    bottom: calc(100% + 8px);
    right: 0;
    min-width: 220px;
    background: #fff;
    border: 1px solid var(--bs-gray-200);
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    padding: 10px 12px;
    font-size: 0.8rem;
}
.fail-popover::after {
    content: '';
    position: absolute;
    bottom: -6px;
    right: 16px;
    width: 10px; height: 10px;
    background: #fff;
    border-right: 1px solid var(--bs-gray-200);
    border-bottom: 1px solid var(--bs-gray-200);
    transform: rotate(45deg);
}
.fail-popover .fp-row {
    display: flex;
    justify-content: space-between;
    padding: 3px 0;
    border-bottom: 1px solid var(--bs-gray-100);
}
.fail-popover .fp-row:last-child { border-bottom: none; }
.fail-popover .fp-subject { color: var(--bs-body-color); }
.fail-popover .fp-score { color: var(--bs-danger); font-weight: 600; }
.risk-filter-tabs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.risk-filter-tabs .btn { font-size: 0.82rem; }
.risk-filter-tabs .btn.active { box-shadow: 0 2px 6px rgba(0,0,0,.15); }
.pred-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
    padding: 12px 0;
}
.pred-pagination .page-btn {
    width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--bs-gray-300);
    border-radius: 6px;
    background: #fff;
    color: var(--bs-body-color);
    font-size: 0.82rem;
    cursor: pointer;
    transition: all 0.15s;
}
.pred-pagination .page-btn:hover { background: var(--bs-gray-100); }
.pred-pagination .page-btn.active { background: var(--bs-primary); color: #fff; border-color: var(--bs-primary); }
.pred-pagination .page-btn:disabled { opacity: 0.4; cursor: default; }
.pred-pagination .page-info { font-size: 0.82rem; color: var(--bs-gray-600); margin: 0 8px; }
.trend-cell { display: flex; align-items: center; gap: 8px; justify-content: center; }
.pred-row { cursor: pointer; transition: background 0.15s; }
.pred-row:hover { background: var(--bs-primary-bg-subtle) !important; }

/* ─── Student Detail Modal ─── */
#studentDetailModal .modal-header { border-bottom: none; padding-bottom: 0; }
#studentDetailModal .modal-body { padding-top: 8px; }
.sdm-header { display: flex; align-items: center; gap: 14px; padding: 12px 0; }
.sdm-avatar { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
.sdm-avatar.male { background: var(--bs-primary-bg-subtle); color: var(--bs-primary); }
.sdm-avatar.female { background: #f9e2ef; color: #d63384; }
.sdm-name { font-size: 1.25rem; font-weight: 700; color: var(--bs-body-color); margin-bottom: 0; }
.sdm-reg { font-size: 0.82rem; color: var(--bs-gray-600); }
.sdm-metrics { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin: 16px 0; }
.sdm-metric-card { background: var(--bs-gray-100); border-radius: 10px; padding: 14px 12px; text-align: center; border: 1px solid var(--bs-gray-200); }
.sdm-metric-val { font-size: 1.5rem; font-weight: 800; line-height: 1.2; }
.sdm-metric-label { font-size: 0.72rem; color: var(--bs-gray-600); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-top: 4px; }
.sdm-chart-wrap { background: var(--bs-gray-100); border-radius: 10px; border: 1px solid var(--bs-gray-200); padding: 16px; margin-bottom: 16px; }
.sdm-chart-wrap canvas { width: 100% !important; height: 200px !important; }
.sdm-section-title { font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--bs-gray-600); font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
.sdm-term-table { width: 100%; font-size: 0.85rem; }
.sdm-term-table th { background: var(--bs-light); font-weight: 600; color: var(--bs-gray-700); padding: 8px 12px; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.3px; }
.sdm-term-table td { padding: 8px 12px; border-bottom: 1px solid var(--bs-light); }
.sdm-term-table tr:last-child td { border-bottom: none; }
.sdm-term-table .predicted-row { background: var(--bs-primary-bg-subtle); font-style: italic; }
.sdm-fail-list { display: flex; flex-wrap: wrap; gap: 6px; }
.sdm-fail-chip { display: flex; align-items: center; gap: 6px; background: var(--bs-danger-bg-subtle); border: 1px solid var(--bs-danger-border-subtle); border-radius: 8px; padding: 6px 12px; font-size: 0.82rem; }
.sdm-fail-chip .fc-name { color: var(--bs-danger-text-emphasis); font-weight: 600; }
.sdm-fail-chip .fc-score { color: var(--bs-danger); font-weight: 700; }
.sdm-recommendation { border-radius: 10px; padding: 16px; margin-top: 16px; display: flex; gap: 12px; align-items: flex-start; }
.sdm-recommendation.rec-high { background: var(--bs-danger-bg-subtle); border: 1px solid var(--bs-danger-border-subtle); }
.sdm-recommendation.rec-medium { background: var(--bs-warning-bg-subtle); border: 1px solid var(--bs-warning-border-subtle); }
.sdm-recommendation.rec-low { background: var(--bs-success-bg-subtle); border: 1px solid var(--bs-success-border-subtle); }
.sdm-rec-icon { font-size: 1.5rem; flex-shrink: 0; margin-top: 2px; }
.sdm-rec-title { font-weight: 700; margin-bottom: 4px; }
.sdm-rec-text { font-size: 0.88rem; color: var(--bs-body-color); line-height: 1.5; }
@media (max-width: 576px) {
    .sdm-metrics { grid-template-columns: repeat(2, 1fr); }
}
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
            <i class="fa fa-brain text-primary me-2"></i>AI Performance Predictor
            <span class="ai-badge ms-2">AI-POWERED</span>
        </h2>
        <p class="text-muted mb-0">Machine learning-based analysis of student performance trends and future predictions</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="row items-push mb-2">
    <div class="col-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 prediction-card" style="border-left: 4px solid var(--bs-danger);">
            <div class="block-content block-content-full flex-grow-1">
                <div class="summary-ring mx-auto mb-2" style="background: var(--bs-danger-bg-subtle); color: var(--bs-danger);">
                    <?php echo $summary['high']; ?>
                </div>
                <div class="fw-semibold text-danger">High Risk</div>
                <div class="text-muted fs-sm">Students at risk of failing</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 prediction-card" style="border-left: 4px solid var(--bs-warning);">
            <div class="block-content block-content-full flex-grow-1">
                <div class="summary-ring mx-auto mb-2" style="background: var(--bs-warning-bg-subtle); color: var(--bs-warning);">
                    <?php echo $summary['medium']; ?>
                </div>
                <div class="fw-semibold" style="color: var(--bs-warning);">Medium Risk</div>
                <div class="text-muted fs-sm">Need monitoring</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 prediction-card" style="border-left: 4px solid var(--bs-success);">
            <div class="block-content block-content-full flex-grow-1">
                <div class="summary-ring mx-auto mb-2" style="background: var(--bs-success-bg-subtle); color: var(--bs-success);">
                    <?php echo $summary['low']; ?>
                </div>
                <div class="fw-semibold text-success">Low Risk</div>
                <div class="text-muted fs-sm">On track</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 mb-0 prediction-card" style="border-left: 4px solid var(--bs-primary);">
            <div class="block-content block-content-full flex-grow-1">
                <div class="summary-ring mx-auto mb-2" style="background: var(--bs-primary-bg-subtle); color: var(--bs-primary);">
                    <?php echo $summary['avg_predicted']; ?>%
                </div>
                <div class="fw-semibold" style="color: var(--bs-primary);">Avg Predicted</div>
                <div class="text-muted fs-sm">Class predicted average</div>
            </div>
        </div>
    </div>
</div>

<!-- Trend Summary -->
<div class="row items-push mb-2">
    <div class="col-md-4">
        <div class="block block-rounded mb-0">
            <div class="block-content block-content-full text-center py-3">
                <i class="fa fa-arrow-trend-up fa-2x text-success mb-2"></i>
                <div class="fs-4 fw-bold text-success"><?php echo $summary['improving']; ?></div>
                <div class="text-muted fs-sm">Improving</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="block block-rounded mb-0">
            <div class="block-content block-content-full text-center py-3">
                <i class="fa fa-arrows-left-right fa-2x mb-2" style="color: var(--bs-warning);"></i>
                <div class="fs-4 fw-bold" style="color: var(--bs-warning);"><?php echo $summary['stable']; ?></div>
                <div class="text-muted fs-sm">Stable</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="block block-rounded mb-0">
            <div class="block-content block-content-full text-center py-3">
                <i class="fa fa-arrow-trend-down fa-2x text-danger mb-2"></i>
                <div class="fs-4 fw-bold text-danger"><?php echo $summary['declining']; ?></div>
                <div class="text-muted fs-sm">Declining</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title"><i class="fa fa-filter me-1"></i> Select Class & Assessment</h3>
    </div>
    <div class="block-content">
        <form method="GET" action="app/predictor" class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Class</label>
                <select name="class_id" class="form-select">
                    <?php foreach ($all_classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php echo $sel_class == $c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Assessment</label>
                <select name="ca" class="form-select">
                    <?php foreach ($all_cas as $a): ?>
                    <option value="<?php echo $a['id']; ?>" <?php echo $sel_ca == $a['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($a['assessment']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-brain me-1"></i> Run Prediction</button>
            </div>
        </form>
    </div>
</div>

<!-- Predictions Table -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="fa fa-robot me-1"></i> Student Predictions
            <span class="ai-badge ms-2">ML ANALYSIS</span>
        </h3>
        <div class="block-options">
            <span class="badge bg-body-dark"><?php echo $summary['total']; ?> students analyzed</span>
        </div>
    </div>
    <div class="block-content block-content-full">
        <?php if (count($predictions) > 0): ?>
        <!-- Risk Filter Tabs + Search -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="risk-filter-tabs" id="riskFilters">
                <button class="btn btn-sm btn-outline-secondary active" data-filter="all">
                    All <span class="badge bg-body-dark ms-1"><?php echo $summary['total']; ?></span>
                </button>
                <button class="btn btn-sm btn-outline-danger" data-filter="HIGH">
                    <i class="fa fa-exclamation-triangle me-1"></i>High <span class="badge bg-danger ms-1"><?php echo $summary['high']; ?></span>
                </button>
                <button class="btn btn-sm btn-outline-warning" data-filter="MEDIUM">
                    <i class="fa fa-exclamation-circle me-1"></i>Medium <span class="badge bg-warning text-dark ms-1"><?php echo $summary['medium']; ?></span>
                </button>
                <button class="btn btn-sm btn-outline-success" data-filter="LOW">
                    <i class="fa fa-check-circle me-1"></i>Low <span class="badge bg-success ms-1"><?php echo $summary['low']; ?></span>
                </button>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <span class="position-absolute top-50 translate-middle-y" style="left: 10px; color: var(--bs-gray-500); pointer-events: none;"><i class="fa fa-search" style="font-size: 0.8rem;"></i></span>
                    <input type="text" id="predSearch" class="form-control form-control-sm" placeholder="Search student…" autocomplete="off"
                        style="padding-left: 30px; width: 200px; border-radius: 16px; font-size: 0.82rem; height: 32px;">
                </div>
                <div class="text-muted fs-sm" id="showingInfo"></div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-vcenter mb-0" id="predTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Student</th>
                        <th class="text-center">Current</th>
                        <th class="text-center" style="width: 180px;">Trend</th>
                        <th class="text-center">Predicted</th>
                        <th class="text-center">Risk</th>
                        <th class="text-center" style="width: 100px;">Weak Subjects</th>
                    </tr>
                </thead>
                <tbody id="predBody">
                    <?php foreach ($predictions as $i => $p): ?>
                    <tr class="risk-<?php echo strtolower($p['risk_level']); ?> pred-row" data-risk="<?php echo $p['risk_level']; ?>" data-idx="<?php echo $i; ?>">
                        <td class="fw-bold pred-rownum"><?php echo $i + 1; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fa <?php echo $p['gender'] == 'Male' ? 'fa-mars text-primary' : 'fa-venus text-pink'; ?> me-2"></i>
                                <div>
                                    <span class="fw-semibold"><?php echo htmlspecialchars($p['name']); ?></span>
                                    <div class="fs-xs text-muted"><?php echo htmlspecialchars($p['reg_no']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold"><?php echo $p['current_avg']; ?>%</span>
                        </td>
                        <td>
                            <div class="trend-cell">
                                <?php
                                if ($p['trend'] === 'improving') {
                                    echo '<span class="trend-arrow trend-improving" title="Improving"><i class="fa fa-arrow-trend-up"></i></span>';
                                    echo '<span class="fs-sm text-success fw-semibold">+' . abs($p['trend_change']) . '%</span>';
                                } elseif ($p['trend'] === 'declining') {
                                    echo '<span class="trend-arrow trend-declining" title="Declining"><i class="fa fa-arrow-trend-down"></i></span>';
                                    echo '<span class="fs-sm text-danger fw-semibold">-' . abs($p['trend_change']) . '%</span>';
                                } else {
                                    echo '<span class="trend-arrow trend-stable" title="Stable"><i class="fa fa-arrows-left-right"></i></span>';
                                    echo '<span class="fs-sm text-muted">±' . abs($p['trend_change']) . '%</span>';
                                }
                                ?>
                                <div class="sparkline-container">
                                    <canvas id="spark_<?php echo $i; ?>" width="120" height="35"></canvas>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="fs-5 fw-bold <?php echo $p['predicted_score'] >= 50 ? 'text-success' : 'text-danger'; ?>">
                                <?php echo $p['predicted_score']; ?>%
                            </span>
                            <div class="confidence-bar mx-auto mt-1" style="width: 50px;" title="Confidence: <?php echo $p['confidence']; ?>%">
                                <div class="confidence-fill" style="width: <?php echo $p['confidence']; ?>%; background: <?php 
                                    echo $p['confidence'] >= 70 ? 'var(--bs-success)' : ($p['confidence'] >= 50 ? 'var(--bs-warning)' : 'var(--bs-danger)'); 
                                ?>;"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge risk-badge-<?php echo strtolower($p['risk_level']); ?> px-2 py-1">
                                <?php 
                                if ($p['risk_level'] === 'HIGH') echo '<i class="fa fa-exclamation-triangle me-1"></i>';
                                elseif ($p['risk_level'] === 'MEDIUM') echo '<i class="fa fa-exclamation-circle me-1"></i>';
                                else echo '<i class="fa fa-check-circle me-1"></i>';
                                echo $p['risk_level']; 
                                ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php $fc = count($p['failing_subjects']); ?>
                            <?php if ($fc > 0): ?>
                            <span class="fail-count-badge" onclick="togglePopover(this)">
                                <i class="fa fa-triangle-exclamation"></i> <?php echo $fc; ?>
                                <div class="fail-popover">
                                    <div class="fw-bold mb-1" style="color:var(--bs-body-color); border-bottom:1px solid var(--bs-gray-200); padding-bottom:4px;">Failing Subjects</div>
                                    <?php foreach ($p['failing_subjects'] as $fs): ?>
                                    <div class="fp-row">
                                        <span class="fp-subject"><?php echo htmlspecialchars($fs['subject']); ?></span>
                                        <span class="fp-score"><?php echo $fs['score']; ?>%</span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </span>
                            <?php else: ?>
                                <span class="text-success fs-sm"><i class="fa fa-check"></i></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="pred-pagination" id="predPagination"></div>
        <?php else: ?>
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <div class="flex-shrink-0"><i class="fa fa-fw fa-info-circle"></i></div>
            <div class="flex-grow-1 ms-3"><p class="mb-0">No examination results data found for the selected class and assessment. Import results first to generate predictions.</p></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Student Detail Modal -->
<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div id="sdmHeader" class="sdm-header"></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Metric Cards -->
                <div id="sdmMetrics" class="sdm-metrics"></div>

                <!-- Trend Chart -->
                <div class="sdm-section-title"><i class="fa fa-chart-line"></i> Performance Trend</div>
                <div class="sdm-chart-wrap">
                    <canvas id="sdmChart"></canvas>
                </div>

                <!-- Term History Table -->
                <div class="sdm-section-title"><i class="fa fa-table"></i> Term-by-Term History</div>
                <div class="table-responsive mb-3">
                    <table class="sdm-term-table" id="sdmTermTable">
                        <thead><tr><th>Term</th><th class="text-center">Average</th><th class="text-center">Change</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Failing Subjects -->
                <div id="sdmFailWrap" style="display:none;">
                    <div class="sdm-section-title"><i class="fa fa-triangle-exclamation text-danger"></i> Weak Subjects (Below 50%)</div>
                    <div class="sdm-fail-list" id="sdmFailList"></div>
                </div>

                <!-- AI Recommendation -->
                <div id="sdmRecommendation" class="sdm-recommendation"></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Algorithm Explanation -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title"><i class="fa fa-lightbulb me-1"></i> How the Prediction Works</h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0"><span class="badge bg-primary rounded-pill px-3 py-2 me-3">1</span></div>
                    <div>
                        <h6 class="fw-bold mb-1">Data Collection</h6>
                        <p class="text-muted fs-sm mb-0">Gathers each student's exam scores across all available terms to build a performance history timeline.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0"><span class="badge bg-primary rounded-pill px-3 py-2 me-3">2</span></div>
                    <div>
                        <h6 class="fw-bold mb-1">Linear Regression + WMA</h6>
                        <p class="text-muted fs-sm mb-0">Applies a blended model: 60% least-squares linear regression + 40% weighted moving average for robust prediction.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0"><span class="badge bg-primary rounded-pill px-3 py-2 me-3">3</span></div>
                    <div>
                        <h6 class="fw-bold mb-1">Risk Assessment</h6>
                        <p class="text-muted fs-sm mb-0">Classifies students as HIGH / MEDIUM / LOW risk based on predicted scores, trend direction, and sudden performance drops.</p>
                    </div>
                </div>
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
// ─── Popover toggle ───
function togglePopover(el) {
    event.stopPropagation();
    // Close any other open popovers
    document.querySelectorAll('.fail-popover').forEach(function(p) {
        if (p.parentElement !== el) p.style.display = 'none';
    });
    var pop = el.querySelector('.fail-popover');
    pop.style.display = pop.style.display === 'block' ? 'none' : 'block';
}
// Close popovers on outside click
document.addEventListener('click', function() {
    document.querySelectorAll('.fail-popover').forEach(function(p) { p.style.display = 'none'; });
});

document.addEventListener('DOMContentLoaded', function() {
    const predictions = <?php echo json_encode($predictions); ?>;
    const PER_PAGE = 15;
    let currentFilter = 'all';
    let currentPage = 1;
    let searchTerm = '';

    const allRows = Array.from(document.querySelectorAll('#predBody .pred-row'));
    const pagination = document.getElementById('predPagination');
    const showingInfo = document.getElementById('showingInfo');
    const predSearchInput = document.getElementById('predSearch');

    // ─── Search input handler ───
    if (predSearchInput) {
        predSearchInput.addEventListener('input', function() {
            searchTerm = this.value.trim().toLowerCase();
            currentPage = 1;
            render();
        });
    }

    // ─── Filter by risk level + search term ───
    function getFilteredRows() {
        var rows = allRows;
        if (currentFilter !== 'all') {
            rows = rows.filter(r => r.dataset.risk === currentFilter);
        }
        if (searchTerm.length > 0) {
            rows = rows.filter(function(r) {
                var idx = parseInt(r.dataset.idx);
                var p = predictions[idx];
                if (!p) return false;
                var haystack = (p.name + ' ' + p.reg_no).toLowerCase();
                return haystack.indexOf(searchTerm) !== -1;
            });
        }
        return rows;
    }

    function render() {
        var filtered = getFilteredRows();
        var totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;
        var start = (currentPage - 1) * PER_PAGE;
        var end = start + PER_PAGE;
        var visible = filtered.slice(start, end);

        // Hide all, show visible
        allRows.forEach(function(r) { r.style.display = 'none'; });
        visible.forEach(function(r, i) {
            r.style.display = '';
            r.querySelector('.pred-rownum').textContent = start + i + 1;
        });

        // Info text
        showingInfo.textContent = 'Showing ' + (filtered.length ? start + 1 : 0) + '–' + Math.min(end, filtered.length) + ' of ' + filtered.length + ' students';

        // Draw sparklines for visible rows
        visible.forEach(function(r) {
            var idx = parseInt(r.dataset.idx);
            drawSparkline(idx);
        });

        // Build pagination
        buildPagination(totalPages);
    }

    function buildPagination(totalPages) {
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        var prev = document.createElement('button');
        prev.className = 'page-btn';
        prev.innerHTML = '<i class="fa fa-chevron-left"></i>';
        prev.disabled = currentPage === 1;
        prev.onclick = function() { currentPage--; render(); };
        pagination.appendChild(prev);

        // Page numbers (show max 7)
        var startP = Math.max(1, currentPage - 3);
        var endP = Math.min(totalPages, startP + 6);
        if (endP - startP < 6) startP = Math.max(1, endP - 6);

        for (var p = startP; p <= endP; p++) {
            (function(pg) {
                var btn = document.createElement('button');
                btn.className = 'page-btn' + (pg === currentPage ? ' active' : '');
                btn.textContent = pg;
                btn.onclick = function() { currentPage = pg; render(); };
                pagination.appendChild(btn);
            })(p);
        }

        // Next
        var next = document.createElement('button');
        next.className = 'page-btn';
        next.innerHTML = '<i class="fa fa-chevron-right"></i>';
        next.disabled = currentPage === totalPages;
        next.onclick = function() { currentPage++; render(); };
        pagination.appendChild(next);
    }

    // ─── Filter tab clicks ───
    document.querySelectorAll('#riskFilters .btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#riskFilters .btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            currentPage = 1;
            render();
        });
    });

    // ─── Sparkline drawing (cached) ───
    var drawnSparks = {};
    function drawSparkline(idx) {
        if (drawnSparks[idx]) return;
        var canvas = document.getElementById('spark_' + idx);
        if (!canvas) return;
        var p = predictions[idx];
        if (!p || !p.term_history || p.term_history.length < 1) return;

        var scores = p.term_history.map(function(t) { return t.average; });
        var labels = p.term_history.map(function(t) { return t.term_name; });
        labels.push('Predicted');

        var actualData = scores.concat([null]);
        var predLine = new Array(scores.length - 1).fill(null);
        predLine.push(scores[scores.length - 1]);
        predLine.push(p.predicted_score);

        var trendColor = p.trend === 'improving' ? '#6f9c40' : (p.trend === 'declining' ? '#e04f1a' : '#e69f17');

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { data: actualData, borderColor: trendColor, borderWidth: 2, pointRadius: 2, pointBackgroundColor: trendColor, fill: false, tension: 0.3 },
                    { data: predLine, borderColor: trendColor, borderWidth: 2, borderDash: [4, 4], pointRadius: 3, pointBackgroundColor: '#fff', pointBorderColor: trendColor, pointBorderWidth: 2, fill: false, tension: 0.3 }
                ]
            },
            options: {
                responsive: false, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: true, mode: 'index' } },
                scales: { x: { display: false }, y: { display: false, min: 0, max: 100 } },
                animation: { duration: 400 }
            }
        });
        drawnSparks[idx] = true;
    }

    // Initial render
    render();

    // ─── Student Detail Modal ───
    var sdmChartInstance = null;
    var sdmModal = new bootstrap.Modal(document.getElementById('studentDetailModal'));

    // Click handler on rows
    document.getElementById('predBody').addEventListener('click', function(e) {
        var row = e.target.closest('.pred-row');
        if (!row) return;
        // Don't open if clicking on the fail-count-badge popover
        if (e.target.closest('.fail-count-badge')) return;
        var idx = parseInt(row.dataset.idx);
        openStudentDetail(idx);
    });

    function openStudentDetail(idx) {
        var p = predictions[idx];
        if (!p) return;

        // ── Header ──
        var genderClass = p.gender === 'Male' ? 'male' : 'female';
        var genderIcon = p.gender === 'Male' ? 'fa-mars' : 'fa-venus';
        var riskClass = p.risk_level.toLowerCase();
        document.getElementById('sdmHeader').innerHTML =
            '<div class="sdm-avatar ' + genderClass + '"><i class="fa ' + genderIcon + '"></i></div>' +
            '<div>' +
                '<div class="sdm-name">' + escHtml(p.name) + ' <span class="badge risk-badge-' + riskClass + ' ms-2" style="font-size:0.7rem;vertical-align:middle;">' + p.risk_level + ' RISK</span></div>' +
                '<div class="sdm-reg"><i class="fa fa-id-card me-1"></i>' + escHtml(p.reg_no) + ' &middot; ' + p.gender + ' &middot; ' + p.terms_analyzed + ' terms analyzed</div>' +
            '</div>';

        // ── Metric Cards ──
        var trendIcon, trendColor, trendLabel;
        if (p.trend === 'improving') { trendIcon = 'fa-arrow-trend-up'; trendColor = '#6f9c40'; trendLabel = 'Improving'; }
        else if (p.trend === 'declining') { trendIcon = 'fa-arrow-trend-down'; trendColor = '#e04f1a'; trendLabel = 'Declining'; }
        else { trendIcon = 'fa-arrows-left-right'; trendColor = '#e69f17'; trendLabel = 'Stable'; }

        var confColor = p.confidence >= 70 ? '#6f9c40' : (p.confidence >= 50 ? '#e69f17' : '#e04f1a');

        document.getElementById('sdmMetrics').innerHTML =
            '<div class="sdm-metric-card"><div class="sdm-metric-val" style="color:#0665d0;">' + p.current_avg + '%</div><div class="sdm-metric-label">Current Average</div></div>' +
            '<div class="sdm-metric-card"><div class="sdm-metric-val" style="color:' + (p.predicted_score >= 50 ? '#6f9c40' : '#e04f1a') + ';">' + p.predicted_score + '%</div><div class="sdm-metric-label">Predicted Next</div></div>' +
            '<div class="sdm-metric-card"><div class="sdm-metric-val" style="color:' + trendColor + ';"><i class="fa ' + trendIcon + '"></i> ' + (p.trend_change >= 0 ? '+' : '') + p.trend_change + '%</div><div class="sdm-metric-label">' + trendLabel + '</div></div>' +
            '<div class="sdm-metric-card"><div class="sdm-metric-val" style="color:' + confColor + ';">' + p.confidence + '%</div><div class="sdm-metric-label">Confidence</div></div>';

        // ── Term History Table ──
        var tbody = document.querySelector('#sdmTermTable tbody');
        var rows = '';
        for (var t = 0; t < p.term_history.length; t++) {
            var th = p.term_history[t];
            var change = '';
            if (t > 0) {
                var diff = (th.average - p.term_history[t - 1].average).toFixed(1);
                var diffNum = parseFloat(diff);
                if (diffNum > 0) change = '<span class="text-success fw-semibold">+' + diff + '%</span>';
                else if (diffNum < 0) change = '<span class="text-danger fw-semibold">' + diff + '%</span>';
                else change = '<span class="text-muted">—</span>';
            } else {
                change = '<span class="text-muted">—</span>';
            }
            rows += '<tr><td><i class="fa fa-calendar-day me-1 text-muted"></i>' + escHtml(th.term_name) + '</td><td class="text-center fw-bold">' + th.average + '%</td><td class="text-center">' + change + '</td></tr>';
        }
        // Predicted row
        var predDiff = (p.predicted_score - p.term_history[p.term_history.length - 1].average).toFixed(1);
        var predDiffNum = parseFloat(predDiff);
        var predChange = '';
        if (predDiffNum > 0) predChange = '<span class="text-success fw-semibold">+' + predDiff + '%</span>';
        else if (predDiffNum < 0) predChange = '<span class="text-danger fw-semibold">' + predDiff + '%</span>';
        else predChange = '<span class="text-muted">—</span>';
        rows += '<tr class="predicted-row"><td><i class="fa fa-brain me-1 text-primary"></i>Predicted (Next Term)</td><td class="text-center fw-bold">' + p.predicted_score + '%</td><td class="text-center">' + predChange + '</td></tr>';
        tbody.innerHTML = rows;

        // ── Failing Subjects ──
        var failWrap = document.getElementById('sdmFailWrap');
        var failList = document.getElementById('sdmFailList');
        if (p.failing_subjects && p.failing_subjects.length > 0) {
            failWrap.style.display = 'block';
            var chips = '';
            for (var f = 0; f < p.failing_subjects.length; f++) {
                var fs = p.failing_subjects[f];
                chips += '<div class="sdm-fail-chip"><span class="fc-name">' + escHtml(fs.subject) + '</span><span class="fc-score">' + fs.score + '%</span></div>';
            }
            failList.innerHTML = chips;
        } else {
            failWrap.style.display = 'none';
        }

        // ── AI Recommendation ──
        var recDiv = document.getElementById('sdmRecommendation');
        var recIcon, recTitle, recText;
        if (p.risk_level === 'HIGH') {
            recIcon = '<i class="sdm-rec-icon text-danger fa fa-exclamation-triangle"></i>';
            recTitle = 'Urgent Intervention Required';
            recText = p.name.split(' ')[0] + '\'s performance is predicted at <b>' + p.predicted_score + '%</b>, which is below the passing threshold. ' +
                (p.trend === 'declining' ? 'With a <b>declining trend</b> of ' + Math.abs(p.trend_change) + '%, immediate action is needed. ' : '') +
                'Recommend scheduling a one-on-one consultation, providing targeted remedial work' +
                (p.failing_subjects.length > 0 ? ' especially in <b>' + p.failing_subjects.map(function(s) { return s.subject; }).join(', ') + '</b>' : '') +
                ', and involving parents/guardians in academic monitoring.';
            recDiv.className = 'sdm-recommendation rec-high';
        } else if (p.risk_level === 'MEDIUM') {
            recIcon = '<i class="sdm-rec-icon fa fa-exclamation-circle" style="color:#e69f17;"></i>';
            recTitle = 'Monitoring Recommended';
            recText = p.name.split(' ')[0] + '\'s predicted score of <b>' + p.predicted_score + '%</b> suggests potential to improve with guidance. ' +
                (p.trend === 'declining' ? 'The <b>declining trend</b> needs attention. ' : (p.trend === 'stable' ? 'Performance is <b>stable</b> but could be pushed higher. ' : 'The <b>improving trend</b> is encouraging. ')) +
                'Recommend regular check-ins, study group participation' +
                (p.failing_subjects.length > 0 ? ', and extra focus on <b>' + p.failing_subjects.map(function(s) { return s.subject; }).join(', ') + '</b>' : '') +
                ' to maintain and improve results.';
            recDiv.className = 'sdm-recommendation rec-medium';
        } else {
            recIcon = '<i class="sdm-rec-icon text-success fa fa-check-circle"></i>';
            recTitle = 'On Track — Keep It Up';
            recText = p.name.split(' ')[0] + ' is performing well with a predicted score of <b>' + p.predicted_score + '%</b>. ' +
                (p.trend === 'improving' ? 'The <b>upward trend</b> of +' + Math.abs(p.trend_change) + '% is excellent. ' : 'Performance is <b>consistent</b>. ') +
                'Encourage continued effort and consider enrichment opportunities or peer tutoring roles to maintain engagement.';
            recDiv.className = 'sdm-recommendation rec-low';
        }
        recDiv.innerHTML = recIcon + '<div><div class="sdm-rec-title">' + recTitle + '</div><div class="sdm-rec-text">' + recText + '</div></div>';

        // ── Draw Chart ──
        if (sdmChartInstance) { sdmChartInstance.destroy(); sdmChartInstance = null; }
        var canvas = document.getElementById('sdmChart');
        var scores = p.term_history.map(function(t) { return t.average; });
        var labels = p.term_history.map(function(t) { return t.term_name; });
        labels.push('Predicted');

        var actualData = scores.concat([null]);
        var predLine = new Array(scores.length - 1).fill(null);
        predLine.push(scores[scores.length - 1]);
        predLine.push(p.predicted_score);

        var mainColor = p.trend === 'improving' ? '#6f9c40' : (p.trend === 'declining' ? '#e04f1a' : '#e69f17');
        var bgGradient = canvas.getContext('2d').createLinearGradient(0, 0, 0, 200);
        bgGradient.addColorStop(0, mainColor + '30');
        bgGradient.addColorStop(1, mainColor + '05');

        sdmChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Actual Score',
                        data: actualData,
                        borderColor: mainColor,
                        borderWidth: 3,
                        pointRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: mainColor,
                        pointBorderWidth: 3,
                        pointHoverRadius: 8,
                        fill: true,
                        backgroundColor: bgGradient,
                        tension: 0.3
                    },
                    {
                        label: 'Predicted',
                        data: predLine,
                        borderColor: mainColor,
                        borderWidth: 3,
                        borderDash: [8, 4],
                        pointRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: mainColor,
                        pointBorderWidth: 3,
                        pointStyle: 'rectRounded',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } },
                    tooltip: {
                        backgroundColor: '#343a40',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) { return ctx.dataset.label + ': ' + ctx.parsed.y + '%'; }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: {
                        min: 0, max: 100,
                        grid: { color: '#edf0f7' },
                        ticks: { callback: function(v) { return v + '%'; }, font: { size: 11 } }
                    }
                },
                animation: { duration: 500 }
            }
        });

        sdmModal.show();
    }

    function escHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }
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
