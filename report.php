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

require_once './report.inc.php';
require_once './results.inc.php';

// Include the TCPDF library
require_once('vendor/autoload.php'); // Assuming you've installed via Composer

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("$first_name $last_name - $employee_id");
$pdf->SetTitle("Assessment Report for $first_name $last_name - $employee_id");
$pdf->SetSubject('Attachment Style Assessment Results');
$pdf->SetKeywords('Attachment, Style, Assessment, Results');

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 26);
$pdf->setCellPaddings(10, 10, 10, 10); // Set padding for the cell (left, top, right, bottom)

// Use MultiCell to allow line breaks
$pdf->MultiCell(0, 10, "Attachment Style Assessment Report for $first_name $last_name ($employee_id)", 0, 'C', 0, 1, '', '', true);


$pdf->SetFont('helvetica', 'B', 20);
$pdf->setCellPaddings(10, 10, 10, 10); // Set padding for the cell (left, top, right, bottom)

// Use MultiCell to allow line breaks
$pdf->MultiCell(0, 10, "You have a $category", 0, 'C', 0, 1, '', '', true);

// Reset padding if needed for further content
$pdf->setCellPaddings(0, 0, 0, 0);

$pdf->SetFont('helvetica', '', 12); 

$pdf->Ln(10);


// Start building the dynamic HTML content
$html = '<p class="page-title">Assessment Results</p>';
$html .= '<p class="category-text">You have a ' . htmlspecialchars($category) . '</p>';

$html = "";

// Process the decision logic in PHP before generating the PDF
if ($most_selected_option === 'a') {
    $html .= '<p><strong>Secure attachment style in the workplace</strong> is characterized by healthy interpersonal relationships, effective communication, and a sense of trust among colleagues. Individuals with this attachment style typically exhibit the following traits that enhance productivity:</p>';
    $html .= '<ul>
                <li><strong>Collaboration:</strong> They work well with others, fostering a team-oriented environment. This encourages sharing ideas and resources, leading to innovative solutions.</li>
                <li><strong>Open Communication:</strong> Securely attached individuals are comfortable expressing their thoughts and feelings, which helps prevent misunderstandings and promotes clarity in tasks and objectives.</li>
                <li><strong>Emotional Regulation:</strong> They manage stress and emotions effectively, which allows them to remain focused and resilient during challenging projects.</li>
                <li><strong>Feedback Acceptance:</strong> They are receptive to constructive criticism and use it to improve their performance, contributing to personal and team growth.</li>
             </ul>';
    $html .= '<p>Overall, secure attachment promotes a positive work culture, leading to higher productivity and job satisfaction.</p>';
} elseif ($most_selected_option === 'b') {
    $html .= '<p><strong>Insecure anxious attachment style</strong> in the office can manifest as heightened sensitivity to feedback, fear of rejection, and a constant need for reassurance. Individuals may struggle with self-doubt, leading to overworking or micromanaging tasks, which can hinder collaboration and overall productivity.</p>';
    $html .= '<p><strong>Strategies for Improvement:</strong></p>
              <ul>
                  <li><strong>Self-Reflection:</strong> Encourage journaling or mindfulness to recognize and challenge anxious thoughts.</li>
                  <li><strong>Set Clear Goals:</strong> Establish specific, achievable goals to boost confidence and focus efforts.</li>
                  <li><strong>Build a Support Network:</strong> Foster relationships with supportive colleagues to enhance feelings of security.</li>
                  <li><strong>Seek Constructive Feedback:</strong> Actively ask for feedback in a structured way, reducing uncertainty and anxiety about performance.</li>
                  <li><strong>Practice Assertiveness:</strong> Develop skills to express needs and boundaries without fear, promoting clearer communication.</li>
                  <li><strong>Engage in Professional Development:</strong> Pursue training to improve skills and self-efficacy, reducing feelings of inadequacy.</li>
              </ul>';
} elseif ($most_selected_option === 'c') {
    $html .= '<p><strong>Insecure avoidant attachment style</strong> often manifests in the workplace through behaviors such as emotional distance, reluctance to collaborate, and difficulty seeking help. Individuals may prioritize independence over teamwork, which can hinder communication and productivity.</p>';
    $html .= '<p><strong>Impacts on Productivity:</strong></p>
              <ul>
                  <li><strong>Limited Collaboration:</strong> Avoidant individuals may avoid sharing ideas or feedback, leading to missed opportunities for innovation.</li>
                  <li><strong>Reduced Engagement:</strong> A tendency to disengage from team dynamics can affect overall morale and motivation.</li>
                  <li><strong>Resistance to Feedback:</strong> They may struggle to accept constructive criticism, limiting personal and professional growth.</li>
              </ul>';
    $html .= '<p><strong>Strategies for Improvement:</strong></p>
              <ul>
                  <li><strong>Foster Open Communication:</strong> Create an environment where sharing ideas and concerns is encouraged. Regular check-ins can help.</li>
                  <li><strong>Build Trust:</strong> Team-building activities can enhance relationships, making it easier for avoidant individuals to feel safe and supported.</li>
                  <li><strong>Set Clear Expectations:</strong> Provide clarity around roles and responsibilities to reduce anxiety about collaboration.</li>
                  <li><strong>Encourage Small Steps:</strong> Start with low-stakes collaborations to gradually increase comfort levels in working with others.</li>
                  <li><strong>Provide Supportive Feedback:</strong> Frame feedback positively and constructively to help them feel more comfortable with it.</li>
              </ul>';
} elseif ($most_selected_option === 'd') {
    $html .= '<p><strong>Disorganized insecure attachment style</strong> in the workplace can manifest as unpredictability, difficulty with collaboration, and challenges in managing stress. Individuals may struggle with anxiety about their performance and relationships with colleagues, leading to inconsistent productivity.</p>';
    $html .= '<p><strong>Impact on Productivity:</strong></p>
              <ul>
                  <li><strong>Inconsistent Work Quality:</strong> Fluctuating motivation can lead to erratic performance.</li>
                  <li><strong>Poor Communication:</strong> Fear of judgment may cause avoidance of interactions, resulting in misunderstandings.</li>
                  <li><strong>Difficulty with Feedback:</strong> Resistance to constructive criticism can hinder personal and professional growth.</li>
                  <li><strong>High Stress Levels:</strong> Anxiety about tasks and relationships can lead to burnout.</li>
              </ul>';
    $html .= '<p><strong>Strategies for Improvement:</strong></p>
              <ul>
                  <li><strong>Cultivate a Supportive Environment:</strong> Foster open communication and encourage teamwork to reduce anxiety around collaboration.</li>
                  <li><strong>Set Clear Expectations:</strong> Establish defined roles and responsibilities to help individuals feel more secure in their contributions.</li>
                  <li><strong>Encourage Professional Development:</strong> Provide training on emotional intelligence and conflict resolution to build resilience.</li>
                  <li><strong>Promote Regular Feedback:</strong> Create a culture of constructive feedback that focuses on growth rather than judgment.</li>
                  <li><strong>Mindfulness and Stress Management:</strong> Offer resources for stress reduction, such as workshops or access to mental health support.</li>
              </ul>';
} else {
    $html .= '<p>No responses found or unable to determine the most selected attachment style.</p>';
}

// Write the table
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetProtection(array('print', 'copy'), $user_password, null, 0, null);

// Output the PDF as a file or to the browser
$pdf->Output("Assessment_Report_$employee_id.pdf", 'I');