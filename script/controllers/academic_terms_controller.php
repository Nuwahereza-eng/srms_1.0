<?php
require_once 'models/academic_terms_model.php';
class academic_terms_controller {
    private $model;
    public function __construct() {
        $this->model = new academic_terms_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function check_name($name, $id=null) {
        return $this->model->check_name($name, $id);
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
