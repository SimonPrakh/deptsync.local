<?php

class EmployeeController {
    
    // Метод для вывода списка всех пользователей
    public function index() {
        echo "Function: index1";
    }

    // Метод для добавления нового пользователя
    public function add() {
        echo "Function: add";
    }

    // Метод для просмотра информации о пользователе по ID
    public function view($id) {
        echo "Function: view with ID = " . $id;
    }
}
