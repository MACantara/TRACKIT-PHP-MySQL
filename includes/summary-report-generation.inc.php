<?php
require_once('../vendor/autoload.php');
require_once('../includes/event-functions.inc.php');

session_start();
$usersId = $_SESSION['users_id'];

// Create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, array(216, 330), true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Events Overview');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

// Fetch the events from the database
$events = getUserEvents($conn, $usersId, 'ASC');

$html = '<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th width="7%">AREAS</th>
            <th width="10%">ACTIVITY</th>
            <th width="15%">OBJECTIVE</th>
            <th width="10%">DATE OF THE ACTIVITY</th>
            <th width="8%">STATUS</th>
            <th width="15%">PROBLEM<br>ENCOUNTERED</th>
            <th width="10%">ACTION TAKEN</th>
            <th width="17%">RECOMMENDATION</th>
            <th width="8%">REMARKS</th>
        </tr>
    </thead>
    <tbody>';

    $sql = "SELECT 
    events.events_name, 
    events.events_description, 
    events.events_start_date, 
    events.events_status, 
    GROUP_CONCAT(DISTINCT objectives.objectives_name SEPARATOR ', ') AS objectives_name, 
    GROUP_CONCAT(DISTINCT problems_encountered.problems_encountered_name SEPARATOR ', ') AS problems_encountered_name, 
    GROUP_CONCAT(DISTINCT actions_taken.actions_taken_name SEPARATOR ', ') AS actions_taken_name, 
    GROUP_CONCAT(DISTINCT recommendations.recommendations_name SEPARATOR ', ') AS recommendations_name 
FROM 
    events 
LEFT JOIN 
    event_objectives ON events.events_id = event_objectives.events_id 
LEFT JOIN 
    objectives ON event_objectives.objectives_id = objectives.objectives_id 
LEFT JOIN 
    event_problems_encountered ON events.events_id = event_problems_encountered.events_id 
LEFT JOIN 
    problems_encountered ON event_problems_encountered.problems_encountered_id = problems_encountered.problems_encountered_id 
LEFT JOIN 
    event_actions_taken ON events.events_id = event_actions_taken.events_id 
LEFT JOIN 
    actions_taken ON event_actions_taken.actions_taken_id = actions_taken.actions_taken_id 
LEFT JOIN 
    event_recommendations ON events.events_id = event_recommendations.events_id 
LEFT JOIN 
    recommendations ON event_recommendations.recommendations_id = recommendations.recommendations_id 
GROUP BY 
    events.events_id";

$result = mysqli_query($conn, $sql);

while ($event = mysqli_fetch_assoc($result)) {
    $objectives = explode(', ', $event['objectives_name']);
    $problems_encountered = explode(', ', $event['problems_encountered_name']);
    $actions_taken = explode(', ', $event['actions_taken_name']);
    $recommendations = explode(', ', $event['recommendations_name']);

    $html .= '<tr>
        <td width="7%">ORGANIZATION AND ADMINISTRATION</td>
        <td width="10%">' . $event['events_name'] . '</td>
        <td width="15%">';
    if (!empty($objectives[0]) && $objectives[0] != 'N/A') {
        foreach ($objectives as $index => $objective) {
            $html .= ($index + 1) . '. ' . $objective . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="10%">' . date('F j, Y', strtotime($event['events_start_date'])) . '</td>
        <td width="8%">' . $event['events_status'] . '</td>
        <td width="15%">';
    if (!empty($problems_encountered[0]) && $problems_encountered[0] != 'N/A') {
        foreach ($problems_encountered as $index => $problem) {
            $html .= ($index + 1) . '. ' . $problem . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="10%">';
    if (!empty($actions_taken[0]) && $actions_taken[0] != 'N/A') {
        foreach ($actions_taken as $index => $action) {
            $html .= ($index + 1) . '. ' . $action . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="17%">';
    if (!empty($recommendations[0]) && $recommendations[0] != 'N/A') {
        foreach ($recommendations as $index => $recommendation) {
            $html .= ($index + 1) . '. ' . $recommendation . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="8%">Excellent 4.77</td>
    </tr>';
}

$html .= '</tbody></table>';

// Write HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('events_overview.pdf', 'I');
?>