<?php
class smtp_settings_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM smtp_settings")->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data) {
        $fields = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE smtp_settings SET $fields");
        return $stmt->execute([...array_values($data)]);
    }

}
?>
