<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    echo <<<HTML
    <script>
        alert('You are not logged in');
        window.location.href = './login.php';
    </script>
HTML;
}

require_once './questions.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Assessment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="./styles.css">
    <style>
        /* General body styles */
        body,
        html {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: block;
        }

        .questions-form {
            display: block;
            width: 80vw;
            margin: auto;
            padding: 20px;
            margin-bottom: 10px;
        }

        .page-title {
            text-align: center;
            font-size: 35px;
        }

        .submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            opacity: 0.6;
            margin-top: 10px;
        }

        .submit-btn.enabled {
            cursor: pointer;
            opacity: 1;
        }

        .options-box {
            display: block;
            margin: 5px 0;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>Employee ID: <?php echo htmlspecialchars($_SESSION['employee_id']); ?></p>
        <a class="logout-btn" href="./logout.php">Logout</a>
    </div>

    <p class="page-title">Assessment</p>

    <main>
        <form action="/submit.inc.php" method="post" class="questions-form">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($questions as $question): ?>
                        <div class="swiper-slide">
                            <div class="question-text">
                                <?php echo htmlspecialchars($question['question_text']); ?>
                            </div>

                            <div>
                                <?php foreach ($question['options'] as $option): ?>
                                    <div class="options-box">
                                        <input type="radio" id="option-<?php echo $option['option_id']; ?>" name="<?php echo $question['question_id']; ?>[]" value="<?php echo $option['option_id']; ?>" onchange="checkAnswers()">
                                        <label for="option-<?php echo $option['option_id']; ?>">
                                            <?php echo htmlspecialchars($option['option_char'] . ': ' . $option['option_text']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div style="padding-bottom: 20px;">
                    <button type="submit" class="submit-btn" disabled onclick="submitForm()">Submit</button>
                </div>


            </div>

        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            effect: "cards",
            grabCursor: true,
            keyboard: {
                enabled: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                renderBullet: function(index, className) {
                    return '<span class="' + className + '">' + (index + 1) + "</span>";
                },
            },
        });

        function checkAnswers() {
            // Get all questions
            const questions = document.querySelectorAll('.swiper-slide');
            let allAnswered = true;

            questions.forEach(question => {
                // Check if at least one radio button is checked
                const radios = question.querySelectorAll('input[type="radio"]');
                const isAnswered = Array.from(radios).some(radio => radio.checked);
                if (!isAnswered) {
                    allAnswered = false;
                }
            });

            // Enable or disable the submit button based on whether all questions are answered
            const submitButton = document.querySelector('.submit-btn');
            if (allAnswered) {
                submitButton.disabled = false;
                submitButton.classList.add('enabled');
                submitButton.style.cursor = 'pointer';
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
                submitButton.classList.remove('enabled');
                submitButton.style.cursor = 'not-allowed';
            }
        }


        function submitForm() {
            document.querySelector('.questions-form').submit();
        }
    </script>
</body>

</html>