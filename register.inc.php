<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // initialize an array to store any errors
    $errors = [];

    // get the form data
    $employee_id = trim($_POST['employee_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Include the database connection
    require 'config.php';

    // check if user already exists
    $sql = "SELECT * FROM employees WHERE employee_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $employee_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($num_rows > 0) {
        $errors[] = "Employee ID already exists!";
        exit;
    }

    // Prepare the SQL query to insert the employee record
    $sql = "INSERT INTO employees (employee_id, first_name, last_name, password) VALUES (?, ?, ?, ?)";

    // Initialize statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the employee_id and hashed password to the statement
        mysqli_stmt_bind_param($stmt, "ssss", $employee_id, $first_name, $last_name, $password);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registration successful!'); window.location.href = './login.php';</script>";
            exit();
        } else {
            $errors[] = "SQL error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $errors[] = "SQL error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
