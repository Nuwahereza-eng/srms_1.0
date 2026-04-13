<?php
class signatures_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM signatures")->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data) {
      $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
      $stmt = $this->db->prepare("UPDATE signatures SET $fields");
      return $stmt->execute([...array_values($data)]);
    }

}
?>
