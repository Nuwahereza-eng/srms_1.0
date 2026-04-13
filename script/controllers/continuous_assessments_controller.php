<?php
require_once 'models/continuous_assessments_model.php';
class continuous_assessments_controller {
    private $model;
    public function __construct() {
        $this->model = new continuous_assessments_model();
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
