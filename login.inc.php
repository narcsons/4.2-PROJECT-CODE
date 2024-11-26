<!-- login.inc.php -->

<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    require_once './config.php';


    // check if any input fields are empty
    if (empty($employee_id) || empty($password)) {
        $errors[] = "Please fill in all fields";
    }

    // check if the employee_id exists
    $sql = "SELECT * FROM employees WHERE employee_id=?";
    $stmt = mysqli_stmt_init($conn);

    // check if the prepared statement fails
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $errors[] = "SQL error";
    }

    // bind the employee_id to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $employee_id);
    mysqli_stmt_execute($stmt);

    $checkResults = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($checkResults)) {
        $passwordCheck = password_verify($password, $row['password']);

        if ($passwordCheck == false) {
            $errors[] = "Incorrect credentials";
        } else if ($passwordCheck == true) {
            session_start();
            $_SESSION['employee_id'] = $row['employee_id'];
            header("location: ../index.php?login=success");
        } else {
            $errors[] = "Incorrect credentials";
        }
    } else {
        $errors[] = "Incorrect credentials";
    }
}
