<?php
class DBConnection {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $db_name = "e-commerce_php";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$db_name, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                return false;
            }
        }
        return self::$conn;
    }
}


?>