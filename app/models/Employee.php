<?php
require_once 'config/database.php';

class Employee {
    private $conn;
    private $table_name = "employees";

    public $id;
    public $email;
    public $name;
    public $address;
    public $phone;
    public $comments;
    public $department_id;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Методы для работы с базой данных (CRUD)
}
