<?php
// Bersihkan output buffer sebelum mengirim header
ob_end_clean();
ob_start();

// Set header agar file di-download sebagai Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=export_peripheral_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tambahkan BOM UTF-8 agar karakter terbaca dengan benar di Excel
echo "\xEF\xBB\xBF";

// Ambil data dari file JSON sementara
$jsonFile = '../excel/export_data_peripheral.json';

if (!file_exists($jsonFile)) {
    die("<h2 style='color:red; text-align:center;'>Data tidak ditemukan!</h2>");
}

$data = json_decode(file_get_contents($jsonFile), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("<h2 style='color:red; text-align:center;'>Gagal mem-parsing file JSON: " . json_last_error_msg() . "</h2>");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        .header {
            background-color: #D3D3D3;
            font-weight: bold;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <th colspan="8" style="text-align:center;"><h2>DAFTAR PERANGKAT PERIPHERAL</h2></th>
        </tr>
        <tr class="header">
            <th>Nomor</th>
            <th>ID Perangkat</th>
            <th>Nama Perangkat</th>
            <th>Tipe</th>
            <th>User</th>
            <th>Divisi</th>
            <th>Bulan</th>
            <th>Tanggal Perawatan</th>
        </tr>

        <?php 
        if (!empty($data) && is_array($data)) {
            foreach ($data as $row) {
                // Pastikan semua kolom ada sebelum menampilkannya
                $nomor = isset($row['nomor']) ? htmlspecialchars($row['nomor'], ENT_QUOTES, 'UTF-8') : '';
                $id_perangkat = isset($row['id_perangkat']) ? htmlspecialchars($row['id_perangkat'], ENT_QUOTES, 'UTF-8') : '';
                $perangkat = isset($row['perangkat']) ? htmlspecialchars($row['perangkat'], ENT_QUOTES, 'UTF-8') : '';
                $tipe = isset($row['tipe']) ? htmlspecialchars($row['tipe'], ENT_QUOTES, 'UTF-8') : '';
                $user = isset($row['user']) ? htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8') : '';
                $divisi = isset($row['divisi']) ? htmlspecialchars($row['divisi'], ENT_QUOTES, 'UTF-8') : '';
                $bulan = isset($row['bulan']) ? htmlspecialchars($row['bulan'], ENT_QUOTES, 'UTF-8') : '';
                $tgl_perawatan = isset($row['tgl_perawatan']) ? htmlspecialchars($row['tgl_perawatan'], ENT_QUOTES, 'UTF-8') : '';
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $id_perangkat; ?></td>
                    <td><?php echo $perangkat; ?></td>
                    <td><?php echo $tipe; ?></td>
                    <td><?php echo $user; ?></td>
                    <td><?php echo $divisi; ?></td>
                    <td><?php echo $bulan; ?></td>
                    <td><?php echo $tgl_perawatan; ?></td>
                </tr>
            <?php 
            }
        } else { ?>
            <tr>
                <td colspan="8" style="text-align:center; font-weight:bold; color:red;">Tidak ada data yang tersedia!</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
// Pastikan semua output dikirim dan buffer dibersihkan
ob_end_flush();
?>