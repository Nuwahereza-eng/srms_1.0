<?php
require_once 'models/results_serial_numbers_model.php';
class results_serial_numbers_controller {
    private $model;
    public function __construct() {
        $this->model = new results_serial_numbers_model();
    }

    public function show($reg, $class, $term) {
        return $this->model->get($reg, $class, $term);
    }

    public function verify($serial) {
        return $this->model->retrieve($serial);
    }

    public function store($reg, $class, $term, $serial) {
        return $this->model->insert($reg, $class, $term, $serial);
    }

}
?>
