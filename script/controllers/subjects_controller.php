<?php
require_once 'models/subjects_model.php';
class subjects_controller {
    private $model;
    public function __construct() {
        $this->model = new subjects_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function show_by_code($code) {
        return $this->model->get_by_code($code);
    }

    public function check_code($code, $id=null) {
        return $this->model->check_code($code, $id);
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
