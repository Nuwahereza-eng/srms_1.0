<?php
require_once 'models/subject_combinations_model.php';
class subject_combinations_controller {
    private $model;
    public function __construct() {
        $this->model = new subject_combinations_model();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function show($id) {
        return $this->model->get($id);
    }

    public function sub_teacher($subject, $class) {
        return $this->model->get_teacher($subject, $class);
    }

    public function get_subjects($class, $teacher=null) {
        return $this->model->get_subjects($class, $teacher);
    }

    public function store($data) {
        return $this->model->insert($data);
    }

    public function update($subject, $class, $teacher) {
        return $this->model->update($subject, $class, $teacher);
    }



    public function destroy($id) {
        return $this->model->delete($id);
    }
}
?>
