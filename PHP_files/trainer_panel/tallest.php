<?php

require('fpdf182/fpdf.php');
require '../includes/dbh.inc.php';
session_start();

$current_trainer = $_SESSION['session_UsernameID'];


class PDF extends FPDF
{
// Page header
    function Header()
    {

        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(50);
        // Title
        $this->Cell(30, 10, 'Customers That Choice You', 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);


$sql = "select UsernameID, Length from customer where  TrainerID= '$current_trainer' order by  Length desc ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $pdf->Cell(0, 10, "Username: " . $row['UsernameID'] . " Length: " . $row['Length'], 0, 1);

    }
    $pdf->Output();
}
