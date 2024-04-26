<?php
session_start();
require_once '../vendor/autoload.php';
require_once 'db-connection.inc.php';
require_once "event-functions.inc.php";
require_once "report-generation-functions.inc.php";

$eventId = $_GET['events_id'];
$usersUsername = $_SESSION["users_username"];
$eventName = getEventName($conn, $eventId);

// Fetch transactions
$transactions = getTransactions($conn, $eventId);

// Fetch expenses, income, and remaining budget
$expenses = getEventExpenses($conn, $eventId);
$income = getEventIncome($conn, $eventId);
$remainingBudget = getEventRemainingBudget($conn, $eventId);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($usersUsername);
$pdf->SetTitle($eventName .' Report');

// Set default header data
define('TRACKIT_HEADER_LOGO', 'wallet2.png');
define('TRACKIT_HEADER_LOGO_WIDTH', 15);
$pdf->SetHeaderData(TRACKIT_HEADER_LOGO, TRACKIT_HEADER_LOGO_WIDTH, 'TRACKIT', $eventName);

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
$pdf->SetFont('Helvetica', '', 12);

// Event Header
$pdf->SetFont('Helvetica', '', 24);
$pdf->Cell(0, 20, $eventName . " Generated Report", 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 12); // Reset font size to 12

// Expenses, Income, and Remaining Budget
$pdf->Cell(0, 10, 'Expenses: PHP ' . number_format($expenses, 2), 0, 1);
$pdf->Cell(0, 10, 'Income: PHP ' . number_format($income, 2), 0, 1);
$pdf->Cell(0, 10, 'Remaining Budget: PHP ' . number_format($remainingBudget, 2), 0, 1);

// Expenses Transaction History Header
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 20, 'Expenses Transaction History', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 12); // Reset font size to 12

// Column titles
$header = array('Date', 'Name', 'Description', 'Amount', 'Price', 'Category');

// Colors, line width and bold font
$pdf->SetFillColor(0, 123, 255); // Change to your website's primary color
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 123, 255); // Change to your website's primary color
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
$pdf->SetFillColor(224, 235, 255); // Change to your website's secondary color
$pdf->SetTextColor(0);
$pdf->SetFont('');

// Data loading for expense transactions
$expenseData = array();
foreach($transactions as $row) {
    if($row['transaction_type'] == 'expense') {
        $formattedAmount = formatNumber($row['transaction_amount']);
        $formattedPrice = formatNumber($row['transaction_price']);
        $expenseData[] = array($row['transaction_date'], $row['transaction_name'], $row['transaction_description'], $formattedAmount, $formattedPrice, $row['transaction_category']);
    }
}

// Expense Data
$fill = 0;
foreach($expenseData as $row) {
    for($i = 0; $i < $num_headers; ++$i) {
        $pdf->Cell($cellWidth, 6, $row[$i], 'LR', 0, 'L', $fill);
    }
    $pdf->Ln();
    $fill=!$fill;
}
$pdf->Cell(180, 0, '', 'T');

// Add a line break
$pdf->Ln(10);

// Data loading for income transactions
$incomeData = array();
foreach($transactions as $row) {
    if($row['transaction_type'] == 'income') {
        $formattedAmount = formatNumber($row['transaction_amount']);
        $formattedPrice = formatNumber($row['transaction_price']);
        $incomeData[] = array($row['transaction_date'], $row['transaction_name'], $row['transaction_description'], $formattedAmount, $formattedPrice, $row['transaction_category']);
    }
}

// Income Transaction History Header
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 20, 'Income Transaction History', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 12); // Reset font size to 12

// Colors, line width and bold font
$pdf->SetFillColor(0, 123, 255); // Change to your website's primary color
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 123, 255); // Change to your website's primary color
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

// Header
foreach($header as $col) {
    $pdf->Cell($cellWidth, 7, $col, 1, 0, 'C', 1);
}
$pdf->Ln();

// Color and font restoration
$pdf->SetFillColor(224, 235, 255); // Change to your website's secondary color
$pdf->SetTextColor(0);
$pdf->SetFont('');

// Income Data
$fill = 0;
foreach($incomeData as $row) {
    for($i = 0; $i < $num_headers; ++$i) {
        $pdf->Cell($cellWidth, 6, $row[$i], 'LR', 0, 'L', $fill);
    }
    $pdf->Ln();
    $fill=!$fill;
}
$pdf->Cell(180, 0, '', 'T');

// Close and output PDF document
$pdf->Output($eventName . '_report.pdf', 'I');