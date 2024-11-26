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

require_once './results.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Results</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="hystmodal.min.css">
    <style>
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
        }

        .page-title {
            text-align: center;
            font-size: 35px;
        }

        .generate-pdf-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>Employee ID: <?php echo htmlspecialchars($_SESSION['employee_id']); ?></p>
        <a class="assessment-btn" href="./index.php">Assessment</a>
        <a class="logout-btn" href="./logout.php">Logout</a>
    </div>

    <p class="page-title">Assessment Results</p>
    <p class="category-text">You have a <?php echo htmlspecialchars($category) ?></p>


    <div>
        <a class="generate-pdf-btn" href="#" data-hystmodal="#myModal">Get PDF Report</a>
    </div>

    <div class="hystmodal" id="myModal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Close</button>
                <form class="modal-form" action="./report.php" method="post">
                    <label class="nodal-pass-label" for="password">Enter your password to generate a pdf report:</label>
                    <input class="modal-pass-input" type="password" name="password" id="password" required>
                    <button type="submit">Generate PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="result-text">
        <?php if ($most_selected_option === 'a'): ?>
            <p><strong>Secure attachment style in the workplace</strong> is characterized by healthy interpersonal relationships, effective communication, and a sense of trust among colleagues. Individuals with this attachment style typically exhibit the following traits that enhance productivity:</p>
            <ul>
                <li><strong>Collaboration:</strong> They work well with others, fostering a team-oriented environment. This encourages sharing ideas and resources, leading to innovative solutions.</li>
                <li><strong>Open Communication:</strong> Securely attached individuals are comfortable expressing their thoughts and feelings, which helps prevent misunderstandings and promotes clarity in tasks and objectives.</li>
                <li><strong>Emotional Regulation:</strong> They manage stress and emotions effectively, which allows them to remain focused and resilient during challenging projects.</li>
                <li><strong>Feedback Acceptance:</strong> They are receptive to constructive criticism and use it to improve their performance, contributing to personal and team growth.</li>
            </ul>
            <p>Overall, secure attachment promotes a positive work culture, leading to higher productivity and job satisfaction.</p>

        <?php elseif ($most_selected_option === 'b'): ?>
            <p><strong>Insecure anxious attachment style</strong> in the office can manifest as heightened sensitivity to feedback, fear of rejection, and a constant need for reassurance. Individuals may struggle with self-doubt, leading to overworking or micromanaging tasks, which can hinder collaboration and overall productivity.</p>
            <p><strong>Strategies for Improvement:</strong></p>
            <ul>
                <li><strong>Self-Reflection:</strong> Encourage journaling or mindfulness to recognize and challenge anxious thoughts.</li>
                <li><strong>Set Clear Goals:</strong> Establish specific, achievable goals to boost confidence and focus efforts.</li>
                <li><strong>Build a Support Network:</strong> Foster relationships with supportive colleagues to enhance feelings of security.</li>
                <li><strong>Seek Constructive Feedback:</strong> Actively ask for feedback in a structured way, reducing uncertainty and anxiety about performance.</li>
                <li><strong>Practice Assertiveness:</strong> Develop skills to express needs and boundaries without fear, promoting clearer communication.</li>
                <li><strong>Engage in Professional Development:</strong> Pursue training to improve skills and self-efficacy, reducing feelings of inadequacy.</li>
            </ul>

        <?php elseif ($most_selected_option === 'c'): ?>
            <p><strong>Insecure avoidant attachment style</strong> often manifests in the workplace through behaviors such as emotional distance, reluctance to collaborate, and difficulty seeking help. Individuals may prioritize independence over teamwork, which can hinder communication and productivity.</p>
            <p><strong>Impacts on Productivity:</strong></p>
            <ul>
                <li><strong>Limited Collaboration:</strong> Avoidant individuals may avoid sharing ideas or feedback, leading to missed opportunities for innovation.</li>
                <li><strong>Reduced Engagement:</strong> A tendency to disengage from team dynamics can affect overall morale and motivation.</li>
                <li><strong>Resistance to Feedback:</strong> They may struggle to accept constructive criticism, limiting personal and professional growth.</li>
            </ul>
            <p><strong>Strategies for Improvement:</strong></p>
            <ul>
                <li><strong>Foster Open Communication:</strong> Create an environment where sharing ideas and concerns is encouraged. Regular check-ins can help.</li>
                <li><strong>Build Trust:</strong> Team-building activities can enhance relationships, making it easier for avoidant individuals to feel safe and supported.</li>
                <li><strong>Set Clear Expectations:</strong> Provide clarity around roles and responsibilities to reduce anxiety about collaboration.</li>
                <li><strong>Encourage Small Steps:</strong> Start with low-stakes collaborations to gradually increase comfort levels in working with others.</li>
                <li><strong>Provide Supportive Feedback:</strong> Frame feedback positively and constructively to help them feel more comfortable with it.</li>
            </ul>

        <?php elseif ($most_selected_option === 'd'): ?>
            <p><strong>Disorganized insecure attachment style</strong> in the workplace can manifest as unpredictability, difficulty with collaboration, and challenges in managing stress. Individuals may struggle with anxiety about their performance and relationships with colleagues, leading to inconsistent productivity.</p>
            <p><strong>Impact on Productivity:</strong></p>
            <ul>
                <li><strong>Inconsistent Work Quality:</strong> Fluctuating motivation can lead to erratic performance.</li>
                <li><strong>Poor Communication:</strong> Fear of judgment may cause avoidance of interactions, resulting in misunderstandings.</li>
                <li><strong>Difficulty with Feedback:</strong> Resistance to constructive criticism can hinder personal and professional growth.</li>
                <li><strong>High Stress Levels:</strong> Anxiety about tasks and relationships can lead to burnout.</li>
            </ul>
            <p><strong>Strategies for Improvement:</strong></p>
            <ul>
                <li><strong>Cultivate a Supportive Environment:</strong> Foster open communication and encourage teamwork to reduce anxiety around collaboration.</li>
                <li><strong>Set Clear Expectations:</strong> Establish defined roles and responsibilities to help individuals feel more secure in their contributions.</li>
                <li><strong>Encourage Professional Development:</strong> Provide training on emotional intelligence and conflict resolution to build resilience.</li>
                <li><strong>Promote Regular Feedback:</strong> Create a culture of constructive feedback that focuses on growth rather than judgment.</li>
                <li><strong>Mindfulness and Stress Management:</strong> Offer resources for stress reduction, such as workshops or access to mental health support.</li>
            </ul>

        <?php else: ?>
            <p>No responses found or unable to determine the most selected attachment style.</p>
        <?php endif; ?>
    </div>

    <script src="./hystmodal.min.js"></script>
    <script>
        const myModal = new HystModal({
            linkAttributeName: "data-hystmodal",
            catchFocus: true,
            waitTransitions: true,
        });
    </script>

</body>

</html>