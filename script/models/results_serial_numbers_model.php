<?php
class results_serial_numbers_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function get($reg, $class, $term) {
        $stmt = $this->db->prepare("SELECT * FROM results_serial_numbers WHERE reg_no = ? AND class_id = ? AND academic_term = ?");
        $stmt->execute([$reg, $class, $term]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function retrieve($serial) {
        $stmt = $this->db->prepare("SELECT * FROM results_serial_numbers WHERE serial_no = ?");
        $stmt->execute([$serial]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($reg, $class, $term, $serial) {
        $stmt = $this->db->prepare("INSERT INTO results_serial_numbers (reg_no, class_id, academic_term, serial_no) VALUES (?,?,?,?)");
        return $stmt->execute([$reg, $class, $term, $serial]);
    }

}
?>
