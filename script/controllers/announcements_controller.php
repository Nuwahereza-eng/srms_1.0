<?php
require_once 'models/announcements_model.php';
class announcements_controller {
    private $model;
    public function __construct() {
        $this->model = new announcements_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function get_latest($keyword) {
        return $this->model->latest($keyword);
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function store($data) {
        return $this->model->insert($data);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }
}
?>
