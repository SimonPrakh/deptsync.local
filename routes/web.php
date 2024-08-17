<?php
$routes = [
    '' => 'EmployeeController@index',
    'add-user' => 'EmployeeController@add',
    'user/{id}' => 'EmployeeController@view',
    'departments' => 'DepartmentController@index',
    'add-department' => 'DepartmentController@add',
    'delete-department/{id}' => 'DepartmentController@delete'
];


// Получаем текущий URI из глобального массива серверных переменных
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Функция для обработки маршрутов
function route($uri) {
    global $routes; // Подключаем глобальную переменную с маршрутами

    // Перебираем все маршруты, определенные в массиве $routes
    foreach ($routes as $route => $action) {

        // Заменяем {id} в маршруте на регулярное выражение, которое будет соответствовать числу
        $routePattern = str_replace('{id}', '(\d+)', $route);

        // Проверяем, соответствует ли текущий URI одному из маршрутов
        if (preg_match("#^$routePattern$#", $uri, $matches)) {

            // Разделяем строку действия на имя контроллера и метод
            list($controller, $method) = explode('@', $action);

            // Формируем путь к файлу контроллера
            $controllerFile = 'app/controllers/' . $controller . '.php';

            // Проверяем, существует ли файл контроллера
            if (file_exists($controllerFile)) {

                // Подключаем файл контроллера
                require_once $controllerFile;

                // Создаем экземпляр класса контроллера
                $controllerObj = new $controller;

                // Вызываем нужный метод контроллера, передавая ему параметры (например, {id})
                call_user_func_array([$controllerObj, $method], array_slice($matches, 1));

                // Завершаем выполнение функции, так как маршрут найден и обработан
                return;
            } else {
                // Если файл контроллера не найден, выводим ошибку
                echo "Контроллер не найден: " . $controllerFile;
                return;
            }
        }
    }

    // Если ни один маршрут не был найден, устанавливаем код ответа 404 и выводим сообщение
    http_response_code(404);
    echo "Page not found!";
}


