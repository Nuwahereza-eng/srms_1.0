<?php
class database {
    private static $pdo;
    public static function connect() {

		$db_host = getenv("DB_HOST");
		$db_port = getenv("DB_PORT");
		$db_user = getenv("DB_USERNAME");
		$db_pass = getenv("DB_PASSWORD");
		$db_name = getenv("DB_NAME");

        if (!self::$pdo) {
            self::$pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}

?>