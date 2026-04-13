<?php
class classes_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll($id=null) {
        if (!empty($id)) {
         return $this->db->query("SELECT b.id, b.name FROM subject_combinations a JOIN classes b ON a.class_id = b.id WHERE a.teacher = $id AND b.status = 'ENABLED' GROUP BY b.id")->fetchAll(PDO::FETCH_ASSOC);
        }else{
          return $this->db->query("SELECT * FROM classes WHERE status = 'ENABLED'")->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function check_name($name, $id=null) {
        $where = !empty($id) ? ' WHERE name = ? AND id != ? ' : ' WHERE name = ?';
        $stmt = $this->db->prepare("SELECT * FROM classes $where");
        !empty($id) ? $stmt->execute([$name, $id]) : $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO classes ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE classes SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM classes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
