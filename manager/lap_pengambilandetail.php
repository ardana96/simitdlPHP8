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
	background-color: #999;
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
if(isset($_GET['tanggal'])){
$tanggalbro=$_GET['tanggal'];
$idbarang=$_GET['idbarang'];

$tahun=substr($tanggalbro,0,4);
$bulan=substr($tanggalbro,-5,2);
$tanggal=substr($tanggalbro,-2,2);
$tglbaru=$tanggal.'-'.$bulan.'-'.$tahun;

$tanggal=true;

//$kd_toko=$_POST['kd_toko'];
$query_get_faktur="SELECT * from tpengambilan,trincipengambilan,bagian where 
tpengambilan.nofaktur=trincipengambilan.nofaktur and tpengambilan.bagian=bagian.id_bagian and
tpengambilan.tglambil BETWEEN '".$tanggalbro."' AND '".$tanggalbro."' and
trincipengambilan.idbarang='$idbarang' ";}
else{
$tanggal=false;

//$kd_toko=$_SESSION['kd_toko'];
$query_get_faktur="SELECT * from tpengambilan ";}

$get_faktur=mysql_query($query_get_faktur);
$count_faktur=mysql_num_rows($get_faktur);
$total_seluruh_beli=0; $total_seluruh_item=0; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body >
<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="5" align="center" class="judul_laporan"><p>Laporan Pengambilan</p>
      <p>Tanggal : <?php if($tanggal==true){ echo $tglbaru." s/d ".$tglbaru; } ?></p><br></td>
    </tr>
	<tr class="header_footer">
    <td>No Faktur</td>
	<td>Tanggal </td>
	<td>Pengambil</td>
	<td>Nama Barang </td>
    <td>Jumlah</td>
    <td>Permintaan</td>
	<td>Bagian</td>
	<td>Divisi</td>

  </tr>
<?php
for($i=0; $i<$count_faktur; $i++){
$faktur=mysql_fetch_array($get_faktur);
$nofaktur=$faktur['nofaktur'];
$id_user=$faktur['id_user'];
$tglbeli=$faktur['tglambil'];
$idsupp=$faktur['idsupp'];
$nama=$faktur['nama'];
$bagian=$faktur['bagian'];
$divisi=$faktur['divisi'];
$namasupp=$faktur['namasupp'];
$atas_nama=$faktur['atas_nama'];
$tgl=substr($tgl_pembelian,8,2);
$bln=substr($tgl_pembelian,5,2);
$thn=substr($tgl_pembelian,0,4);
$tglbeliformat=$tgl."-".$bln."-".$thn;
$total_pembelian=$faktur['total_pembelian']; ?>

 
 
<?
$cc="SELECT * FROM tsupplier WHERE idsupp='".$idsupp."' ";
$ccc=mysql_query($cc);
while($rinci=mysql_fetch_array($ccc)){
$namasupp=$rinci['namasupp'];}?>

   
  
  
  <?php
$query_get_rinci_pembelian="SELECT *,sum(jumlah) as jumta FROM trincipengambilan WHERE nofaktur='".$nofaktur."' and idbarang='$idbarang' group by idbarang ";
$get_rinci_pembelian=mysql_query($query_get_rinci_pembelian);
$total_item=0;
while($rinci_pembelian=mysql_fetch_array($get_rinci_pembelian)){
$nofaktur=$rinci_pembelian['nofaktur'];
$idbarang=$rinci_pembelian['idbarang'];
$namabarang=$rinci_pembelian['namabarang'];
$jumlah=$rinci_pembelian['jumlah'];
$jumta=$rinci_pembelian['jumta'];

$minta=mysql_query("select * from rincipermintaan where nofaktur='$nofaktur'");
 while($dminta=mysql_fetch_array($minta)){
 $nomorminta=$dminta['nomor'];}
 
 $peminta=mysql_query("select * from permintaan where nomor='$nomorminta'");
 while($dpeminta=mysql_fetch_array($peminta)){
 $nmpeminta=$dpeminta['nama'];
  $bagianpeminta=$dpeminta['bagian'];
  $divisi=$dpeminta['divisi'];}

 ?>
<tr class="isi_laporan">
<td><?php echo $nofaktur; ?>&nbsp;</td>
<td><?php echo $tglbeli; ?>&nbsp;</td>
<td><?php echo $nama.'/'.$bagian.'/'.$divisi; ?>&nbsp;</td>
    <td><?php echo $namabarang; ?>&nbsp;</td>
     <td>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $jumta; ?>&nbsp;</td>
    <td >
	<?php echo $nmpeminta; ?>&nbsp;</td>
	<td >
	<?php echo $bagianpeminta; ?>&nbsp;</td>
	<td >
	<?php echo $divisi; ?>&nbsp;</td>
  </tr>

  <tr>
<td colspan='8'><hr></td>
</tr>
<?php }?>


<?php }?>

</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>