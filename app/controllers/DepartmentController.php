<?php
require_once 'app/models/Department.php';

class DepartmentController {
    public function index() {
        $department = new Department();
        $Departments = $department->all();
        var_dump($Departments);
        // Передаем данные в представление (view)
        // Например, render('employees/index', ['employees' => $employees]);
        // Для простоты, здесь просто выведем данные:
        foreach ($Departments as $employee) {
            echo "ID: " . $employee['id'] . ", Name: " . $employee['name'] . ", Email: " . $employee['email'] . "<br>";
        }
    }

    // Метод для отображения одного сотрудника по ID
    public function show($id) {
        $DepartmentModel = new Department();
        $Department = $DepartmentModel->find($id);

        if ($Department) {
            // Передаем данные в представление (view)
            // Например, render('employees/show', ['employee' => $employee]);
            echo "Name: " . $Department['name'] . "<br>";
        } else {
            echo "Employee not found.";
        }
    }

    // Метод для создания нового сотрудника
    public function store() {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Создаем экземпляр модели Employee
        $DepartmentModel = new Employee();

        // Передаем данные в метод store модели
        if ($DepartmentModel->store($data)) {
            echo "Employee created successfully.";
        } else {
            echo "Failed to create employee.";
        }
    }



// Метод для обновления сотрудника
    public function update($id) {
        // Получаем сырой JSON из тела запроса
        $jsonData = file_get_contents('php://input');

        // Декодируем JSON в ассоциативный массив
        $data = json_decode($jsonData, true);

        // Проверка на ошибки декодирования
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Failed to decode JSON: " . json_last_error_msg();
            return;
        }

        // Создаем экземпляр модели Employee
        $DepartmentModel = new Employee();

        // Передаем данные в модель
        $DepartmentModel->update($id, $data);
    }

    // Метод для удаления сотрудника
    public function delete($id) {

        $DepartmentModel = new Employee();
        $deleted = $DepartmentModel->delete($id);

        if ($deleted) {
            echo "Department deleted successfully.";
        } else {
            echo "Failed to delete Department.";
        }
    }
}
