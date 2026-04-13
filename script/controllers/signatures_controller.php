<?php
require_once 'models/signatures_model.php';
class signatures_controller {
    private $model;
    public function __construct() {
        $this->model = new signatures_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function update($data) {
        return $this->model->update($data);
    }
}
?>
