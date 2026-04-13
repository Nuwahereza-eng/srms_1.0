<?php
require_once 'models/smtp_settings_model.php';
class smtp_settings_controller {
    private $model;
    public function __construct() {
        $this->model = new smtp_settings_model();
    }

    public function index() {
        return $this->model->getAll();
    }
    public function update($data) {
        return $this->model->update($data);
    }

}
?>
