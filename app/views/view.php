<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <!-- Подключаем Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Employee List</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Comments</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $employee['id']; ?></td>
                <td><?= $employee['name']; ?></td>
                <td><?= $employee['email']; ?></td>
                <td><?= $employee['comments']; ?></td>
                <td><?= $employee['department_name']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEmployeeModal" data-id="<?= $employee['id']; ?>">Edit</a>

                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?= $employee['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</a>

</div>
<?php include 'app/views/temlates/Employees/addEmp.php';
include 'app/views/temlates/Employees/delEmp.php';
?>

<!-- Подключаем Bootstrap JS и зависимости -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="app/views/js/Employees/add.js"></script>
<script src="app/views/js/Employees/delete.js"></script>
<script src="app/views/js/Employees/update.js"></script>

</body>
</html>
