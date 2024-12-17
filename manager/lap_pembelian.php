<?php
session_start();
include('../config.php');
?>

<style>
#pilih_laporan {
    background-color: #666; height: 30px; width: 100%;
    font-weight: bold; color: #FFF;
    text-transform: capitalize;}
#tampil_laporan{
    height: auto;width: 100%; overflow: auto;
    text-transform: capitalize;}
.judul_laporan{
    font-size: 14pt; font-weight: bold;
    color: #000; text-align: center;}
.header_footer{
    background-color: #F5F5F5;
    text-align: center; font-weight: bold;}
.isi_laporan{
    font-size: 10pt; color: #000;
    background-color: #FFF;}
.resume_laporan{
    background-color: #333;
    font-weight: bold; color: #FFF;}
@media print {  
#pilih_laporan{display: none;} } 
</style>

<?php
if (isset($_POST['button_filter'])) {
    $tanggal_awal = $_POST['tgl_awal'];
    $tanggal_akhir = $_POST['tgl_akhir'];

    $tanggal = true;

    // Query untuk mendapatkan data berdasarkan rentang tanggal
    $query_get_faktur = "SELECT * FROM tpembelian WHERE tglbeli BETWEEN ? AND ? ORDER BY tglbeli DESC";
    $params_get_faktur = [$tanggal_awal, $tanggal_akhir];
    $stmt_get_faktur = sqlsrv_query($conn, $query_get_faktur, $params_get_faktur);
} else {
    $tanggal = false;
    $tanggal_awal = date("Y-m-01");
    $tanggal_akhir = date("Y-m-t");

    $query_get_faktur = "SELECT * FROM tpembelian WHERE tglbeli BETWEEN ? AND ? ORDER BY tglbeli DESC";
    $params_get_faktur = [$tanggal_awal, $tanggal_akhir];
    $stmt_get_faktur = sqlsrv_query($conn, $query_get_faktur, $params_get_faktur);
}

// Inisialisasi variabel
$total_seluruh_beli = 0;
$total_seluruh_item = 0;

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Laporan</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td align="center">
                <form id="form_filter" name="postform2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <font color='white'>Tanggal Awal :</font> 
                    <input required="required" type="text" id="from" name="tgl_awal" class="isi_tabel" />
                    <font color='white'>Tanggal Akhir :</font>
                    <input required="required" type="text" id="from2" name="tgl_akhir" class="isi_tabel" />
                    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
                    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
                </form>
            </td>
        </tr>
    </table>
</div>

<div id="tampil_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td colspan="5" align="center" class="judul_laporan">
                <p>Laporan Pemasukan Barang</p>
                <p>Tanggal: <?php if ($tanggal) { echo $tanggal_awal . " s/d " . $tanggal_akhir; } ?></p><br>
            </td>
        </tr>
        <tr class="header_footer">
            <td>Tanggal</td>
            <td>Supplier</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
        </tr>

        <?php
        while ($faktur = sqlsrv_fetch_array($stmt_get_faktur, SQLSRV_FETCH_ASSOC)) {
            $nofaktur = $faktur['nofaktur'];
            $tglbeli = $faktur['tglbeli'];
            $idsupp = $faktur['idsupp'];

            // Ambil data supplier
            $query_supplier = "SELECT namasupp FROM tsupplier WHERE idsupp = ?";
            $stmt_supplier = sqlsrv_query($conn, $query_supplier, [$idsupp]);
            $supplier = sqlsrv_fetch_array($stmt_supplier, SQLSRV_FETCH_ASSOC);
            $namasupp = $supplier['namasupp'];
        ?>

        <tr>
            <td><?php echo $tglbeli->format('Y-m-d'); ?></td>
            <td><?php echo $namasupp; ?></td>
        </tr>

        <?php
        // Rincian pembelian
        $query_rinci_pembelian = "
            SELECT idbarang, namabarang, SUM(jumlah) AS jumta 
            FROM trincipembelian 
            WHERE nofaktur = ? 
            GROUP BY idbarang, namabarang";
        $stmt_rinci_pembelian = sqlsrv_query($conn, $query_rinci_pembelian, [$nofaktur]);

        while ($rinci_pembelian = sqlsrv_fetch_array($stmt_rinci_pembelian, SQLSRV_FETCH_ASSOC)) {
            $namabarang = $rinci_pembelian['namabarang'];
            $jumta = $rinci_pembelian['jumta'];
        ?>

        <tr>
            <td colspan='2'></td>
            <td><?php echo $namabarang; ?></td>
            <td><?php echo $jumta; ?></td>
        </tr>

        <?php } ?>

        <?php } ?>
    </table>
</div>
</body>
</html>
