<?php
class school_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM school")->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE school SET $fields");
        return $stmt->execute([...array_values($data)]);
    }

}
?>
