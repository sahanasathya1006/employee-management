<?php
require "db.php";
$error = "";
$success = "";
$departments = $conn->query(
    "SELECT id, department_name FROM departments ORDER BY department_name"
);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department_id = filter_input(
        INPUT_POST,
        "department_id",
        FILTER_VALIDATE_INT
    );
    if (
        $full_name === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !$department_id
    ) {
        $error = "Please enter valid details and select a department.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO employees (full_name, email, department_id)
             SELECT ?, ?, id FROM departments WHERE id = ?"
        );
        $stmt->bind_param("ssi", $full_name, $email, $department_id);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Unable to add employee. Please select a valid department.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>
    <h2>Add New Employee</h2>
    <?php if ($error !== ""): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>
    <form method="POST" action="add_employee.php">
        <label>Full Name:</label><br>
        <input type="text" name="full_name" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Department:</label><br>
        <select name="department_id" required>
            <option value="">Select Department</option>
            <?php while ($dept = $departments->fetch_assoc()): ?>
                <option value="<?= (int)$dept["id"] ?>">
                    <?= htmlspecialchars($dept["department_name"]) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>
        <button type="submit">Add Employee</button>
    </form>
    <br>
    <a href="index.php">View Employees</a>
</body>
</html>
