<?php
require_once ('../vendor/autoload.php');
require_once ('../includes/event-functions.inc.php');

session_start();
$usersId = $_SESSION['users_id'];

// Create new PDF document
class MYPDF extends TCPDF {
    public function Header() {
        // Perps Logo
        $image_file = '../static/img/logos/Perps-Logo.png';
        $this->Image($image_file, 7, 5, 120, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // CCS Logo
        $ccs_logo = '../static/img/logos/CCS-LOGO.png';
        $this->Image($ccs_logo, 230, 6, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // ISO Logo
        $iso_logo = '../static/img/logos/ISO.png';
        $this->Image($iso_logo, 253, 10, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Text
        $this->SetY(36); // Set position to below the logos
        $this->SetX(228);
        $this->SetFont('helvetica', 'BI', 12); // Set font to Helvetica, bold and italic, size 12
        $this->Cell(0, 10, 'COLLEGE OF COMPUTER STUDIES', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Red line
        $this->SetDrawColor(196, 91, 17); // Set color to red
        $this->SetLineWidth(0.7); // Set line width to thin
        $line_length = $this->getPageWidth() * .96; // 96% of page width
        $this->Line(13, 41, $line_length, 41); // Draw line
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);

        // Set draw color to rgb(136,60,12)
        $this->SetDrawColor(136, 60, 12);

        // Draw the thick line
        $this->SetLineWidth(1.1);
        $this->Line(13, $this->GetY(), $this->getPageWidth() - 15, $this->GetY());

        // Draw the thin line
        $this->SetLineWidth(0.3);
        $this->Line(13, $this->GetY() + 1.1, $this->getPageWidth() - 15, $this->GetY() + 1.1);

        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetY(-16); // Move up by 1mm
        $this->Cell(0, 10, 'UPHMO-CCS-GEN-911/rev0', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->SetX(20); // Move right by 20mm
        $this->Cell(0, 10, 'Post Activity Implemented Evaluation / Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, array(216, 330), true, 'UTF-8', false);

// set margins
$left_margin = 13;
$top_margin = 43; // adjust this value to increase/decrease the top margin
$right_margin = 15;
$pdf->SetMargins($left_margin, $top_margin, $right_margin);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Events Overview');

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

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

$html = '
    <h1 style="text-align: center;">Implemented Activities Evaluation Report</h1>
    <h2 style="text-align: center;">SEMESTER END REPORT</h2>
    <p style="text-align: center;">1<sup>st</sup> Semester AY 2023-2024</p>
    <table border="1" cellpadding="5">
    <thead>
        <tr>
            <th width="7%" style="text-align: center; font-weight: bold;">AREAS</th>
            <th width="14%" style="text-align: center; font-weight: bold;">ACTIVITY</th>
            <th width="15%" style="text-align: center; font-weight: bold;">OBJECTIVE</th>
            <th width="10%" style="text-align: center; font-weight: bold;">DATE OF THE ACTIVITY</th>
            <th width="8%" style="text-align: center; font-weight: bold;">STATUS</th>
            <th width="14%" style="text-align: center; font-weight: bold;">PROBLEM<br>ENCOUNTERED</th>
            <th width="10%" style="text-align: center; font-weight: bold;">ACTION TAKEN</th>
            <th width="14%" style="text-align: center; font-weight: bold;">RECOMMENDATION</th>
            <th width="8%" style="text-align: center; font-weight: bold;">REMARKS</th>
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
$totalRows = mysqli_num_rows($result);

$firstRow = true;

while ($event = mysqli_fetch_assoc($result)) {
    $objectives = explode(', ', $event['objectives_name']);
    $problems_encountered = explode(', ', $event['problems_encountered_name']);
    $actions_taken = explode(', ', $event['actions_taken_name']);
    $recommendations = explode(', ', $event['recommendations_name']);

    $html .= '<tr>';
    if ($firstRow) {
        $html .= '<td width="7%" style="text-align: center;" rowspan="' . $totalRows . '">ORGANIZATION AND ADMINISTRATION</td>';
        $firstRow = false;
    }
    $html .= '<td width="14%" style="text-align: center;">' . $event['events_name'] . '</td>
            <td width="15%">';
    if (!empty($objectives[0]) && $objectives[0] != 'N/A') {
        foreach ($objectives as $index => $objective) {
            $html .= ($index + 1) . '. ' . $objective . '<br>';
        }
    } else {
        $html .= '<div style="text-align: center;">N/A</div>';
    }
    $html .= '</td>
        <td width="10%" style="text-align: center;">' . date('F j, Y', strtotime($event['events_start_date'])) . '</td>
        <td width="8%" style="text-align: center;">' . $event['events_status'] . '</td>
        <td width="14%" style="text-align: center;">';
    if (!empty($problems_encountered[0]) && $problems_encountered[0] != 'N/A') {
        foreach ($problems_encountered as $index => $problem) {
            $html .= ($index + 1) . '. ' . $problem . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="10%" style="text-align: center;">';
    if (!empty($actions_taken[0]) && $actions_taken[0] != 'N/A') {
        foreach ($actions_taken as $index => $action) {
            $html .= ($index + 1) . '. ' . $action . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="14%" style="text-align: center;">';
    if (!empty($recommendations[0]) && $recommendations[0] != 'N/A') {
        foreach ($recommendations as $index => $recommendation) {
            $html .= ($index + 1) . '. ' . $recommendation . '<br>';
        }
    } else {
        $html .= 'N/A';
    }
    $html .= '</td>
        <td width="8%" style="text-align: center;">Excellent 4.77</td>
    </tr>';
}

// End of the first table
$html .= '</tbody></table>';

// Write HTML content to the PDF for the first table
$pdf->writeHTML($html, true, false, true, false, '');

// Start a new page
$pdf->AddPage();

// Reset the $html variable for the new page
$html = '';

// Fetch the event details for the documentation pictures
$sql = "SELECT events_name, events_start_date, events_end_date, events_venue, events_id FROM events ORDER BY events_start_date ASC";
$result = mysqli_query($conn, $sql);

while ($event = mysqli_fetch_assoc($result)) {
    $eventsId = $event['events_id'];
    $eventName = $event['events_name'];
    $startDate = date('F j, Y', strtotime($event['events_start_date']));
    $endDate = date('F j, Y', strtotime($event['events_end_date']));
    $startTime = date('h:i A', strtotime($event['events_start_date']));
    $endTime = date('h:i A', strtotime($event['events_end_date']));
    $venue = $event['events_venue'];

    error_reporting(E_ALL & ~E_WARNING);
    // Fetch 4 images related to the current event from the documentation_pictures table
    $sqlImages = "SELECT documentation_pictures_item FROM documentation_pictures 
                  JOIN event_documentation_pictures ON documentation_pictures.documentation_pictures_id = event_documentation_pictures.documentation_pictures_id 
                  WHERE event_documentation_pictures.events_id = " . $eventsId . " LIMIT 4";
    $resultImages = mysqli_query($conn, $sqlImages);

    // If there are no images, skip this event
    if (mysqli_num_rows($resultImages) == 0) {
        continue;
    }

    $html .= '
    <p style="text-align: center; font-weight: bold;">' . $eventName . '</p>
    ';
    $html .= '<p style="text-align: center;">' . $startDate . ' - ' . $endDate . ' | ' . $startTime . ' - ' . $endTime . ' | ' . $venue . '</p>';


    $html .= '<table style="width: 1000px;">';
    $imageCount = 0;
    $rowCount = 0;

    $numImages = mysqli_num_rows($resultImages);

    $html .= '<tr>'; // Start a new row

    while ($image = mysqli_fetch_assoc($resultImages)) {
        $imagePath = $image['documentation_pictures_item'];
        if (file_exists($imagePath)) {
        // Get the image dimensions
        list($width, $height) = getimagesize($imagePath);

        // Determine if the image is a portrait
        $isPortrait = $height > $width;

        // Set the image dimensions
        $imgWidth = $isPortrait ? 'auto' : '332px';
        $imgHeight = $isPortrait ? '400px' : '212px';

        // Add the image to the HTML string
        $html .= '<td style="text-align: center;"><img src="' . $imagePath . '" style="margin: 0; padding: 0; width: ' . $imgWidth . '; height: ' . $imgHeight . '; object-fit: cover; object-position: center;"></td>';

        $imageCount++;

        if ($numImages >= 4 && $imageCount % 2 == 0 && $imageCount < $numImages) {
            $html .= '</tr><tr>'; // Close the current row and start a new one
        }
        }
    }

    $html .= '</tr>'; // Close the last row

    $html .= '</table>';
    $html .= "\n";

    // Write HTML content to the PDF for the first table
    $pdf->writeHTML($html, true, false, true, false, '');

    // Start a new page
    $pdf->AddPage();

    // Reset the $html variable for the new page
    $html = '';
}

$html .= '  
<br><br><br><br><br><br>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th></th>
            <th style="text-align: center; font-weight: bold;">NAME</th>
            <th style="text-align: center; font-weight: bold;">SIGNATURE</th>
            <th style="text-align: center; font-weight: bold;">DESIGNATED</th>
            <th style="text-align: center; font-weight: bold;">DATE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; vertical-align: middle; font-weight: bold;" rowspan="2">Prepared By:</td>
            <td style="text-align: center;">Marienella Reggiette M. Odvina</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Secretary, College of Computer Studies Council</td>
            <td style="text-align: center;" rowspan="2">January 25, 2024</td>
        </tr>
        <tr>
            <td style="text-align: center;">Mhartin Joshua B. Derez</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">President, College of Computer Studies Council</td>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">Noted By:</td>
            <td style="text-align: center;">Dr. Pastor Arguelles Jr.</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Dean, College of Computer Studies</td>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">Reviewed & Endorsed by:</td>
            <td style="text-align: center;">Engr. Mariciel Teogangco</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Cluster Dean / Dean College of Engineering</td>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Ms. Kristina Rose G. Carlos, RGC, RPm</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Head, SAS/Dean of Students Affairs</td>
            <td style="text-align: center;"></td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">Approved by:</td>
            <td style="text-align: center;">Reno R. Rayel</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">School Director</td>
            <td style="text-align: center;"></td>
        </tr>
    </tbody>
</table>
';

// Write HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('events_overview.pdf', 'I');