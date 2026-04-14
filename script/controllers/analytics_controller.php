<?php
require_once 'models/analytics_model.php';
class analytics_controller {
    private $model;
    public function __construct() {
        $this->model = new analytics_model();
    }

    public function subject_averages($class_id, $term, $ca) {
        return $this->model->subject_averages($class_id, $term, $ca);
    }

    public function term_trends($class_id, $ca) {
        return $this->model->term_trends($class_id, $ca);
    }

    public function gender_analysis($class_id, $term, $ca) {
        return $this->model->gender_analysis($class_id, $term, $ca);
    }

    public function grade_distribution($class_id, $term, $ca) {
        return $this->model->grade_distribution($class_id, $term, $ca);
    }

    public function top_students($class_id, $term, $ca, $limit = 10) {
        return $this->model->top_students($class_id, $term, $ca, $limit);
    }

    public function class_comparison($term, $ca) {
        return $this->model->class_comparison($term, $ca);
    }

    public function overview_stats() {
        return $this->model->overview_stats();
    }

    public function get_classes() {
        return $this->model->get_classes();
    }

    public function get_all_terms() {
        return $this->model->get_all_terms();
    }

    public function get_cas() {
        return $this->model->get_cas();
    }
}
?>
