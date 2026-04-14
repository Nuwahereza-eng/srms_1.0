<?php
class predictor_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    /**
     * Analyze all students in a class and predict future performance.
     * Uses weighted moving average + linear regression on historical term data.
     * Returns array of students with trend, predicted score, risk level.
     */
    public function predict_class_performance($class_id, $ca) {
        // Get all students in the class
        $stmt = $this->db->prepare(
            "SELECT DISTINCT er.reg_no, s.first_name, s.last_name, s.gender 
             FROM examination_results er 
             JOIN students s ON er.reg_no = s.reg_no 
             WHERE er.class_id = ? AND er.ca = ?
             ORDER BY s.first_name, s.last_name"
        );
        $stmt->execute([$class_id, $ca]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get all terms ordered
        $terms = $this->db->query("SELECT id, name as term FROM academic_terms ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $term_ids = array_column($terms, 'id');
        $term_map = [];
        foreach ($terms as $t) {
            $term_map[$t['id']] = $t['term'];
        }

        $predictions = [];

        foreach ($students as $student) {
            $reg_no = $student['reg_no'];

            // Get all results for this student in this class across terms
            $stmt2 = $this->db->prepare(
                "SELECT er.term, er.results FROM examination_results er 
                 WHERE er.reg_no = ? AND er.class_id = ? AND er.ca = ? 
                 ORDER BY er.term ASC"
            );
            $stmt2->execute([$reg_no, $class_id, $ca]);
            $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // Calculate average per term
            $term_averages = [];
            foreach ($results as $row) {
                $data = @unserialize($row['results']);
                if (!is_array($data) || empty($data)) continue;
                $total = 0;
                $count = 0;
                foreach ($data as $score) {
                    $total += floatval($score);
                    $count++;
                }
                if ($count > 0) {
                    $term_averages[] = [
                        'term_id' => $row['term'],
                        'term_name' => isset($term_map[$row['term']]) ? $term_map[$row['term']] : 'Term '.$row['term'],
                        'average' => round($total / $count, 2)
                    ];
                }
            }

            if (empty($term_averages)) continue;

            $scores = array_column($term_averages, 'average');
            $latest_score = end($scores);
            $num_terms = count($scores);

            // Compute trend
            $trend = 'stable';
            $trend_value = 0;
            if ($num_terms >= 2) {
                $trend_value = $scores[$num_terms - 1] - $scores[$num_terms - 2];
                if ($trend_value > 3) $trend = 'improving';
                elseif ($trend_value < -3) $trend = 'declining';
                else $trend = 'stable';
            }

            // Predict next term score using linear regression
            $predicted_score = $this->linear_regression_predict($scores);

            // Clamp to 0-100
            $predicted_score = max(0, min(100, round($predicted_score, 2)));

            // Weighted Moving Average as alternative (gives more recent terms higher weight)
            $wma_score = $this->weighted_moving_average($scores);
            $wma_score = max(0, min(100, round($wma_score, 2)));

            // Blended prediction (60% linear regression, 40% WMA)
            $blended = round(0.6 * $predicted_score + 0.4 * $wma_score, 2);
            $blended = max(0, min(100, $blended));

            // Risk assessment
            $risk_level = $this->assess_risk($blended, $trend, $scores);

            // Confidence level (more data = higher confidence)
            $confidence = $this->calculate_confidence($scores);

            // Subject-level analysis for this student (latest term)
            $latest_results = @unserialize(end($results)['results']);
            $subject_risks = [];
            if (is_array($latest_results)) {
                $subjects = $this->get_subjects();
                foreach ($latest_results as $sub_id => $score) {
                    $s = floatval($score);
                    if ($s < 50) {
                        $sub_name = isset($subjects[$sub_id]) ? $subjects[$sub_id] : "Subject #$sub_id";
                        $subject_risks[] = ['subject' => $sub_name, 'score' => $s];
                    }
                }
            }

            $predictions[] = [
                'reg_no' => $reg_no,
                'name' => $student['first_name'] . ' ' . $student['last_name'],
                'gender' => $student['gender'],
                'current_avg' => $latest_score,
                'term_history' => $term_averages,
                'trend' => $trend,
                'trend_change' => round($trend_value, 2),
                'predicted_score' => $blended,
                'risk_level' => $risk_level,
                'confidence' => $confidence,
                'failing_subjects' => $subject_risks,
                'terms_analyzed' => $num_terms
            ];
        }

        // Sort by risk level (HIGH first, then MEDIUM, then LOW)
        $risk_order = ['HIGH' => 0, 'MEDIUM' => 1, 'LOW' => 2];
        usort($predictions, function($a, $b) use ($risk_order) {
            $ra = $risk_order[$a['risk_level']] ?? 3;
            $rb = $risk_order[$b['risk_level']] ?? 3;
            if ($ra === $rb) return $a['predicted_score'] <=> $b['predicted_score'];
            return $ra <=> $rb;
        });

        return $predictions;
    }

    /**
     * Linear Regression: predict next value in sequence
     * Uses least squares method: y = mx + b
     */
    private function linear_regression_predict($scores) {
        $n = count($scores);
        if ($n == 0) return 0;
        if ($n == 1) return $scores[0];

        $sum_x = 0; $sum_y = 0; $sum_xy = 0; $sum_x2 = 0;
        for ($i = 0; $i < $n; $i++) {
            $x = $i + 1;
            $y = $scores[$i];
            $sum_x += $x;
            $sum_y += $y;
            $sum_xy += $x * $y;
            $sum_x2 += $x * $x;
        }

        $denominator = ($n * $sum_x2 - $sum_x * $sum_x);
        if ($denominator == 0) return end($scores);

        $m = ($n * $sum_xy - $sum_x * $sum_y) / $denominator;
        $b = ($sum_y - $m * $sum_x) / $n;

        // Predict for next term (x = n + 1)
        return $m * ($n + 1) + $b;
    }

    /**
     * Weighted Moving Average: recent terms get higher weight
     */
    private function weighted_moving_average($scores) {
        $n = count($scores);
        if ($n == 0) return 0;
        if ($n == 1) return $scores[0];

        $total_weight = 0;
        $weighted_sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $weight = $i + 1; // older=1, newest=n
            $weighted_sum += $scores[$i] * $weight;
            $total_weight += $weight;
        }

        return $weighted_sum / $total_weight;
    }

    /**
     * Assess risk level based on predicted score, trend, and history
     */
    private function assess_risk($predicted, $trend, $history) {
        // High risk: predicted below 50 OR declining with score below 60
        if ($predicted < 45) return 'HIGH';
        if ($predicted < 50 && $trend === 'declining') return 'HIGH';

        // Medium risk: predicted 50-60 OR declining from good scores
        if ($predicted < 55) return 'MEDIUM';
        if ($predicted < 65 && $trend === 'declining') return 'MEDIUM';

        // Check for sudden drops
        $n = count($history);
        if ($n >= 2) {
            $drop = $history[$n - 2] - $history[$n - 1];
            if ($drop > 15) return 'MEDIUM'; // Sudden large drop
        }

        return 'LOW';
    }

    /**
     * Calculate prediction confidence (0-100%)
     */
    private function calculate_confidence($scores) {
        $n = count($scores);
        if ($n <= 1) return 30; // Low confidence with 1 data point
        if ($n == 2) return 55;
        if ($n == 3) return 70;
        if ($n >= 4) return 85;
        return 50;
    }

    /**
     * Get class-level summary statistics for predictions
     */
    public function class_prediction_summary($predictions) {
        $total = count($predictions);
        if ($total == 0) return ['high' => 0, 'medium' => 0, 'low' => 0, 'avg_predicted' => 0, 'total' => 0];

        $high = 0; $medium = 0; $low = 0;
        $sum_predicted = 0;
        $improving = 0; $declining = 0; $stable = 0;

        foreach ($predictions as $p) {
            if ($p['risk_level'] === 'HIGH') $high++;
            elseif ($p['risk_level'] === 'MEDIUM') $medium++;
            else $low++;

            $sum_predicted += $p['predicted_score'];

            if ($p['trend'] === 'improving') $improving++;
            elseif ($p['trend'] === 'declining') $declining++;
            else $stable++;
        }

        return [
            'total' => $total,
            'high' => $high,
            'medium' => $medium,
            'low' => $low,
            'avg_predicted' => round($sum_predicted / $total, 2),
            'improving' => $improving,
            'declining' => $declining,
            'stable' => $stable
        ];
    }

    /**
     * Get all subjects keyed by id
     */
    private function get_subjects() {
        $rows = $this->db->query("SELECT id, name as subject FROM subjects")->fetchAll(PDO::FETCH_ASSOC);
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id']] = $r['subject'];
        }
        return $map;
    }

    /**
     * Get all classes
     */
    public function get_classes() {
        return $this->db->query("SELECT id, name as class FROM classes ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all CAs
     */
    public function get_cas() {
        return $this->db->query("SELECT id, name as assessment FROM continuous_assessments ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Predict performance for a single student across all their CAs/terms.
     * Returns term history, predicted score, risk, trend, failing subjects, per-subject trends.
     */
    public function predict_student_performance($reg_no, $class_id) {
        $terms = $this->db->query("SELECT id, name as term FROM academic_terms ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $term_map = [];
        foreach ($terms as $t) $term_map[$t['id']] = $t['term'];

        $subjects = $this->get_subjects();

        // Get ALL results for this student in this class (all CAs combined per term)
        $stmt = $this->db->prepare(
            "SELECT er.term, er.ca, er.results FROM examination_results er
             WHERE er.reg_no = ? AND er.class_id = ?
             ORDER BY er.term ASC, er.ca ASC"
        );
        $stmt->execute([$reg_no, $class_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Aggregate scores per subject per term (sum all CAs)
        $term_subject_scores = []; // term_id => [sub_id => total]
        foreach ($rows as $row) {
            $data = @unserialize($row['results']);
            if (!is_array($data)) continue;
            $tid = $row['term'];
            if (!isset($term_subject_scores[$tid])) $term_subject_scores[$tid] = [];
            foreach ($data as $sub_id => $score) {
                if (!isset($term_subject_scores[$tid][$sub_id]))
                    $term_subject_scores[$tid][$sub_id] = 0;
                $term_subject_scores[$tid][$sub_id] += floatval($score);
            }
        }

        if (empty($term_subject_scores)) return null;

        // Compute overall average per term
        $term_averages = [];
        foreach ($term_subject_scores as $tid => $subs) {
            $vals = array_values($subs);
            $avg = count($vals) > 0 ? round(array_sum($vals) / count($vals), 2) : 0;
            $term_averages[] = [
                'term_id' => $tid,
                'term_name' => $term_map[$tid] ?? "Term $tid",
                'average' => $avg
            ];
        }

        $scores = array_column($term_averages, 'average');
        $latest_score = end($scores);
        $num_terms = count($scores);

        // Trend
        $trend = 'stable';
        $trend_value = 0;
        if ($num_terms >= 2) {
            $trend_value = $scores[$num_terms - 1] - $scores[$num_terms - 2];
            if ($trend_value > 3) $trend = 'improving';
            elseif ($trend_value < -3) $trend = 'declining';
        }

        // Prediction
        $lr = $this->linear_regression_predict($scores);
        $wma = $this->weighted_moving_average($scores);
        $predicted = max(0, min(100, round(0.6 * $lr + 0.4 * $wma, 2)));

        $risk_level = $this->assess_risk($predicted, $trend, $scores);
        $confidence = $this->calculate_confidence($scores);

        // Per-subject analysis across terms
        $subject_trends = []; // sub_id => [ [term_name, score], ... ]
        foreach ($term_subject_scores as $tid => $subs) {
            foreach ($subs as $sub_id => $total) {
                $subject_trends[$sub_id][] = [
                    'term_id' => $tid,
                    'term_name' => $term_map[$tid] ?? "Term $tid",
                    'score' => round($total, 2)
                ];
            }
        }

        // Latest term failing subjects
        $latest_tid = array_key_last($term_subject_scores);
        $failing_subjects = [];
        $subject_details = [];
        foreach ($term_subject_scores[$latest_tid] as $sub_id => $total) {
            $sub_name = $subjects[$sub_id] ?? "Subject #$sub_id";
            $score = round($total, 2);
            $subject_details[] = ['subject_id' => $sub_id, 'subject' => $sub_name, 'score' => $score];
            if ($score < 50) {
                $failing_subjects[] = ['subject' => $sub_name, 'score' => $score];
            }
        }

        // Sort subjects by score desc
        usort($subject_details, fn($a, $b) => $b['score'] <=> $a['score']);

        // Per-subject predictions
        $subject_predictions = [];
        foreach ($subject_trends as $sub_id => $entries) {
            $sub_scores = array_column($entries, 'score');
            $sub_pred = $this->linear_regression_predict($sub_scores);
            $sub_pred = max(0, min(100, round($sub_pred, 2)));
            $sub_name = $subjects[$sub_id] ?? "Subject #$sub_id";
            $sub_trend = 'stable';
            $n = count($sub_scores);
            if ($n >= 2) {
                $d = $sub_scores[$n-1] - $sub_scores[$n-2];
                if ($d > 3) $sub_trend = 'improving';
                elseif ($d < -3) $sub_trend = 'declining';
            }
            $subject_predictions[] = [
                'subject_id' => $sub_id,
                'subject' => $sub_name,
                'current' => end($sub_scores),
                'predicted' => $sub_pred,
                'trend' => $sub_trend,
                'history' => $entries
            ];
        }

        // AI recommendation
        $recommendation = $this->generate_student_recommendation($predicted, $trend, $risk_level, $failing_subjects, $subject_predictions);

        return [
            'current_avg' => $latest_score,
            'predicted_score' => $predicted,
            'risk_level' => $risk_level,
            'confidence' => $confidence,
            'trend' => $trend,
            'trend_change' => round($trend_value, 2),
            'term_history' => $term_averages,
            'terms_analyzed' => $num_terms,
            'subject_details' => $subject_details,
            'subject_predictions' => $subject_predictions,
            'failing_subjects' => $failing_subjects,
            'recommendation' => $recommendation
        ];
    }

    /**
     * Generate personalised recommendation for a student
     */
    private function generate_student_recommendation($predicted, $trend, $risk, $failing, $subject_preds) {
        $tips = [];

        if ($risk === 'HIGH') {
            $tips[] = "[ALERT] Immediate academic intervention is recommended. Consider arranging extra tutoring sessions and regular check-ins with teachers.";
        } elseif ($risk === 'MEDIUM') {
            $tips[] = "[NOTE] Moderate attention needed. Setting a consistent study timetable and targeting weak areas can turn things around.";
        } else {
            $tips[] = "[GOOD] Strong performance trajectory. Maintain the current study habits and aim to push into the top bracket.";
        }

        if ($trend === 'declining') {
            $tips[] = "[DECLINING] Performance has been dropping. Identifying distractions or difficult topics early will help reverse this trend.";
        } elseif ($trend === 'improving') {
            $tips[] = "[IMPROVING] Positive upward trend -- great effort! Keep the momentum and don't ease up before exams.";
        }

        if (!empty($failing)) {
            $names = array_map(fn($f) => $f['subject'], array_slice($failing, 0, 3));
            $tips[] = "[FAILING] At risk in: " . implode(', ', $names) . ". Prioritise these subjects in the study plan.";
        }

        // Find the subject with biggest predicted drop
        $biggest_drop = null;
        foreach ($subject_preds as $sp) {
            if ($sp['trend'] === 'declining') {
                $diff = $sp['current'] - $sp['predicted'];
                if ($biggest_drop === null || $diff > $biggest_drop['diff']) {
                    $biggest_drop = ['subject' => $sp['subject'], 'diff' => $diff];
                }
            }
        }
        if ($biggest_drop && $biggest_drop['diff'] > 5) {
            $tips[] = "[WATCH] " . $biggest_drop['subject'] . " is predicted to drop by " . round($biggest_drop['diff'], 1) . " marks -- consider focused revision.";
        }

        return $tips;
    }
}
?>
