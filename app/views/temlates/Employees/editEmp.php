<!-- Модальное окно -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Update Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <input type="hidden" id="employeeId" name="id">
                    <div class="form-group">
                        <label for="employeeName">Name</label>
                        <input type="text" class="form-control" id="employeeName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeEmail">Email</label>
                        <input type="email" class="form-control" id="employeeEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="employeeComments">Comments</label>
                        <textarea class="form-control" id="employeeComments" name="comments"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="employeeDepartment">Department</label>
                        <select class="form-control" id="employeeDepartment" name="department_id" required>
                            <option>Loading departments...</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                </form>
            </div>
        </div>
    </div>
</div><?php
