<?php
session_start();
//  check if employee id set
if (isset($_SESSION['employee_id'])) {
    echo "<script>alert('You are already logged in!'); window.location.href = './index.php';</script>";
    exit;
}
require_once './login.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <div class="app-title">
        <p>Due Diligence Assessment Program (DDAP)</p>
    </div>
    <div class="form-container">
        <h2>Login</h2>

        <?php if (isset($errors)) {
            for ($i = 0; $i < count($errors); $i++) {
                echo "<p style='color: red;'>$errors[$i]</p>";
            }
        } ?>

        <form action="./login.php" method="POST">
            <input type="text" name="employee_id" required placeholder="Employee ID"><br>
            <input type="password" name="password" required placeholder="Password"><br>
            <button class="login-btn" type="submit">Login</button>
        </form>
        <!-- add aleady have a n accunt propt appropriately styled -->
        <p>Don't have an account? <a href="./register.php">Register</a></p>
    </div>
</body>

</html>