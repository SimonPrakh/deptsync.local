<?php
require_once 'config/database.php';

class Department {
    private $conn;
    private $table_name = "departments";

    public $id;
    public $name;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Методы для работы с базой данных (CRUD)
}
