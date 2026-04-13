<?php
class timezones_model {
    private $db;
    public function __construct() {
        $this->db = database::connect();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM timezones")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
