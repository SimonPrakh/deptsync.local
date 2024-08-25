$(document).ready(function() {
    var employeeId;

    // Сохранение ID сотрудника при открытии модального окна
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        employeeId = button.data('id');
    });

    // Обработка нажатия на кнопку подтверждения
    $('#confirmDeleteBtn').on('click', function() {
        $.ajax({
            url: 'employee/'+employeeId,
            type: 'DELETE',
            success: function(response) {
                // Закрытие модального окна
                $('#confirmDeleteModal').modal('hide');
                // Обновление страницы или удаление строки сотрудника из таблицы
                location.reload(); // или удаление элемента из DOM
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    });
});
