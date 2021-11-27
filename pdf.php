<?php
if(!empty($_POST['submit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    
    require("fpdf/fpdf.php");
    $pdf = new FPDF();

    $pdf->AddPage();

    $pdf->SetFont("Arial","B",12);
    $pdf->Cell(0,10,"registraion",1,1,'C');

    $pdf->Cell(40,10,"name",1,0);
    $pdf->Cell(40,10,"phone",1,0);
    $pdf->Cell(40,10,"email",1,0);
    $pdf->Cell(0,10,"amount",1,1);

    $pdf->Cell(40,10,"$name",1,0);
    $pdf->Cell(40,10,"$phone",1,0);
    $pdf->Cell(40,10,"$email",1,0);
    $pdf->Cell(0,10,"$amount",1,1);
    $pdf->output();
}


?>