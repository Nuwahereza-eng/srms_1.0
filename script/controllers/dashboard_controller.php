<?php
require_once 'models/dashboard_model.php';
class dashboard_controller {
    private $model;
    public function __construct() {
        $this->model = new dashboard_model();
    }

    public function programmes() {
        return $this->model->programmes();
    }

    public function subjects() {
        return $this->model->subjects();
    }

    public function classes() {
        return $this->model->classes();
    }

    public function students() {
        return $this->model->students();
    }

    public function teachers() {
        return $this->model->teachers();
    }

    public function ca() {
        return $this->model->ca();
    }

    public function gs() {
        return $this->model->gs();
    }

    public function ds() {
        return $this->model->ds();
    }

    public function my_subjects($id) {
        return $this->model->my_subjects($id);
    }

    public function my_classes($id) {
        return $this->model->my_classes($id);
    }

    public function my_students($id) {
        return $this->model->my_students($id);
    }
}
?>
