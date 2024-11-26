<?php

// function to show text based on the most selected option
function showMostSelectedOption($most_selected_option)
{
    $result = '';

    switch ($most_selected_option) {
        case 'a':
            $result = "Secure Attachment Style";
            break;
        case 'b':
            $result = "Insecure Anxious Attachment Style";
            break;
        case 'c':
            $result = "Insecure Avoidant Attachment Style";
            break;
        case 'd':
            $result = "Disorganised Attachment Style";
            break;
        default:
            echo 'No option selected';
    }

    return $result;
}

require_once './config.php'; // Include database connection

$employee_id = $_SESSION['employee_id'];

// get employee full name from databse using first name and last name
$query = "SELECT first_name, last_name FROM employees WHERE employee_id = ?";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param('s', $employee_id); // Bind employee_id
$stmt->execute();
$get_name_result = $stmt->get_result();

if ($get_name_result->num_rows > 0) {
    $row = $get_name_result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
} else {
    $first_name = '';
    $last_name = '';
}

$stmt->close();


// Fetch employee responses along with the option details
$query = "
    SELECT o.option_text, o.option_char 
    FROM responses r
    INNER JOIN options o ON r.option_id = o.option_id
    WHERE r.employee_id = ?
";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param('s', $employee_id); // Bind employee_id
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Count the frequency of each option selected by the employee
    $option_count = [];

    while ($row = $result->fetch_assoc()) {
        $option_char = $row['option_char'];
        if (!isset($option_count[$option_char])) {
            $option_count[$option_char] = 0;
        }
        $option_count[$option_char]++;
    }

    // Find the most commonly selected option
    $most_selected_option = array_keys($option_count, max($option_count))[0];

    $category = showMostSelectedOption($most_selected_option);
} else {
    $most_selected_option = null;
}

$stmt->close();
$conn->close();
