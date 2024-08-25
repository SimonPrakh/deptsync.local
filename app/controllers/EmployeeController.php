<?php
require_once 'app/models/Employee.php';

class EmployeeController {

    // Метод для отображения списка всех сотрудников
    public function index() {
        $employeeModel = new Employee();
        $employees = $employeeModel->all();
        include __DIR__ . '/../views/view.php';
    }


    // Метод для отображения одного сотрудника по ID
    public function show($id) {
        $employeeModel = new Employee();
        $employee = $employeeModel->find($id);

        if ($employee) {
            // Передаем данные в представление (view)
            // Например, render('employees/show', ['employee' => $employee]);
            echo "ID: " . $employee['id'] . "<br>";
            echo "Name: " . $employee['name'] . "<br>";
            echo "Email: " . $employee['email'] . "<br>";
            echo "Address: " . $employee['address'] . "<br>";
            echo "Phone: " . $employee['phone'] . "<br>";
            echo "Comments: " . $employee['comments'] . "<br>";
            echo "Department ID: " . $employee['department_id'] . "<br>";
        } else {
            echo "Employee not found.";
        }
    }

    // Метод для создания нового сотрудника
    public function store() {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Создаем экземпляр модели Employee
        $employeeModel = new Employee();

        // Передаем данные в метод store модели
        if ($employeeModel->store($data)) {
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
        $employeeModel = new Employee();

        // Передаем данные в модель
        $employeeModel->update($id, $data);
    }

    // Метод для удаления сотрудника
    public function delete($id) {

        $employeeModel = new Employee();
        $deleted = $employeeModel->delete($id);

        if ($deleted) {
            echo "Employee deleted successfully.";
        } else {
            echo "Failed to delete employee.";
        }
    }
}
