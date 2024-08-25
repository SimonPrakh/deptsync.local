
    $(document).ready(function() {
        $('#addEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var employeeId = button.data('id');

            // Загрузка данных сотрудника через AJAX
            $.ajax({
                url: 'employee/'+employeeId,
                type: 'GET',
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
        });
    });

    // Обработка формы и отправка данных на сервер
    $('#addEmployeeForm').on('submit', function(e) {
        e.preventDefault();

        var employeeId = $('#employeeId').val();

        $.ajax({
            url: 'employee/'+employeeId,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addEmployeeModal').modal('hide');
                location.reload(); // обновить страницу или обновить данные в DOM
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    });
});
