<?php
require_once 'models/students_model.php';
class students_controller {
    private $model;
    public function __construct() {
        $this->model = new students_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function last_entry() {
        return $this->model->last_entry();
    }

    public function account($email, $id=null) {
        return $this->model->get_account($email, $id);
    }

    public function store($data) {
        return $this->model->insert($data);
    }

    public function runQuery($query, $params) {
        return $this->model->runQuery($query, $params);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }
}
?>
