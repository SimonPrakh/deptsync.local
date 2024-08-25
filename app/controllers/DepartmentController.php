<?php
require_once 'app/models/Department.php';

class DepartmentController {
    public function index() {
        $department = new Department();
        $departments = $department->all();
        header('Content-Type: application/json');
        echo json_encode($departments);
    }

    // Метод для отображения одного сотрудника по ID
    public function show($id) {
        $DepartmentModel = new Department();
        $Department = $DepartmentModel->find($id);

        if ($Department) {
            // Передаем данные в представление (view)
        return $Department;
            // Например, render('employees/show', ['employee' => $employee]);
        } else {
            echo "Department not found.";
        }
    }

    // Метод для создания нового сотрудника
    public function store() {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        // Создаем экземпляр модели Employee
        $DepartmentModel = new Department();

        // Передаем данные в метод store модели
        if ($DepartmentModel->store($data)) {
            echo "Department created successfully.";
        } else {
            echo "Failed to create department.";
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
        $DepartmentModel = new Department();

        // Передаем данные в модель
        $DepartmentModel->update($id, $data);
    }

    // Метод для удаления сотрудника
    public function delete($id) {

        $DepartmentModel = new Department();
        $deleted = $DepartmentModel->delete($id);

        if ($deleted) {
            echo "Department deleted successfully.";
        } else {
            echo "Failed to delete Department.";
        }
    }
}
