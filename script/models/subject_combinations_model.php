<?php
class subject_combinations_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM subject_combinations")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM subject_combinations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_teacher($subject, $class) {
        $stmt = $this->db->prepare("SELECT * FROM subject_combinations WHERE subject_id = ? AND class_id = ?");
        $stmt->execute([$subject, $class]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_subjects($class, $teacher=null) {
    if (empty($teacher)) {
    $stmt = $this->db->prepare("SELECT b.id, b.code, b.name FROM subject_combinations a JOIN
    subjects b ON a.subject_id = b.id WHERE a.class_id = ?");
    $stmt->execute([$class]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else{
    $stmt = $this->db->prepare("SELECT b.id, b.code, b.name FROM subject_combinations a JOIN
    subjects b ON a.subject_id = b.id WHERE a.class_id = ? AND a.teacher = ?");
    $stmt->execute([$class, $teacher]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO subject_combinations ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($subject, $class, $teacher) {
        $stmt = $this->db->prepare("UPDATE subject_combinations SET teacher = ? WHERE subject_id = ? AND class_id = ?");
        return $stmt->execute([$teacher, $subject, $class]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM subject_combinations WHERE id = ?");
        return $stmt->execute([$id]);
    }


}
?>
