<?php
session_start();
//  check if employee id set
if (isset($_SESSION['employee_id'])) {
    echo "<script>alert('You are already logged in!'); window.location.href = './index.php';</script>";
    exit;
}

require_once './register.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<div class="app-title">
        <p>Due Diligence Assessment Program (DDAP)</p>
    </div>

    <div class="form-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <input type="text" name="employee_id" placeholder="Employee ID" required><br>
            <input type="text" name="first_name" placeholder="First Name" required><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button class="register-btn" type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="./login.php">Login</a></p>
    </div>
</body>

</html>