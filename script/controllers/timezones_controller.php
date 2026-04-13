<?php
require_once 'models/timezones_model.php';
class timezones_controller {
    private $model;
    public function __construct() {
        $this->model = new timezones_model();
    }

    public function index() {
        return $this->model->getAll();
    }

}
?>
