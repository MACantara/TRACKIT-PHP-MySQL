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
$events = getUserEvents($conn, $usersId);

$html = '<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Status</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>';

foreach ($events as $event) {
    $html .= '<tr>
        <td>' . $event['events_status'] . '</td>
        <td>' . $event['events_name'] . '</td>
        <td>' . $event['events_description'] . '</td>
        <td>' . date('F j, Y, h:i A', strtotime($event['events_date'])) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Write HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('events_overview.pdf', 'I');
?>