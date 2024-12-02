<?php
require('fpdf17/fpdf.php');

class PDF extends FPDF
{

// function Header1($bulan){
	// $this->Cell($bulan);
// }


function Header()
	{
// $this->setFont('Arial','',8,'C');
// $this->Cell(10,0,'                                                                                                                                                                                                                                                                                                                            FM-IT-00-25-007 / R2             ');
// $this->Ln(8);
// $this->setFont('Arial','',14,'C');
// $this->Cell(10,0,'PERAWATAN SOFTWARE DAN HARDWARE  ');
// $this->Ln(6);


// $this->setFont('Arial','',8);
// $this->setFillColor(222,222,222);

// $this->CELL(10,11,'NO',1,0,'C');
// $this->CELL(20,11,'BULAN',1,0,'C');
// $this->CELL(25,11,'TGL REALISASI',1,0,'C');
// $this->CELL(25,11,'ID',1,0,'C');
// $this->CELL(60,11,'NAMA PERANGKAT',1,0,'C');
// $this->CELL(100,5,'ITEM YANG DI CEK ',1,0,'C');
// $this->CELL(25,5,'PARAF',1,0,'C');
// $this->CELL(15,11,'KET',1,1,'C');
// $this->setY(29);
// $this->setX(150);
// $this->CELL(10,6,'OS',1,0,'C');
// $this->CELL(10,6,'APPS',1,0,'C');
// $this->CELL(10,6,'AV',1,0,'C');
// $this->CELL(10,6,'CPU',1,0,'C');
// $this->CELL(15,6,'MONITOR',1,0,'C');
// $this->CELL(15,6,'PRINTER',1,0,'C');
// $this->CELL(15,6,'SCANNER',1,0,'C');
// $this->CELL(15,6,'JARINGAN',1,0,'C');
// $this->CELL(15,6,'PETUGAS',1,0,'C');
// $this->CELL(10,6,'USER',1,1,'C');

	}
	
	function Header1($bulan)
	{
		// $this->setFont('Arial','',8,'C');
// $this->Cell(10,0,'                                                                                                                                                                                                                                                                                                                            FM-IT-00-25-007 / R3             ');
// $this->Ln(8);
// $this->setFont('Arial','',14,'C');
// $this->Cell(10,0,'PERAWATAN PROYEKTOR');

// $this->Ln(6);
// $this->setFont('Arial','',11);
// $this->Cell(10,0,'BULAN : '.$bulan);
// $this->Ln(6);

$this->setFont('Arial','',14,'C');
$this->CELL(285,5,'HASIL PERAWATAN HARDWARE',0,0,'C');
$this->Ln(7);		

$this->setFont('Arial','',11,'C');
$this->CELL(280,5,'FM-IT-00-25.3-010',0,0,'R');
$this->Ln(8);

$this->setFont('Arial','',12);
$this->Cell(10,0,'BULAN : '.$bulan);
$this->Ln(6);

$this->setFont('Arial','',12,'C');
$this->Cell(10,0,'Proyektor');
$this->Ln(6);


$this->setFont('Arial','',8);
$this->setFillColor(222,222,222);

$this->CELL(7,17,'NO',1,0,'C');
$this->CELL(25,17,'Lokasi',1,0,'C');
$this->CELL(20,8,'Tgl Perawatan','T',0,'C');
$this->CELL(25,8,'Tgl','LT',0,'C');
$this->CELL(37,17,'ID',1,0,'C');
$this->CELL(40,17,'NAMA PERANGKAT',1,0,'C');
$this->CELL(90,5,'ITEM YANG DI CEK ',1,0,'C');
$this->CELL(26,5,'NAMA',1,0,'C');
$this->CELL(15,17,'KET',1,1,'C');
$this->setY(45);
$this->setX(42);
$this->CELL(20,9,'Terjadwal','B',0,'C');
$this->CELL(25,9,'Realisasi','LB',0,'C');

$this->setY(45);
$this->setX(164);
$this->CELL(15,9,'Aset','BR',0,'C');
$this->CELL(19,9,'Proyektor','B',0,'C');
$this->CELL(16,9,'Filter Udara','LB',0,'C');
$this->CELL(20,9,'Lensa','LB',0,'C');
$this->CELL(20,9,'Pencahayaan','LB',0,'C');

$this->setY(42);
$this->setX(164);
$this->CELL(15,6,'Kesesuaian','R',0,'C');
$this->CELL(19,6,'Kondisi Fisik ','T',0,'C');
$this->CELL(16,6,'Kondisi','LR',0,'C');
$this->CELL(20,6,'Kondisi Lampu','LR',0,'C');
$this->CELL(20,6,'Kondisi','LR',0,'C');

$this->CELL(13,12,'Petugas',1,0,'C');
$this->CELL(13,12,'User',1,1,'C');




	}
	
	//Page Content
	function Content()
	{
	}

//Page footer
	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		//$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
		//nomor halaman
		$this->Cell(0,10,'Note: V = Kondisi Baik     X = Ditemukan Masalah ');
		$this->Cell(0,10,'Halaman '.$this->PageNo().' ',0,0,'R');
	}
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function RowWithCheck($data, $checkValue = '1')
{
    $columnWidths = $this->widths; 
    $cellHeight = 5; // Tinggi dasar per baris teks
    $maxHeight = $cellHeight;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	$this->CheckPageBreak($h);


    // Loop kedua untuk mencetak setiap cell dengan tinggi maksimum
    foreach ($data as $i => $col) {
        $cellWidth = isset($columnWidths[$i]) ? $columnWidths[$i] : 20;

		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

        // Jika kolom ini memerlukan gambar ceklis
        if ($col == $checkValue) {
            $this->Cell($cellWidth, $h, '', 1, 0); // Sel kosong dengan border
            $x = $this->GetX() - $cellWidth;
            $y = $this->GetY();
            $this->Image('check.png', $x + ($w / 2) - 2.5, $y + ($h / 2) - 2.5, 5, 5);
        } else {
            // Menggunakan MultiCell untuk teks, memastikan teks menyesuaikan tinggi sel
            $x = $this->GetX();
            $y = $this->GetY();
			$this->Rect($x,$y,$w,$h);	
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
            $this->SetXY($x + $cellWidth, $y); // Kembali ke posisi X yang benar setelah MultiCell
        }
    }
	
    // Baris baru setelah mencetak semua kolom
    $this->Ln($h);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>
