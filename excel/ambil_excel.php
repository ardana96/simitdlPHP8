<?php

// Gunakan konfigurasi koneksi dari config.php
include('../config.php');

// Set header untuk file Excel
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=pengambilan.xls"); // Ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari form (POST)
$status = $_POST['status'] ?? '';
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';
$tanggal_akhir = $thn_akhir . $bln_akhir;
$tanggal_akhir_format = $thn_akhir . "-" . $bln_akhir;

?>
<style>
.warna {
    background-color: #D3D3D3;
}
</style>
<table width="100%" cellpadding="3" cellspacing="0" border="1">
<tr>
    <th align="center" colspan="5">
        <h4 align="right">FM-IT.00-25-002/R1</h4><br>
        <h2>DAFTAR PENGAMBILAN</h2>
    </th> 
</tr> 
<tr class="warna">
    <th>No</th>
    <th>Barang</th>
    <th>QTY</th>
    <th>TGL</th>
    <th>Bagian / Nama</th>
</tr>

<?php
$no = 0;

// Query untuk mengambil data
$sql = "
    SELECT 
    d.namabarang, 
    a.nama, 
    c.bagian, 
    b.jumlah, 
    a.tglambil, 
    a.divisi
FROM tpengambilan a
LEFT JOIN trincipengambilan b ON a.nofaktur = b.nofaktur
LEFT JOIN bagian c ON a.bagian = c.id_bagian
LEFT JOIN tbarang d ON b.idbarang = d.idbarang
WHERE 
    (d.rutin = 'rutin' OR d.rutin IS NULL)
    AND (b.status IS NULL OR b.status <> 'perakitan')
    AND (a.bagian IS NULL OR a.bagian <> 'B079')
    AND (MONTH(a.tglambil) = '".$bln_akhir."' OR a.tglambil IS NULL)
    AND (YEAR(a.tglambil) = '".$thn_akhir."' OR a.tglambil IS NULL)
ORDER BY a.tglambil ASC;
";

// Parameter untuk LIKE query SQL Server
$params = array($tanggal_akhir_format . '%');

// Eksekusi query menggunakan koneksi dari config.php
$query = sqlsrv_query($conn, $sql, $params);

// Cek jika query berhasil dijalankan
if ($query === false) {
    die("Error dalam query: " . print_r(sqlsrv_errors(), true));
}

// Loop untuk menampilkan hasil
while ($download = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $no++;
    $namabarang = $download['namabarang'];
    $jumlah = $download['jumlah'];
    $tglambil = $download['tglambil']->format('Y-m-d'); // Format tanggal
    $nama = $download['nama'];
    $bagian = $download['bagian'];
    $divisi = $download['divisi'];
?>

<tr class="isi_tabel">
    <td align="left" valign="top"><?php echo $no; ?></td>
    <td align="left" valign="top"><?php echo $namabarang; ?></td>
    <td align="left" valign="top"><?php echo $jumlah; ?></td>
    <td align="left" valign="top"><?php echo $tglambil; ?></td>
    <td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian . "-" . $divisi; ?></td>
</tr>

<?php } ?>
</table>
