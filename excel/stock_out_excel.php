<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pengeluaran_Barang.xls");
header("Pragma: no-cache");
header("Expires: 0");

include('../config.php'); // Koneksi ke SQL Server

// Mengambil data dari POST
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';
$kd_barang = $_POST['kd_barang'] ?? '';
$tanggal_akhir_format = $thn_akhir . "-" . str_pad($bln_akhir, 2, "0", STR_PAD_LEFT);

// Konversi bulan ke nama
$bulan_arr = [
    "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
    "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
    "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
];

$bln_nama = $bulan_arr[$bln_akhir] ?? '';

?>
<style>
    .warna { background-color: #D3D3D3; }
</style>

<table width="100%" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th align="center" colspan="6"><h2>LAPORAN PENGELUARAN BARANG - <?php echo strtoupper($bln_nama) . " " . $thn_akhir; ?></h2></th>
    </tr>
    <tr class="warna">
        <th>No</th>
        <th>Nama</th>
        <th>Bagian</th>
        <th>Divisi</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
    </tr>

<?php
// Query ke SQL Server
$query = "SELECT a.nama, a.bagian, a.divisi, b.namabarang, b.jumlah 
          FROM tpengambilan a 
          JOIN trincipengambilan b ON a.nofaktur = b.nofaktur 
          WHERE b.idbarang = ? AND a.tglambil LIKE ?";

$params = [$kd_barang, $tanggal_akhir_format . '%'];
$get_data = sqlsrv_query($conn, $query, $params);

if ($get_data === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC)) {
    echo "<tr class='isi_tabel'>";
    echo "<td align='left' valign='top'>{$no}</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['nama']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['bagian']) . "</td>";
    echo "<td align='left' valign='top'>" . strtoupper(htmlspecialchars($database['divisi'])) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['namabarang']) . "</td>";
    echo "<td align='left' valign='top'>" . htmlspecialchars($database['jumlah']) . "</td>";
    echo "</tr>";
    $no++;
}
?>
</table>
