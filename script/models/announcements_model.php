<?php
class announcements_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM announcements")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function latest($keyword) {
        $keyword = '%'.$keyword.'%';
        return $this->db->query("SELECT * FROM announcements WHERE audience LIKE '$keyword' OR audience = 'Both' ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO announcements ($keys) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update($id, $data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE announcements SET $fields WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM announcements WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
