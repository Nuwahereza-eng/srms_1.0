<?php
class examination_results_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM examination_results")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM examination_results WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function check_record($reg, $class, $term, $ca) {
        $stmt = $this->db->prepare("SELECT * FROM examination_results WHERE reg_no = ? AND class_id = ? AND term = ? AND ca = ?");
        $stmt->execute([$reg, $class, $term, $ca]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO examination_results ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function runQuery($query, $params) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE examination_results SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM examination_results WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
