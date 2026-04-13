<?php
class subjects_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM subjects WHERE status = 'ENABLED'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_by_code($code) {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function check_code($code, $id=null) {
        $where = !empty($id) ? ' WHERE code = ? AND id != ? ' : ' WHERE code = ?';
        $stmt = $this->db->prepare("SELECT * FROM subjects $where");
        !empty($id) ? $stmt->execute([$code, $id]) : $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO subjects ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE subjects SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
