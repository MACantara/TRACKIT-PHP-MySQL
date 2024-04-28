<?php

function formatNumber($num) {
    return 'PHP ' . number_format($num, 2);
}

function loadTransactionData($transactions, $transactionType) {
    $data = array();
    foreach($transactions as $row) {
        if($row['transaction_type'] == $transactionType) {
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

function generateTransactionHistory($pdf, $data, $header, $cellWidth, $title, $wordWrap = false) {
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
    foreach($header as $i => $col) {
        $width = $cellWidth;
        if ($col == 'Date') {
            $width *= 1.3;
        }
        if ($col == 'Amount') {
            $width /= 1.5;
        }
        if ($col == "Name") {
            $width /= 1.5;
        }
        if ($col == "Price") {
            $width /= 1.2;
        }
        if ($col == "Total") {
            $width *= 1.1;
        }
        if ($col == "Category") {
            $width /= 1.3;
        }
        $pdf->Cell($width, 7, $col, 1, 0, 'C', 1);
    }
    $pdf->Ln();

    // Color and font restoration
    $pdf->SetFillColor(224, 235, 255); // Change to your website's secondary color
    $pdf->SetTextColor(0);
    $pdf->SetFont('');

    // Data
    $fill = 0;
    foreach($data as $row) {
        for($i = 0; $i < count($header); ++$i) {
            $width = $cellWidth;
            if ($i == 0) {
                $width *= 1.3;
            }
            if ($i == 1) {
                $width /= 1.5;
            }
            if ($i == 2) { // 'Amount' is the third column
                $width /= 1.5;
            }
            if ($i == 3) {
                $width /= 1.2;
            }
            if ($i == 4) {
                $width *= 1.1;
            }
            if ($i == 5) {
                $width /= 1.3;
            }
            $pdf->Cell($width, 6, $row[$i], 'LR', 0, 'L', $fill);
        }
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(180, 0, '', 'T');
}