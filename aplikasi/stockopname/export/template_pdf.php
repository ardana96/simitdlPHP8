<?php
// Fungsi untuk mengonversi bulan numerik ke nama bulan
function getMonthName($month) {
    $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    return isset($months[$month]) ? $months[$month] : $month;
}

// Pastikan variabel $data tersedia (dikirim dari export_data.php)
if (!isset($data) || empty($data)) {
    echo "<h1>Tidak ada data untuk ditampilkan.</h1>";
    exit;
}

// Ambil bulan dari data pertama untuk judul (misalnya, "202311" -> "November 2023")
// Kode ini tetap ada untuk konsistensi, meskipun periode tidak ditampilkan
$bulanTahun = isset($data[0]['bulan']) ? $data[0]['bulan'] : '';
if ($bulanTahun) {
    $tahun = substr($bulanTahun, 0, 4);
    $bulan = substr($bulanTahun, 4, 2);
    $bulanNama = getMonthName($bulan);
    $periode = "$bulanNama $tahun";
} else {
    $periode = "Periode Tidak Diketahui";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FORM STOCK KOMPUTER</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
        margin: 10mm;
        padding: 0;
    }
    
    /* Kode Header */
    .header-code {
        font-size: 10pt;
        font-weight: bold;
        text-align: left;
        margin-bottom: 5mm; /* Beri jarak dari judul */
    }

    /* Judul Form */
    .title {
        font-size: 16pt;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-bottom: 10mm; /* Beri ruang sebelum tabel */
    }

    /* Styling Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5mm; /* Pastikan tabel turun sesuai kebutuhan */
    }

    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: center;
        font-size: 9pt;
    }

    th {
        background-color: #d3d3d3;
        font-weight: bold;
    }

    td {
        background-color: #ffffff;
    }

    .text-left {
        text-align: left;
    }
</style>

</head>
<body>
    <!-- <div class="header-code">FM-IT-00-25-006/R1</div>
    <div class="title">FORM STOCK KOMPUTER</div> -->
    <div class="header-code">FM-IT-00-25-006/R1</div>
    <h1 class="title">FORM STOCK KOMPUTER</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bagian</th>
                <th>Sub Bagian</th>
                <th>User</th>
                <th>ID PC</th>
                <th>Nama PC</th>
                <th>Lokasi</th>
                <th>Prosesor</th>
                <th>Motherboard</th>
                <th>RAM</th>
                <th>Harddisk</th>
                <th>Monitor</th>
                <th>OS</th>
                <th>TCP/IP</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $row) {
                $bagian = isset($row['divisi']) ? htmlspecialchars($row['divisi']) : '';
                $subBagian = isset($row['subbagian']) ? htmlspecialchars($row['subbagian']) : '';
                $user = isset($row['user']) ? htmlspecialchars($row['user']) : '';
                $idPc = isset($row['idpc']) ? htmlspecialchars($row['idpc']) : '';
                $namaPc = isset($row['namapc']) ? htmlspecialchars($row['namapc']) : '';
                $lokasi = isset($row['lokasi']) ? htmlspecialchars($row['lokasi']) : '';
                $prosesor = isset($row['prosesor']) ? htmlspecialchars($row['prosesor']) : '';
                $motherboard = isset($row['motherboard']) ? htmlspecialchars($row['motherboard']) : '';
                $ram = isset($row['ram']) ? htmlspecialchars($row['ram']) : '';
                $harddisk = isset($row['harddisk']) ? htmlspecialchars($row['harddisk']) : '';
                $monitor = isset($row['monitor']) ? htmlspecialchars($row['monitor']) : '';
                $os = isset($row['os']) ? htmlspecialchars($row['os']) : '';
                $tcpIp = isset($row['ippc']) ? htmlspecialchars($row['ippc']) : '';
                $jumlah = isset($row['jumlah']) ? htmlspecialchars($row['jumlah']) : '1';
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td class="text-left"><?php echo $bagian; ?></td>
                    <td class="text-left"><?php echo $subBagian; ?></td>
                    <td class="text-left"><?php echo $user; ?></td>
                    <td class="text-left"><?php echo $idPc; ?></td>
                    <td class="text-left"><?php echo $namaPc; ?></td>
                    <td class="text-left"><?php echo $lokasi; ?></td>
                    <td class="text-left"><?php echo $prosesor; ?></td>
                    <td class="text-left"><?php echo $motherboard; ?></td>
                    <td class="text-left"><?php echo $ram; ?></td>
                    <td class="text-left"><?php echo $harddisk; ?></td>
                    <td class="text-left"><?php echo $monitor; ?></td>
                    <td class="text-left"><?php echo $os; ?></td>
                    <td class="text-left"><?php echo $tcpIp; ?></td>
                    <td><?php echo $jumlah; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>