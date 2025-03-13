<?php
require('../../../manager/fpdf186/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->setFont('Arial', '', 8);
        $this->Cell(10, 0, 'FM-IT-00-25-006/R1                                ');
        $this->Ln(8);
        $this->setFont('Arial', '', 14);
        $this->Cell(6, 0, 'FORM STOCK KOMPUTER ');
        $this->Ln(4);
        $this->setFont('Arial', '', 8);
        $this->setFillColor(222, 222, 222);
        $this->setX(10);
        $this->CELL(10, 6, 'NO', 1, 0, 'C', 1);
        $this->CELL(22, 6, 'UNIT/BAGIAN', 1, 0, 'C', 1);
        $this->CELL(20, 6, 'SUB.BAGIAN', 1, 0, 'C', 1);
        $this->CELL(20, 6, 'USER', 1, 0, 'C', 1);
        $this->CELL(25, 6, 'IDKOMPUTER', 1, 0, 'C', 1);
        $this->CELL(28, 6, 'NAMA KOMPUTER', 1, 0, 'C', 1);
        $this->CELL(20, 6, 'LOKASI', 1, 0, 'C', 1);
        $this->CELL(27, 6, 'PROCESSOR', 1, 0, 'C', 1);
        $this->CELL(25, 6, 'Motherboard', 1, 0, 'C', 1);
        $this->CELL(10, 6, 'Ram', 1, 0, 'C', 1);
        $this->CELL(13, 6, 'Harddisk', 1, 0, 'C', 1);
        $this->CELL(17, 6, 'Monitor', 1, 0, 'C', 1);
        $this->CELL(10, 6, 'OS', 1, 0, 'C', 1);
        $this->CELL(20, 6, 'TCP/IP', 1, 0, 'C', 1);
        $this->CELL(8, 6, 'Jum', 1, 0, 'C', 1);
        $this->CELL(8, 6, 'Total', 1, 0, 'C', 1);
        $this->Ln(6);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' ', 0, 0, 'R');
    }

    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}
?>