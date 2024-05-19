<?php

function formatNumber($num)
{
    return 'PHP ' . number_format($num, 2);
}

function loadTransactionData($transactions, $transactionType)
{
    $data = array();
    foreach ($transactions as $row) {
        if ($row['transaction_type'] == $transactionType) {
            $formattedAmount = number_format($row['transaction_amount'], 2);
            $formattedPrice = formatNumber($row['transaction_price']);
            $transactionTotal = $row['transaction_amount'] * $row['transaction_price'];
            $formattedTotal = formatNumber($transactionTotal);

            // Format the transaction date to 12-hour format
            $date = new DateTime($row['transaction_date']);
            $formattedDate = $date->format('Y-m-d g:i A');

            $data[] = array($formattedDate, $row['transaction_name'], $formattedAmount, $formattedPrice, $formattedTotal, $row['transaction_category']);
        }
    }
    return $data;
}

function generateTransactionHistory($pdf, $data, $header, $title)
{
    // Transaction History Header
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(0, 20, $title, 0, 1, 'C');
    $pdf->SetFont('Helvetica', '', 12); // Reset font size to 12

    // Colors, line width and bold font
    $pdf->SetFillColor(0, 123, 255); // Change to your website's primary color
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(0, 123, 255); // Change to your website's primary color
    $pdf->SetLineWidth(0.3);
    $pdf->SetFont('', 'B');

    // Header
    $html = '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';
    $html .= '<thead style="background-color: #007BFF; color: #FFF;">';
    $html .= '<tr>';
    foreach ($header as $col) {
        $html .= '<th style="background-color: #007BFF; color: #FFF;">' . $col . '</th>';
    }
    $html .= '</tr>';
    $html .= '</thead>';

    // Color and font restoration
    $pdf->SetFillColor(224, 235, 255); // Change to your website's secondary color
    $pdf->SetTextColor(0);
    $pdf->SetFont('');

    // Data
    $html .= '<tbody style="background-color: #E0EBFF; color: #000;">';
    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td>' . $cell . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';

    // Write HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');
}