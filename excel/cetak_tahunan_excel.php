<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Stock.xls"); // Ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

include('../config.php'); // Koneksi ke SQL Server

if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// $divisi = $_POST['divisi'] ?? ''; // Jika kosong, tampilkan semua divisi
$bln_akhir = $_POST['bln_akhir'];
$thn_akhir = $_POST['thn_akhir'];
$tanggal_akhir_format = $bln_akhir . "-" . $thn_akhir;
?>
<style>
.warna {background-color: #D3D3D3;}
</style>
<table width="100%" cellpadding="3" cellspacing="0" border="1">
<tr>
    <th align="center" colspan="6"><h2>LAPORAN STOCK</h2></th>
</tr>
<tr class="warna">
    <th>Divisi</th>
    <th>Nama Barang</th>
    <th>Awal</th>
    <th>Masuk</th>
    <th>Keluar</th>
    <th>Sisa</th>
</tr>
<?php
$query_barang = "SELECT tbarang.*, tpengambilan.divisi 
                 FROM tbarang 
                 LEFT JOIN trincipengambilan ON tbarang.idbarang = trincipengambilan.idbarang 
                 LEFT JOIN tpengambilan ON trincipengambilan.nofaktur = tpengambilan.nofaktur
                 WHERE report = 'y' 
                 AND YEAR(tpengambilan.tglambil) = ? 
                 AND MONTH(tpengambilan.tglambil) = ?";

$params = [$thn_akhir, $bln_akhir];

// Jika divisi dipilih, tambahkan filter
if (!empty($divisi)) {
    $query_barang .= " AND tpengambilan.divisi = ?";
    $params[] = $divisi;
}

$query_barang .= " ORDER BY tpengambilan.divisi, tbarang.namabarang";
$result_barang = sqlsrv_query($conn, $query_barang, $params);

if (!$result_barang) {
    die(print_r(sqlsrv_errors(), true));
}

while ($datarinci = sqlsrv_fetch_array($result_barang, SQLSRV_FETCH_ASSOC)) {
    $divisi_barang = $datarinci['divisi'] ?? 'N/A';
    $namabarang = $datarinci['namabarang'];
    $idbarang = $datarinci['idbarang'];

    $tambah = 0;
    $kurang = 0;

    $query_stock = "SELECT stockawal FROM tbarang WHERE idbarang = ?";
    $result_stock = sqlsrv_query($conn, $query_stock, [$idbarang]);
    $dat = sqlsrv_fetch_array($result_stock, SQLSRV_FETCH_ASSOC);
    $stockawal = $dat['stockawal'] ?? 0;

    $query_pembelian = "SELECT SUM(jumlah) AS jumta FROM trincipembelian tp 
                        INNER JOIN tpembelian t ON tp.nofaktur = t.nofaktur
                        WHERE tp.idbarang = ? AND YEAR(t.tglbeli) = ? AND MONTH(t.tglbeli) = ?";
    $result_pembelian = sqlsrv_query($conn, $query_pembelian, [$idbarang, $thn_akhir, $bln_akhir]);
    $data_pembelian = sqlsrv_fetch_array($result_pembelian, SQLSRV_FETCH_ASSOC);
    $jumm = $data_pembelian['jumta'] ?? 0;

    $query_pengambilan = "SELECT SUM(jumlah) AS jumta FROM trincipengambilan tp 
                          INNER JOIN tpengambilan t ON tp.nofaktur = t.nofaktur
                          WHERE tp.idbarang = ? AND YEAR(t.tglambil) = ? AND MONTH(t.tglambil) = ?";
    $result_pengambilan = sqlsrv_query($conn, $query_pengambilan, [$idbarang, $thn_akhir, $bln_akhir]);
    $data_pengambilan = sqlsrv_fetch_array($result_pengambilan, SQLSRV_FETCH_ASSOC);
    $jummb = $data_pengambilan['jumta'] ?? 0;

    $stockawal = $stockawal + $jumm - $jummb;
    $sisa = $stockawal;
?>
<tr class="isi_tabel">
    <td align="left" valign="top"><?php echo $divisi_barang; ?></td>
    <td align="left" valign="top"><?php echo $namabarang; ?></td>
    <td align="left" valign="top"><?php echo $stockawal; ?></td>
    <td align="left" valign="top"><?php echo $tambah; ?></td>
    <td align="left" valign="top"><?php echo $kurang; ?></td>
    <td align="left" valign="top"><?php echo $sisa; ?></td>
</tr>
<?php } ?>
</table>
