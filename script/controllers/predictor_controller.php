<?php
require_once 'models/predictor_model.php';
class predictor_controller {
    private $model;
    public function __construct() {
        $this->model = new predictor_model();
    }

    public function predict_class_performance($class_id, $ca) {
        return $this->model->predict_class_performance($class_id, $ca);
    }

    public function class_prediction_summary($predictions) {
        return $this->model->class_prediction_summary($predictions);
    }

    public function get_classes() {
        return $this->model->get_classes();
    }

    public function get_cas() {
        return $this->model->get_cas();
    }

    public function predict_student_performance($reg_no, $class_id) {
        return $this->model->predict_student_performance($reg_no, $class_id);
    }
}
?>
