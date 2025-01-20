<?php
// Gunakan konfigurasi koneksi dari config.php
include('../config.php');

// Set header untuk file Excel
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=peminjaman.xls"); // Ganti nama sesuai keperluan
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
        <h4 align="right">FM-IT.00-25-001/R1</h4><br>
        <h2>PEMINJAMAN ALAT</h2>
    </th> 
</tr> 
<tr class="warna">
    <th>No</th>
    <th>Waktu</th>
    <th>Peminjam</th>
    <th>Jenis Perangkat</th>
    <th>Kembali</th>
</tr>

<?php
$no = 0;

// Query SQL Server dengan parameter
$sql = "
    SELECT tpinjam.tgl1, trincipinjam.tgl2, tpinjam.telp, trincipinjam.namabarang, 
               tpinjam.nama, bagian.bagian, tpinjam.divisi
        FROM tpinjam
        INNER JOIN trincipinjam ON tpinjam.nopinjam = trincipinjam.nopinjam
        INNER JOIN bagian ON tpinjam.bagian = bagian.id_bagian
        WHERE MONTH(tpinjam.tgl1) = '".$bln_akhir."' AND YEAR(tpinjam.tgl1) = '".$thn_akhir."'
        ORDER BY tpinjam.tgl1";

// Parameter untuk LIKE query SQL Server
$params = array($tanggal_akhir_format . '%');

// Eksekusi query
$query = sqlsrv_query($conn, $sql, $params);

// Cek jika query berhasil dijalankan
if ($query === false) {
    die("Error dalam query: " . print_r(sqlsrv_errors(), true));
}

// Loop untuk menampilkan hasil
while ($database = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $no++;
    $tgl1 = $database['tgl1']->format('Y-m-d');
    $tgl2 = $database['tgl2']->format('Y-m-d');
    $nama = strtoupper($database['nama']);
    $bagian = $database['bagian'];
    $barang = strtoupper($database['namabarang']);
    $divisi = $database['divisi'];

    // Format tanggal
    $tglbaru = date("d-m-Y", strtotime($tgl1));
    $tglbaru2 = date("d-m-Y", strtotime($tgl2));

?>
<tr class="isi_tabel">
    <td align="left" valign="top"><?php echo $no; ?></td>
    <td align="left" valign="top"><?php echo $tglbaru; ?></td>
    <td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian . "-" . $divisi; ?></td>
    <td align="left" valign="top"><?php echo $barang; ?></td>
    <td align="left" valign="top"><?php echo $tglbaru2; ?></td>
</tr>

<?php } ?>
</table>
