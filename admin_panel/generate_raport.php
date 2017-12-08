<?php

include "../db.php";
require('../fpdf/fpdf.php');

$pdf_query = "SELECT client.nume, client.prenume, directia.denumire as directia, client.numar_tel, client.suma, client.commentariu, client.data FROM client INNER JOIN directia ON client.id_directia=directia.id_directia WHERE client.commentariu NOT LIKE 'Achitat%' ORDER BY nume";
$pdf_result = $connection->query($pdf_query);

$pdf_query2 = "SELECT client.nume, client.prenume, directia.denumire as directia, client.numar_tel, client.suma, client.commentariu, client.data, client.sistema FROM client INNER JOIN directia ON client.id_directia=directia.id_directia WHERE client.commentariu LIKE 'Achitat%' ORDER BY nume";
$pdf_result2 = $connection->query($pdf_query2);



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(255, 0, 0);
$pdf->SetFontSize(10);

$pdf->Cell(30,10, 'Nume', 1, '0', 'C', true);
$pdf->Cell(30,10, 'Prenume', 1, '0', 'C', true);
$pdf->Cell(26,10, 'Directia', 1, '0', 'C', true);
$pdf->Cell(22,10, 'Telefon', 1, '0', 'C', true);
$pdf->Cell(15,10, 'Suma', 1, '0', 'C', true);
$pdf->Cell(40, 10, 'Comentariu', 1, '0', 'C', true);
$pdf->Cell(35, 10, 'Data', 1, '0', 'C', true);
$pdf->ln();

while($row = $pdf_result->fetch_assoc()) {
    $pdf->Cell(30,10, $row['nume'], 1);
    $pdf->Cell(30,10, $row['prenume'], 1);
    $pdf->Cell(26,10, $row['directia'], 1);
    $pdf->Cell(22,10, $row['numar_tel'], 1);
    $pdf->Cell(15,10, $row['suma'], 1);
    $pdf->Cell(40,10, $row['commentariu'], 1);
    $pdf->Cell(35, 10, $row['data'], 1);
    $pdf->ln();
}

$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(255, 255, 0);
$pdf->SetFontSize(10);

$pdf->Cell(30,10, 'Nume', 1, '0', 'C', true);
$pdf->Cell(30,10, 'Prenume', 1, '0', 'C', true);
$pdf->Cell(26,10, 'Directia', 1, '0', 'C', true);
$pdf->Cell(22,10, 'Telefon', 1, '0', 'C', true);
$pdf->Cell(35, 10, 'Comentariu', 1, '0', 'C', true);
$pdf->Cell(35, 10, 'Data', 1, '0', 'C', true);
$pdf->Cell(20,10, 'Modalitate', 1, '0', 'C', true);
$pdf->ln();

while($row = $pdf_result2->fetch_assoc()) {
    $pdf->Cell(30,10, $row['nume'], 1);
    $pdf->Cell(30,10, $row['prenume'], 1);
    $pdf->Cell(26,10, $row['directia'], 1);
    $pdf->Cell(22,10, $row['numar_tel'], 1);
    $pdf->Cell(35,10, $row['commentariu'], 1);
    $pdf->Cell(35, 10, $row['data'], 1);
    $pdf->Cell(20, 10, $row['sistema'], 1);
    $pdf->ln();
}

$pdf->Output();

