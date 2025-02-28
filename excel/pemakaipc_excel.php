<?php
require('../config.php'); // Menggunakan koneksi dari config.php

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=pemakaipc.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil parameter dari form
$id_divisi = $_POST['id_divisi'] ?? '';
$status = $_POST['status'] ?? '';
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';

// Format tanggal untuk SQL Server
$tanggal_akhir_format = str_pad($bln_akhir, 2, '0', STR_PAD_LEFT) . "-" . $thn_akhir;

?>
<style>
.warna { background-color: #D3D3D3; }
</style>

<table border="1" cellpadding="3" cellspacing="0" width="100%">
    <tr>
        <th align="center" colspan="15"><h2>DAFTAR PEMAKAI PC</h2></th> 
    </tr>
    <tr class="warna">
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

<?php
$no = 1;

// Query dengan SQLSRV
$query = "SELECT * FROM pcaktif WHERE divisi LIKE ? AND model = 'CPU' ORDER BY idpc ASC";
$params = ["%$id_divisi%"];
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Looping untuk menampilkan data
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr class='isi_tabel'>";
    echo "<td align='left' valign='top'>" . $no++ . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['bagian']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['subbagian']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['user']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['idpc']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['namapc']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['lokasi']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['prosesor']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['mobo']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['ram']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['harddisk']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['monitor']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['os']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['ippc']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['jumlah']) . "</td>";
    echo "</tr>";
}
?>

</table>
