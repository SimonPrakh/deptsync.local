
$(document).ready(function() {
    // Отправляем AJAX-запрос для получения списка департаментов
    $.ajax({
        url: 'http://deptsync.local/departments', // Замените на правильный путь к методу index вашего контроллера
        type: 'GET',
        dataType: 'json', // Ожидаем, что сервер вернет JSON
        success: function(data) {
            if (data.length > 0) {
                // Очищаем текущий список
                $('#employeeDepartment').empty();

                // Заполняем выпадающий список полученными данными
                $.each(data, function(index, department) {
                    $('#employeeDepartment').append(
                        $('<option>', {
                            value: department.id,
                            text: department.name
                        })
                    );
                });
            } else {
                $('#employeeDepartment').append('<option>No departments found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching departments: ', error);
            $('#employeeDepartment').append('<option>Error loading departments</option>');
        }
    });
});



$(document).ready(function(){
    $('#addEmployeeForm').on('submit', function(e){
        e.preventDefault(); // Предотвращаем стандартную отправку формы

        // Создаем объект с данными формы
        const formData = {
            email: $('#employeeEmail').val(),
            name: $('#employeeName').val(),
            address: $('#employeeAddress').val(),
            phone: $('#employeePhone').val(),
            comments: $('#employeeComments').val(),
            department_id: $('#employeeDepartment').val()
        };

        // Отправка данных в формате JSON через AJAX
        $.ajax({
            url: 'deptsync.local/employee', // Укажите правильный путь к вашему методу контроллера
            type: 'POST',
            contentType: 'application/json', // Указываем, что отправляем данные в формате JSON
            data: JSON.stringify(formData), // Преобразуем объект в JSON-строку
            success: function(response) {
                // Парсим JSON-ответ от сервера
                const result = JSON.parse(response);

                if (result.status === 'success') {
                    $('#message').html('<div class="alert alert-success">' + result.message + '</div>');
                    $('#addEmployeeForm')[0].reset(); // Очистка формы
                } else {
                    $('#message').html('<div class="alert alert-danger">' + result.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#message').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            }
        });
    });
});
