
$(document).ready(function() {
    $('#editEmployeeModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var employeeId = button.data('id');

        // Сначала загружаем список департаментов
        $.ajax({
            url: 'http://deptsync.local/departments',
            type: 'GET',
            dataType: 'json',
            success: function(departments) {
                // Очищаем текущий список
                $('#employeeDepartment').empty();
                console.log(departments)
                // Заполняем выпадающий список полученными данными
                $.each(departments, function(index, department) {
                    $('#employeeDepartment').append(
                        $('<option>', {
                            value: department.id,
                            text: department.name
                        })
                    );
                });

                // После загрузки департаментов загружаем данные сотрудника
                loadEmployeeData(employeeId);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching departments: ', error);
                $('#employeeDepartment').append('<option>Error loading departments</option>');
            }
        });

        function loadEmployeeData(employeeId) {
            // Загрузка данных сотрудника через AJAX
            $.ajax({
                url: 'employee/' + employeeId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Заполнение формы данными
                    $('#employeeId').val(data.id);
                    $('#employeeName').val(data.name);
                    $('#employeeEmail').val(data.email);
                    $('#employeeComments').val(data.comments);
                    $('#employeeDepartment').val(data.department_id);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
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
