<?php
require('fpdf17/fpdf.php');

class PDF extends FPDF
{
    // Fungsi untuk membuat header tabel dengan MultiCell
    function TableHeader($header, $columnWidths)
    {
        $this->SetFont('Arial', 'B', 10);
        
        // Loop untuk setiap kolom header
        foreach ($header as $index => $col) {
            // Set lebar kolom dan tinggi baris
            $this->SetX($this->GetX()); // Memastikan posisi X saat ini tetap
            $this->MultiCell($columnWidths[$index], 10, $col, 1, 'C');
            $this->SetXY($this->GetX() + $columnWidths[$index], $this->GetY() - 10); // Pindah ke kolom berikutnya
        }
        $this->Ln(); // Baris baru setelah header
    }

    // Fungsi untuk membuat baris data
    function TableRow($data, $columnWidths)
    {
        $this->SetFont('Arial', '', 10);
        
        foreach ($data as $index => $col) {
            $this->Cell($columnWidths[$index], 10, $col, 1, 0, 'C');
        }
        $this->Ln();
    }
}

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = 'dlris30g';
$database = 'sitdl';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pdf = new PDF();
$pdf->AddPage();

// Ambil header tabel dari database
$header = array();
$query_header = "SELECT nama_perawatan FROM tipe_perawatan_item";
$result_header = $conn->query($query_header);

while ($row = $result_header->fetch_assoc()) {
    $header[] = $row['nama_perawatan'];
}

// Tentukan lebar kolom (disesuaikan agar muat)
$columnWidths = array(30, 40, 30, 50); // Disesuaikan dengan jumlah dan panjang header

// Tampilkan header tabel di PDF
$pdf->TableHeader($header, $columnWidths);

// Ambil data isi tabel dari database
$query_data = "SELECT * FROM perawatan	";
$result_data = $conn->query($query_data);

while ($row = $result_data->fetch_assoc()) {
    $pdf->TableRow(array_values($row), $columnWidths);
}

// Tutup koneksi
$conn->close();

// Output PDF
$pdf->Output();
?>
