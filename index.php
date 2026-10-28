<?php
require "db.php";
$sql = "SELECT employees.id,
               employees.full_name,
               employees.email,
               departments.department_name
        FROM employees
        INNER JOIN departments
        ON employees.department_id = departments.id
        ORDER BY employees.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f6fa;
        }
        h2 {
            color: #222;
        }
        a, button {
            display: inline-block;
            padding: 9px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #2563eb;
            color: white;
        }
        tr:nth-child(even) {
            background: #f1f5f9;
        }
    </style>
</head>
<body>
    <h2>Employee Management</h2>
    <a href="add_employee.php">+ Add Employee</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row["id"] ?></td>
                        <td><?= htmlspecialchars($row["full_name"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td><?= htmlspecialchars($row["department_name"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No employees found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
