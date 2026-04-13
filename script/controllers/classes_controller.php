<?php
require_once 'models/classes_model.php';
class classes_controller {
    private $model;
    public function __construct() {
        $this->model = new classes_model();
    }

    public function index($id=null) {
        return $this->model->getAll($id);
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
