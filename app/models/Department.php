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
    public function store($data) {
        // Проверка на уникальность имени
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Если такое имя уже существует, выводим сообщение об ошибке
            echo "Error: Name already in use by another user.";
            return false;
        }

        // Формируем запрос для вставки новой записи
        $query = "INSERT INTO " . $this->table_name . "
              SET
                name = :name"; // Удалил лишнюю запятую

        $stmt = $this->conn->prepare($query);

        // Очистка данных
        $name = htmlspecialchars(strip_tags($data['name']));

        // Привязка параметров
        $stmt->bindParam(':name', $name);

        // Выполнение запроса на вставку
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Метод для получения всех сотрудников
    public function all() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Метод для получения данных одного сотрудника по ID
    public function find($id) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);
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

        if ($result['count'] == 0) {
            // Если запись не найдена, выводим сообщение об ошибке
            echo "Error: User not found.";
            return false;
        }

        // Проверка на уникальность имени (если имя изменилось)
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE name = :name AND id != :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Если такое имя уже существует для другой записи, выводим сообщение об ошибке
            echo "Error: Name already in use by another user.";
            return false;
        }

        // Формируем запрос для обновления записи
        $query = "UPDATE " . $this->table_name . "
              SET
                name = :name
              WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        // Очистка данных
        $name = htmlspecialchars(strip_tags($data['name']));

        // Привязка параметров
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        // Выполнение запроса на обновление
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }



    // Метод для удаления сотрудника
    public function delete($id) {
        $query = "DELETE FROM ".$this->table_name." WHERE id = :id"; // Используем именованный параметр :id

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
