<?php

require_once './config.php';

// Fetch questions and options
$sql = "SELECT q.question_id, q.question_text, o.option_id, o.option_char, o.option_text 
        FROM questions q 
        LEFT JOIN options o ON q.question_id = o.question_id 
        ORDER BY q.question_id, o.option_char";

$result = $conn->query($sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[$row['question_id']]['question_text'] = $row['question_text'];
        $questions[$row['question_id']]['question_id'] = $row['question_id'];
        $questions[$row['question_id']]['options'][] = [
            'option_char' => $row['option_char'],
            'option_id' => $row['option_id'],
            'option_text' => $row['option_text']
        ];
    }
}

$conn->close();
