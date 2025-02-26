<?php
session_start();
require('../config.php');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=pemakaian_laptop.xls");
header("Pragma: no-cache");
header("Expires: 0");

$divisi = $_POST['divisi'] ?? '';

echo '<table border="1" cellpadding="3" cellspacing="0" width="100%">
<tr>
    <th colspan="15"><h2>PEMAKAIAN LAPTOP</h2></th>
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
</tr>';

$query = "SELECT * FROM pcaktif WHERE model = 'laptop' AND divisi LIKE ?";
$params = array("%$divisi%");
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo '<tr class="isi_tabel">
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($data['bagian']) . '</td>
        <td>' . htmlspecialchars($data['subbagian']) . '</td>
        <td>' . htmlspecialchars($data['user']) . '</td>
        <td>' . htmlspecialchars($data['idpc']) . '</td>
        <td>' . htmlspecialchars($data['namapc']) . '</td>
        <td>' . htmlspecialchars($data['lokasi']) . '</td>
        <td>' . htmlspecialchars($data['prosesor']) . '</td>
        <td>' . htmlspecialchars($data['mobo']) . '</td>
        <td>' . htmlspecialchars($data['ram']) . '</td>
        <td>' . htmlspecialchars($data['harddisk']) . '</td>
        <td>' . htmlspecialchars($data['monitor']) . '</td>
        <td>' . htmlspecialchars($data['os']) . '</td>
        <td>' . htmlspecialchars($data['ippc']) . '</td>
        <td>' . htmlspecialchars($data['jumlah']) . '</td>
    </tr>';
}

echo '</table>';
?>
