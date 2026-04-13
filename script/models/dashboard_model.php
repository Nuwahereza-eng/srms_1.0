<?php
class dashboard_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function programmes() {
        return $this->db->query("SELECT COUNT(id) as total_programmes FROM programmes")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function subjects() {
        return $this->db->query("SELECT COUNT(id) as total_subjects FROM subjects")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function classes() {
        return $this->db->query("SELECT COUNT(id) as total_classes FROM classes")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function students() {
        return $this->db->query("SELECT COUNT(id) as total_students FROM students")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function teachers() {
        return $this->db->query("SELECT COUNT(id) as total_teachers FROM staff WHERE role = 'TEACHER'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ca() {
        return $this->db->query("SELECT COUNT(id) as total_ca FROM continuous_assessments")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gs() {
        return $this->db->query("SELECT COUNT(id) as total_gs FROM grading_systems")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ds() {
        return $this->db->query("SELECT COUNT(id) as total_ds FROM division_systems")->fetchAll(PDO::FETCH_ASSOC);
    }




    public function my_subjects($profile) {
        return $this->db->query("SELECT count(teacher) as total FROM subject_combinations WHERE teacher = $profile")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function my_classes($profile) {
        return $this->db->query("SELECT count(class_id) as total FROM subject_combinations WHERE teacher = $profile")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function my_students($profile) {
        return $this->db->query("SELECT count(reg_no) as total FROM students, (SELECT class_id FROM subject_combinations WHERE teacher = $profile) as class_list WHERE class IN(class_id)")->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
