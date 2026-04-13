<?php
class students_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE reg_no = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function last_entry() {
        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function runQuery($query, $params) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_account($email, $id=null) {
        $where = !empty($id) ? ' WHERE email = ? AND id != ? ' : ' WHERE email = ?';
        $stmt = $this->db->prepare("SELECT * FROM students $where");
        !empty($id) ? $stmt->execute([$email, $id]) : $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO students ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE students SET $fields WHERE reg_no = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE reg_no = ?");
        return $stmt->execute([$id]);
    }
}
?>
