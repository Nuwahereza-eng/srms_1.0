<?php
require_once 'models/examination_results_model.php';
class examination_results_controller {
    private $model;
    public function __construct() {
        $this->model = new examination_results_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function check_record($reg, $class, $term, $ca) {
        return $this->model->check_record($reg, $class, $term, $ca);
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
