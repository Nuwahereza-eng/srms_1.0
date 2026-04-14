<?php
class database {
    private static $pdo;
    public static function connect() {

		$db_host = $_ENV["DB_HOST"] ?? getenv("DB_HOST");
		$db_port = $_ENV["DB_PORT"] ?? getenv("DB_PORT");
		$db_user = $_ENV["DB_USERNAME"] ?? getenv("DB_USERNAME");
		$db_pass = $_ENV["DB_PASSWORD"] ?? getenv("DB_PASSWORD");
		$db_name = $_ENV["DB_NAME"] ?? getenv("DB_NAME");

        if (!self::$pdo) {
            self::$pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}

?>