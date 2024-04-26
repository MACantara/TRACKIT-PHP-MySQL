<?php
session_start();
require_once '../vendor/autoload.php';
require_once 'db-connection.inc.php';
require_once "event-functions.inc.php";

$eventId = $_GET['events_id'];
$usersUsername = $_SESSION["users_username"];
$eventName = getEventName($conn, $eventId);

// Fetch transactions
$sql = "SELECT * FROM transaction_history WHERE events_id = ? ORDER BY transaction_date DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);


// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($usersUsername);
$pdf->SetTitle($eventName .' Report');

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

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Column titles
$header = array('Date', 'Name', 'Description', 'Amount', 'Price', 'Category', 'Type');

// Data loading
$data = array();
foreach($transactions as $row) {
    $data[] = array($row['transaction_date'], $row['transaction_name'], $row['transaction_description'], $row['transaction_amount'], $row['transaction_price'], $row['transaction_category'], $row['transaction_type']);
}

// Colors, line width and bold font
$pdf->SetFillColor(255, 0, 0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

// Header
$num_headers = count($header);
$cellWidth = 180 / $num_headers; // Adjust the cell width here
for($i = 0; $i < $num_headers; ++$i) {
    $pdf->Cell($cellWidth, 7, $header[$i], 1, 0, 'C', 1);
}
$pdf->Ln();

// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');

// Data
$fill = 0;
foreach($data as $row) {
    for($i = 0; $i < $num_headers; ++$i) {
        $pdf->Cell($cellWidth, 6, $row[$i], 'LR', 0, 'L', $fill);
    }
    $pdf->Ln();
    $fill=!$fill;
}
$pdf->Cell(210, 0, '', 'T');

// Close and output PDF document
$pdf->Output('report.pdf', 'I');