<?php

if (!isset($_SESSION['employee_id'])) {
    echo <<<HTML
    <script>
        alert('You are not logged in');
        window.location.href = './login.php';
    </script>
HTML;
    exit;
} else {
    $employee_id = $_SESSION['employee_id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $password = $_POST['password'];

    require_once './config.php';
    // check if any input fields are empty
    if (empty($password)) {
        echo <<<HTML
        <script>
            alert('Please provide a valid password');
            window.location.href = './results.php';
        </script>
HTML;
        exit;
    }

    $sql = "SELECT password FROM employees WHERE employee_id=?";
    $stmt = mysqli_stmt_init($conn);

    // check if the prepared statement fails
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $errors[] = "SQL error";
    }

    mysqli_stmt_bind_param($stmt, "s", $employee_id);
    mysqli_stmt_execute($stmt);

    $checkResults = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($checkResults)) {
        $passwordCheck = password_verify($password, $row['password']);

        if ($passwordCheck == false) {
            echo <<<HTML
            <script>
                alert('Incorrect credentials');
                window.location.href = './results.php';
            </script>
HTML;
            exit;
        } else if ($passwordCheck == true) {
            $user_password = $password;
        } else {
            echo <<<HTML
            <script>
                alert('Incorrect credentials');
                window.location.href = './results.php';
            </script>
HTML;
            exit;
        }
    } else {
        echo <<<HTML
        <script>
            alert('Incorrect credentials');
            window.location.href = './results.php';
        </script>
HTML;
        exit;
    }
} else {
    echo <<<HTML
    <script>
        alert('Invalid request method');
        window.location.href = './results.php';
    </script>
HTML;
}
