<?php

class DB
{
    public $host = "localhost";
    public $user = "root";
    public $pass = "5555";
    public $db_name = "my_database";
    public $conn;

    public function __construct()
    {
        try {
            // PDO yordamida MySQL ma'lumotlar bazasiga ulanish
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Xatolarni ushlash
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage(); // Xato xabari
        }
    }
}
?>
