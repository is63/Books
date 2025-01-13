<?php
require_once 'Database.php';
require('mysql_table.php');
class PDF extends PDF_MySQL_Table
{
    function Header()
    {

        $this->SetFont('Courier', '', 18);
        $this->Cell(0, 6, ('Lista de Libros'), 0, 1, 'C');
        $this->Ln(10);

        parent::Header();
    }

    function Footer()
    {

        $this->SetY(-15);

        $this->SetFont('Courier', 'I', 8);

        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
?>