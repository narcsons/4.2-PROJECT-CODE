<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    echo <<<HTML
    <script>
        alert('You are not logged in');
        window.location.href = './login.php';
    </script>
HTML;
    exit;
}

require_once './config.php'; // Ensure this contains your mysqli connection details
$employee_id = $_SESSION['employee_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $responses = $_POST;


    // Prepare the SQL statement for insertion
    $query = "INSERT INTO responses (employee_id, question_id, option_id) VALUES (?, ?, ?)
              ON DUPLICATE KEY UPDATE option_id = VALUES(option_id)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Loop through the responses and bind parameters
    foreach ($responses as $question_id => $options) {
        foreach ($options as $option_id) {
            // Bind the parameters (employee_id, question_id, option_id)
            $stmt->bind_param('sii', $employee_id, $question_id, $option_id);

            // Execute the query
            if (!$stmt->execute()) {
                // Handle any query errors
                die('Execute failed: ' . $stmt->error);
            }
        }
    }

    $stmt->close();

    echo <<<HTML
    <script>
        alert('Your responses have been submitted.');
        window.location.href = './results.php';
    </script>
HTML;
}

// Close the connection
$mysqli->close();
