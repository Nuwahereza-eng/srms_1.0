<?php
class analytics_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    /**
     * Get average score per subject for a given class and term
     */
    public function subject_averages($class_id, $term, $ca) {
        $stmt = $this->db->prepare("SELECT er.id, er.results, er.reg_no FROM examination_results er WHERE er.class_id = ? AND er.term = ? AND er.ca = ?");
        $stmt->execute([$class_id, $term, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get subjects for this class
        $subjects = $this->get_class_subjects($class_id);
        $subject_totals = [];
        $subject_counts = [];

        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            foreach ($results as $sub_id => $score) {
                if (!isset($subject_totals[$sub_id])) {
                    $subject_totals[$sub_id] = 0;
                    $subject_counts[$sub_id] = 0;
                }
                $subject_totals[$sub_id] += floatval($score);
                $subject_counts[$sub_id]++;
            }
        }

        $averages = [];
        foreach ($subject_totals as $sub_id => $total) {
            $sub_name = isset($subjects[$sub_id]) ? $subjects[$sub_id] : "Subject #$sub_id";
            $averages[] = [
                'subject_id' => $sub_id,
                'subject_name' => $sub_name,
                'average' => round($total / $subject_counts[$sub_id], 2),
                'students_count' => $subject_counts[$sub_id]
            ];
        }

        usort($averages, function($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        return $averages;
    }

    /**
     * Get performance trends across terms for a class
     */
    public function term_trends($class_id, $ca) {
        $stmt = $this->db->prepare("SELECT er.term, er.results FROM examination_results er WHERE er.class_id = ? AND er.ca = ? ORDER BY er.term ASC");
        $stmt->execute([$class_id, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get term names
        $terms = $this->get_terms();

        $term_data = [];
        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            $total = 0;
            $count = 0;
            foreach ($results as $score) {
                $total += floatval($score);
                $count++;
            }
            $avg = $count > 0 ? $total / $count : 0;
            $tid = $row['term'];
            if (!isset($term_data[$tid])) {
                $term_data[$tid] = ['sum' => 0, 'count' => 0];
            }
            $term_data[$tid]['sum'] += $avg;
            $term_data[$tid]['count']++;
        }

        $trends = [];
        foreach ($term_data as $tid => $data) {
            $trends[] = [
                'term_id' => $tid,
                'term_name' => isset($terms[$tid]) ? $terms[$tid] : "Term #$tid",
                'average' => round($data['sum'] / $data['count'], 2),
                'students' => $data['count']
            ];
        }

        return $trends;
    }

    /**
     * Get gender-based performance comparison for a class
     */
    public function gender_analysis($class_id, $term, $ca) {
        $stmt = $this->db->prepare(
            "SELECT s.gender, er.results 
             FROM examination_results er 
             JOIN students s ON er.reg_no = s.reg_no 
             WHERE er.class_id = ? AND er.term = ? AND er.ca = ?"
        );
        $stmt->execute([$class_id, $term, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $gender_data = ['Male' => ['total' => 0, 'count' => 0], 'Female' => ['total' => 0, 'count' => 0]];

        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            $student_total = 0;
            $sub_count = 0;
            foreach ($results as $score) {
                $student_total += floatval($score);
                $sub_count++;
            }
            $avg = $sub_count > 0 ? $student_total / $sub_count : 0;
            $g = $row['gender'];
            if (isset($gender_data[$g])) {
                $gender_data[$g]['total'] += $avg;
                $gender_data[$g]['count']++;
            }
        }

        $result = [];
        foreach ($gender_data as $gender => $data) {
            $result[] = [
                'gender' => $gender,
                'average' => $data['count'] > 0 ? round($data['total'] / $data['count'], 2) : 0,
                'students' => $data['count']
            ];
        }

        return $result;
    }

    /**
     * Get class-wide performance distribution (grade buckets)
     */
    public function grade_distribution($class_id, $term, $ca) {
        $stmt = $this->db->prepare("SELECT er.results FROM examination_results er WHERE er.class_id = ? AND er.term = ? AND er.ca = ?");
        $stmt->execute([$class_id, $term, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $buckets = [
            '90-100 (Excellent)' => 0,
            '80-89 (Very Good)' => 0,
            '70-79 (Good)' => 0,
            '60-69 (Credit)' => 0,
            '50-59 (Pass)' => 0,
            '0-49 (Fail)' => 0
        ];

        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            foreach ($results as $score) {
                $s = floatval($score);
                if ($s >= 90) $buckets['90-100 (Excellent)']++;
                elseif ($s >= 80) $buckets['80-89 (Very Good)']++;
                elseif ($s >= 70) $buckets['70-79 (Good)']++;
                elseif ($s >= 60) $buckets['60-69 (Credit)']++;
                elseif ($s >= 50) $buckets['50-59 (Pass)']++;
                else $buckets['0-49 (Fail)']++;
            }
        }

        return $buckets;
    }

    /**
     * Get top N students in a class for a given term
     */
    public function top_students($class_id, $term, $ca, $limit = 10) {
        $stmt = $this->db->prepare(
            "SELECT er.reg_no, er.results, s.first_name, s.last_name, s.gender 
             FROM examination_results er 
             JOIN students s ON er.reg_no = s.reg_no 
             WHERE er.class_id = ? AND er.term = ? AND er.ca = ?"
        );
        $stmt->execute([$class_id, $term, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $students = [];
        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            $total = 0;
            $count = 0;
            foreach ($results as $score) {
                $total += floatval($score);
                $count++;
            }
            $students[] = [
                'reg_no' => $row['reg_no'],
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'gender' => $row['gender'],
                'total' => round($total, 2),
                'average' => $count > 0 ? round($total / $count, 2) : 0,
                'subjects' => $count
            ];
        }

        usort($students, function($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        return array_slice($students, 0, $limit);
    }

    /**
     * Compare performance across all classes for a term
     */
    public function class_comparison($term, $ca) {
        $stmt = $this->db->prepare(
            "SELECT er.class_id, c.name as class_name, er.results 
             FROM examination_results er 
             JOIN classes c ON er.class_id = c.id 
             WHERE er.term = ? AND er.ca = ?"
        );
        $stmt->execute([$term, $ca]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $class_data = [];
        foreach ($rows as $row) {
            $results = @unserialize($row['results']);
            if (!is_array($results)) continue;
            $total = 0;
            $count = 0;
            foreach ($results as $score) {
                $total += floatval($score);
                $count++;
            }
            $avg = $count > 0 ? $total / $count : 0;
            $cid = $row['class_id'];
            if (!isset($class_data[$cid])) {
                $class_data[$cid] = ['name' => $row['class_name'], 'sum' => 0, 'count' => 0];
            }
            $class_data[$cid]['sum'] += $avg;
            $class_data[$cid]['count']++;
        }

        $result = [];
        foreach ($class_data as $cid => $data) {
            $result[] = [
                'class_id' => $cid,
                'class_name' => $data['name'],
                'average' => round($data['sum'] / $data['count'], 2),
                'students' => $data['count']
            ];
        }

        usort($result, function($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        return $result;
    }

    /**
     * Get overview statistics
     */
    public function overview_stats() {
        $total_results = $this->db->query("SELECT COUNT(*) as total FROM examination_results")->fetch(PDO::FETCH_ASSOC);
        $total_students = $this->db->query("SELECT COUNT(DISTINCT reg_no) as total FROM examination_results")->fetch(PDO::FETCH_ASSOC);
        $total_classes = $this->db->query("SELECT COUNT(DISTINCT class_id) as total FROM examination_results")->fetch(PDO::FETCH_ASSOC);

        return [
            'total_results' => $total_results['total'],
            'total_students' => $total_students['total'],
            'total_classes' => $total_classes['total']
        ];
    }

    /**
     * Helper: get subjects keyed by id
     */
    private function get_class_subjects($class_id) {
        $stmt = $this->db->prepare(
            "SELECT s.id, s.name as subject FROM subjects s 
             JOIN subject_combinations sc ON s.id = sc.subject_id 
             WHERE sc.class_id = ?"
        );
        $stmt->execute([$class_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id']] = $r['subject'];
        }
        return $map;
    }

    /**
     * Helper: get all terms keyed by id
     */
    private function get_terms() {
        $rows = $this->db->query("SELECT id, name as term FROM academic_terms ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id']] = $r['term'];
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
     * Get all terms
     */
    public function get_all_terms() {
        return $this->db->query("SELECT id, name as term FROM academic_terms ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all CAs
     */
    public function get_cas() {
        return $this->db->query("SELECT id, name as assessment FROM continuous_assessments ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
