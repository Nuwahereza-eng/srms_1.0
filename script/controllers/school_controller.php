<?php
require_once 'models/school_model.php';
class school_controller {
    private $model;
    public function __construct() {
        $this->model = new school_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function update($data) {
        return $this->model->update($data);
    }

}
?>
