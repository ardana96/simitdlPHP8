<?php
session_start();
include('../config.php');
if(isset($_GET['nomor'])){
//Sumber untuk update spesifikasi 
$nomor=$_GET['nomor'];
$query = "SELECT * FROM permintaan WHERE nomor = ?";
$params = [$nomor];

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

// Periksa apakah eksekusi berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
}

// Loop melalui hasil query
while ($dataa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


$tgl=$dataa['tgl'] ? $dataa['tgl']->format('d-m-Y') : '';
$nama=$dataa['nama'];
$bagian=$dataa['bagian'];
$namabarang=$dataa['namabarang'];
$qty=$dataa['qty'];
$keterangan=$dataa['keterangan'];
$nomor=$dataa['nomor'];
//$nofaktur=$dataa['nofaktur'];
$keterangan=$dataa['keterangan'];
}}
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detail Permintaan</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="8" align="center" class="judul_laporan"><p>Laporan Detail Permintaan</p>
    </tr>
	  <tr>
    <td colspan="8" align="center" class="judul_laporan"><p>&nbsp </p>
    </tr>
	<tr>
	<td>Tgl Surat:<?php echo $tgl;?></td>
	<td>Nama  :<?php echo $nama;?></td>
		<td>Permintaan  :<?php echo $namabarang;?></td>
	</tr>
	<tr>
	<td>Qty :<?php echo $qty;?></td>
	<td>Bagian :<?php echo $bagian;?></td>
	<td>Keterangan :<?php echo $keterangan;?></td>
	</tr>
		<tr >
	<td colspan='3'><font color='red'><b>Pemasukan </b></font></td>
	</tr>
	  <tr class="header_footer" >
 <td>No Faktur</td>
   <td>Tgl Pembelian</td>
      <td>Nama Supplier</td>

   <td>Nama Barang</td>
    <td>Qty</td>

  
  </tr>
  
  <?php
// Query untuk mendapatkan data rincipermintaan
$query_b = "SELECT * FROM rincipermintaan WHERE nomor = ?";
$params_b = [$nomor];
$stmt_b = sqlsrv_query($conn, $query_b, $params_b);

if ($stmt_b === false) {
    die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
}

while ($datab = sqlsrv_fetch_array($stmt_b, SQLSRV_FETCH_ASSOC)) {
    $qtymasuk = $datab['qtymasuk'];
    $nofakturmasuk = $datab['nofaktur'];
    $qtykeluar = $datab['qtykeluar'];
    $nbbar = $datab['namabarang'];

    if ($qtymasuk > 0) {
        // Query untuk mendapatkan data dari tpembelian dan tsupplier
        $query_c = "SELECT tpembelian.tglbeli, tsupplier.namasupp, tpembelian.keterangan 
                    FROM tpembelian 
                    JOIN tsupplier ON tpembelian.idsupp = tsupplier.idsupp 
                    WHERE tpembelian.nofaktur = ?";
        $params_c = [$nofakturmasuk];
        $stmt_c = sqlsrv_query($conn, $query_c, $params_c);

        if ($stmt_c === false) {
            die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
        }

        while ($datac = sqlsrv_fetch_array($stmt_c, SQLSRV_FETCH_ASSOC)) {
            $tglbeli = $datac['tglbeli'] ? $datac['tglbeli']->format('d-m-Y') : '';
            $namasupp = $datac['namasupp'];
            $ket = $datac['keterangan'];
            ?>
            <tr>
                <td><?php echo $nofakturmasuk; ?></td>
                <td><?php echo $tglbeli; ?></td>
                <td><?php echo $namasupp; ?></td>
                <td><?php echo $nbbar; ?></td>
                <td><?php echo $qtymasuk; ?></td>
            </tr>
            <?php
        }
    } else {
        // Query untuk mendapatkan data dari tpc
        $query_f = "SELECT tglrakit FROM tpc WHERE idpc = ?";
        $params_f = [$nbbar];
        $stmt_f = sqlsrv_query($conn, $query_f, $params_f);

        if ($stmt_f === false) {
            die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
        }

        while ($dataf = sqlsrv_fetch_array($stmt_f, SQLSRV_FETCH_ASSOC)) {
            $tglrakit = $dataf['tglrakit'] ? $dataf['tglrakit']->format('d-m-Y') : '';
            ?>
            <tr>
                <td><?php echo $tglrakit; ?></td>
                <td><?php echo 'Stock PC (Perakitan / 1 Set PC)'; ?></td>
                <td><?php echo $nbbar; ?></td>
                <td><?php echo $qtymasuk; ?></td>
            </tr>
            <?php
        }
    }
}
?>

<tr>
	<td colspan='3'><font color='red'><b>Pengeluaran </b></font></td>
	</tr>
	<tr class="header_footer">
<td>No Faktur</td>
   <td>Tgl Pengambilan</td>
      <td>Nama / Bagian / Divisi</td>
	  

     <td>Nama Barang</td>
	 <td>Qty</td>

  
 
	 <?php
// Query untuk mendapatkan data dari rincipermintaan
$query_e = "SELECT * FROM rincipermintaan WHERE nomor = ?";
$params_e = [$nomor];
$stmt_e = sqlsrv_query($conn, $query_e, $params_e);

if ($stmt_e === false) {
    die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
}

while ($datae = sqlsrv_fetch_array($stmt_e, SQLSRV_FETCH_ASSOC)) {
    $qtymasuk = $datae['qtymasuk'];
    $nofakturkeluar = $datae['nofaktur'];
    $qtykeluar = $datae['qtykeluar'];
    $nb = $datae['namabarang'];

    if ($qtykeluar > 0) {
        // Query untuk mendapatkan data dari tpengambilan dan bagian
        $query_d = "SELECT tpengambilan.tglambil, tpengambilan.nama, bagian.bagian, tpengambilan.divisi 
                    FROM tpengambilan
                    JOIN bagian ON tpengambilan.bagian = bagian.id_bagian
                    WHERE tpengambilan.nofaktur = ?";
        $params_d = [$nofakturkeluar];
        $stmt_d = sqlsrv_query($conn, $query_d, $params_d);

        if ($stmt_d === false) {
            die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
        }

        while ($datad = sqlsrv_fetch_array($stmt_d, SQLSRV_FETCH_ASSOC)) {
            $tglambil = $datad['tglambil'] ? $datad['tglambil']->format('d-m-Y') : '';
            $nama = $datad['nama'];
            $bagian = $datad['bagian'];
            $divisi = $datad['divisi'];
            ?>
            <tr>
                <td><?php echo $nofakturkeluar; ?></td>
                <td><?php echo $tglambil; ?></td>
                <td><?php echo $nama . '/' . $bagian . '/' . $divisi; ?></td>
                <td><?php echo $nb; ?></td>
                <td><?php echo $qtykeluar; ?></td>
            </tr>
            <?php
        }
    }
}
?>


</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>


