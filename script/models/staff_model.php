<?php
class staff_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM staff WHERE role = 'TEACHER'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_account($email, $id=null) {
        $where = !empty($id) ? ' WHERE email = ? AND id != ? ' : ' WHERE email = ?';
        $stmt = $this->db->prepare("SELECT * FROM staff $where");
        !empty($id) ? $stmt->execute([$email, $id]) : $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO staff ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE staff SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM staff WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
