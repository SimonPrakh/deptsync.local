<?php
require_once 'config/database.php';

class Employee {
    private $conn;
    private $table_name = "employees";

    public $id;

    public function __construct($id = null) {
        $database = new Database();
        $this->conn = $database->getConnection();

        // Устанавливаем ID, если он передан
        if ($id !== null) {
            $this->id = $id;
        }
    }

    // Метод для создания нового сотрудника

    public function store($data) {
        // Проверка на уникальность email
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Если такой email уже существует, выводим сообщение об ошибке
            echo "Error: Email already in use by another user.";
            return false;
        }

        // Формируем запрос для вставки новой записи
        $query = "INSERT INTO " . $this->table_name . "
              SET
                email = :email,
                name = :name,
                address = :address,
                phone = :phone,
                comments = :comments,
                department_id = :department_id";

        $stmt = $this->conn->prepare($query);

        // Очистка данных
        $email = htmlspecialchars(strip_tags($data['email']));
        $name = htmlspecialchars(strip_tags($data['name']));
        $address = htmlspecialchars(strip_tags($data['address']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $comments = htmlspecialchars(strip_tags($data['comments']));
        $department_id = htmlspecialchars(strip_tags($data['department_id']));

        // Привязка параметров
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':department_id', $department_id);

        // Выполнение запроса на вставку
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    // Метод для получения всех сотрудников
    public function all() {
        $query = "
            SELECT employees.id, employees.name, employees.email, employees.comments, employees.department_id, departments.name as department_name 
            FROM " . $this->table_name . " 
            LEFT JOIN departments ON employees.department_id = departments.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Метод для получения данных одного сотрудника по ID
    public function find($id) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        echo $query;
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row; // Возвращаем данные в виде массива
        }

        return null;
    }

    // Метод для обновления данных сотрудника
    public function update($id, $data) {

        // Проверяем наличие записи с таким ID
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Если запись найдена, продолжаем выполнение кода
            echo "Record found. Proceeding with further code execution.";
        } else {
            echo "Error: User not found.";
            return false;
        }

        // Проверка на уникальность email (если email изменился)
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = :email AND id != :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Если такой email уже существует для другой записи, выводим сообщение об ошибке
            echo "Error: Email already in use by another user.";
            return false;
        }

        // Формируем запрос для обновления записи
        $query = "UPDATE " . $this->table_name . "
              SET
                email = :email,
                name = :name,
                address = :address,
                phone = :phone,
                comments = :comments,
                department_id = :department_id
              WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        // Очистка данных
        $email = htmlspecialchars(strip_tags($data['email']));
        $name = htmlspecialchars(strip_tags($data['name']));
        $address = htmlspecialchars(strip_tags($data['address']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $comments = htmlspecialchars(strip_tags($data['comments']));
        $department_id = htmlspecialchars(strip_tags($data['department_id']));

        // Привязка параметров
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':department_id', $department_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }



    // Метод для удаления сотрудника
    public function delete($id) {
        $query = "DELETE FROM employees WHERE id = :id"; // Используем именованный параметр :id

        $stmt = $this->conn->prepare($query);

        // Очистка данных и привязка параметра id
        $id = htmlspecialchars(strip_tags($id), ENT_QUOTES, 'UTF-8');

        // Привязка параметра ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Выполнение запроса
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
