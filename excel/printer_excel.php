<?php
require('../config.php'); // Pastikan config.php sudah benar

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=daftar_printer.xls"); // Nama file Excel
header("Pragma: no-cache");
header("Expires: 0");

$status = $_POST['status'] ?? '';

// **Pastikan koneksi database valid**
if (!$conn) {
    die("Koneksi database tidak valid. Periksa konfigurasi di config.php. " . print_r(sqlsrv_errors(), true));
}

?>
<style>
.warna { background-color:#D3D3D3; }
</style>

<table width="100%" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th align="center" colspan="4"><h2>DAFTAR PEMAKAI PRINTER & SCANNER</h2></th>
    </tr>
    <tr class="warna">
        <th>NO</th>
        <th>ID Perangkat</th>
        <th>Jenis Printer</th>
        <th>Keterangan</th>
    </tr>

<?php
// **Mengambil data dari tabel printer**
$query_printer = "SELECT id_perangkat, printer, keterangan FROM printer WHERE status = ?";
$params = array($status);
$stmt_printer = sqlsrv_query($conn, $query_printer, $params);

if ($stmt_printer === false) {
    die("Kesalahan dalam query printer: " . print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($row = sqlsrv_fetch_array($stmt_printer, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>
            <td align='left'>{$no}</td>
            <td align='left'>{$row['id_perangkat']}</td>
            <td align='left'>{$row['printer']}</td>
            <td align='left'>{$row['keterangan']}</td>
          </tr>";
    $no++;
}

// **Mengambil data dari tabel scanner**
$query_scanner = "SELECT id_perangkat, printer, keterangan FROM scaner WHERE status = ?";
$stmt_scanner = sqlsrv_query($conn, $query_scanner, $params);

if ($stmt_scanner === false) {
    die("Kesalahan dalam query scanner: " . print_r(sqlsrv_errors(), true));
}

$no2 = 1;
while ($row2 = sqlsrv_fetch_array($stmt_scanner, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>
            <td align='left'>{$no2}</td>
            <td align='left'>{$row2['id_perangkat']}</td>
            <td align='left'>{$row2['printer']}</td>
            <td align='left'>{$row2['keterangan']}</td>
          </tr>";
    $no2++;
}
?>

</table>
