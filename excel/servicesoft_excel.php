<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=software.xls"); // Ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

require('../config.php'); // Gunakan koneksi dari config.php

if (!$conn) {
    die("Koneksi ke server gagal: " . print_r(sqlsrv_errors(), true));
}

// Cek data dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$bln_akhir = isset($_POST['bln_akhir']) ? $_POST['bln_akhir'] : '';
$thn_akhir = isset($_POST['thn_akhir']) ? $_POST['thn_akhir'] : '';

// Validasi input bulan dan tahun
if (!is_numeric($bln_akhir) || !is_numeric($thn_akhir)) {
    die("Invalid input for month or year.");
}

// Query perbaikan dengan sorting berdasarkan kategori dan parameter binding
$sql = "SELECT software.*, divisi.*,
    CASE svc_kat
        WHEN 'LOW' THEN 1
        WHEN 'MEDIUM' THEN 2
        WHEN 'HIGH' THEN 3
        WHEN 'URGENT' THEN 4
        ELSE 0
    END AS angka
FROM software
INNER JOIN divisi ON software.divisi = divisi.kd
WHERE status = 'Selesai'
AND MONTH(tgl) = ?
AND YEAR(tgl) = ?
ORDER BY angka DESC, tgl ASC";

$params = [(int)$bln_akhir, (int)$thn_akhir];

error_log("Executing SQL: " . $sql);
error_log("With parameters: " . print_r($params, true));

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Query Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_has_rows($stmt)) {
    die("No data found for filter: Bulan $bln_akhir, Tahun $thn_akhir");
}

?>
<style>
.warna { background-color: #D3D3D3; }
</style>
<table width="100%" cellpadding="3" cellspacing="0" border="1">
<tr>
    <th align="center" colspan="8">
        <h4 align="right">FM-IT.00-25-005/R3</h4><br>
        <h2>DAFTAR PERMINTAAN PERBAIKAN PERANGKAT LUNAK</h2>
    </th>
</tr> 
<tr class="warna">
    <th>No</th>
    <th>Waktu</th>
    <th>User</th>
    <th>Permasalahan</th>
    <th>Penerima</th>
    <th>Status</th>
    <th>Kategori</th>
    <th>Lama</th>
</tr>
<?php
$no = 0;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $no++;
    $tgl = isset($database['tgl']) ? $database['tgl']->format('Y-m-d') : '';
    $tgl2 = isset($database['tgl2']) ? $database['tgl2']->format('Y-m-d') : '';
    $nama = $database['nama'];
    $bagian = $database['bagian'];
    $divisi = $database['namadivisi'];
    $kasus = $database['kasus'];
    $penerima = $database['penerima'];
    $teknisi = $database['oleh'];
    $status = $database['status'];
    $kategori = strtoupper($database['svc_kat']);
    
    // Perbaikan perhitungan lama waktu jika tgl2 ada
    if ($tgl2 && $tgl) {
        $date1 = date_create($tgl);
        $date2 = date_create($tgl2);
        $diff = date_diff($date1, $date2);
        $hbulan = $diff->days + 1;
    } else {
        $hbulan = 1;
    }

    ?>
    <tr class="isi_tabel">
        <td align="left" valign="top"><?php echo $no; ?></td>
        <td align="left" valign="top"><?php echo "&nbsp;" . $tgl; ?></td>
        <td align="left" valign="top"><?php echo $nama . "<br>" . $bagian . "-" . $divisi; ?></td>
        <td align="left" valign="top"><?php echo $kasus; ?></td>
        <td align="left" valign="top"><?php echo $penerima; ?></td>
        <td align="left" valign="top"><?php echo $status . "<br> -" . $teknisi . "(" . $tgl2 . ")"; ?></td>
        <td align="left" valign="top"><?php echo $kategori; ?></td>
        <td align="left" valign="top"><?php echo $hbulan . " hr"; ?></td>
    </tr>
    <?php
}
?>
</table>
