<?php
session_start();
require_once '../vendor/autoload.php';
require_once 'db-connection.inc.php';
require_once "event-functions.inc.php";
require_once "report-generation-functions.inc.php";

$eventsId = $_GET['events_id'];
$usersUsername = $_SESSION["users_username"];
$eventName = getEventName($conn, $eventsId);
$totalExpenses = getTotalEventExpenses($conn, $eventsId);
$totalIncome = getTotalEventIncome($conn, $eventsId);

// Fetch initial budget
$initialBudget = getEventInitialBudget($conn, $eventsId);

// Fetch transactions
$transactions = getTransactions($conn, $eventsId);

// Fetch expenses, income, and remaining budget
$expenses = getEventExpenses($conn, $eventsId);
$income = getEventIncomes($conn, $eventsId);
$remainingBudget = getEventRemainingBudget($conn, $eventsId);

// Fetch managers
$managers = getEventManagers($conn, $eventsId);

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
$pdf->Bookmark('Initial Budget', 0, 0, '', 'B', array(0,64,128));
$pdf->Cell(0, 10, 'Initial Budget: PHP ' . number_format($initialBudget, 2), 0, 1);
$pdf->Bookmark('Total Expenses', 0, 0, '', 'B', array(0,64,128));
$pdf->Cell(0, 10, 'Total Expenses: PHP ' . number_format($totalExpenses, 2), 0, 1);
$pdf->Bookmark('Total Income', 0, 0, '', 'B', array(0,64,128));
$pdf->Cell(0, 10, 'Total Income: PHP ' . number_format($totalIncome, 2), 0, 1);
$pdf->Bookmark('Remaining Budget', 0, 0, '', 'B', array(0,64,128));
$pdf->Cell(0, 10, 'Remaining Budget: PHP ' . number_format($remainingBudget, 2), 0, 1);

// Add managers to PDF
$pdf->Bookmark('Event Managers', 0, 0, '', 'B', array(0,64,128));
$pdf->Cell(0, 10, 'Event Managers: ' . implode(', ', $managers), 0, 1);

// Colors, line width and bold font
$pdf->SetFillColor(0, 123, 255); // Change to your website's primary color
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 123, 255); // Change to your website's primary color
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

// Column titles
$header = array('Date', 'Name', 'Amount', 'Price', 'Total', 'Category');

// Header
$num_headers = count($header);
$cellWidth = 203 / $num_headers; // Adjust the cell width here

// Color and font restoration
$pdf->SetFillColor(224, 235, 255); // Change to your website's secondary color
$pdf->SetTextColor(0);
$pdf->SetFont('');

// Load transaction data
$expenseData = loadTransactionData($transactions, 'expense');
$incomeData = loadTransactionData($transactions, 'income');

// Generate transaction history
$pdf->Bookmark('Expenses Transaction History', 0, 0, '', 'B', array(0,64,128));
generateTransactionHistory($pdf, $expenseData, $header, $cellWidth, 'Expenses Transaction History');
$pdf->Ln(10); // Add a line break
$pdf->Bookmark('Income Transaction History', 0, 0, '', 'B', array(0,64,128));
generateTransactionHistory($pdf, $incomeData, $header, $cellWidth, 'Income Transaction History');

// Close and output PDF document
$pdf->Output($eventName . '_report.pdf', 'I');