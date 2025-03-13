<?php
// Pastikan variabel $data dan $pdf tersedia dari exportpdf_data.php
if (!isset($data) || !isset($pdf) || empty($data)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Tidak ada data yang tersedia!', 0, 1, 'C');
    return;
}

// Set lebar kolom sesuai dengan header di class PDF
$widths = array(10, 22, 20, 20, 25, 28, 20, 27, 25, 10, 13, 17, 10, 20, 8, 8); // Total 16 kolom (termasuk "Total")
$aligns = array('C', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');

// Set lebar dan alignment untuk tabel
$pdf->SetWidths($widths);
$pdf->SetAligns($aligns);

// Data tabel
$no = 1;
$totalJumlah = 0; // Untuk menghitung total "Jum"

foreach ($data as $row) {
    $jumlah = isset($row['jumlah']) ? (int)$row['jumlah'] : 0;
    $totalJumlah += $jumlah;

    $pdf->Row(array(
        $no++,
        $row['divisi'],
        $row['subbagian'],
        $row['user'],
        $row['idpc'],
        $row['namapc'],
        $row['lokasi'],
        $row['prosesor'],
        $row['mobo'],
        $row['ram'],
        $row['harddisk'],
        $row['monitor'],
        $row['os'],
        $row['ippc'],
        $row['jumlah'] ?? 'N/A',
        '' // Kolom "Total" akan diisi di baris terakhir
    ));
}

// Tambahkan baris untuk Total
$pdf->Row(array(
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    'Total:',
    $totalJumlah,
    ''
));
?>