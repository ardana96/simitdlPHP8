<?php
session_start();
include('../config.php');
if(isset($_GET['nomor'])){
//Sumber untuk update spesifikasi 
$nomor=$_GET['nomor'];
 $a= mysql_query("SELECT * from permintaan where nomor='$nomor'");
	while($dataa= mysql_fetch_array($a)){
$tgl=$dataa['tgl'];
$nama=$dataa['nama'];
$bagian=$dataa['bagian'];
$namabarang=$dataa['namabarang'];
$qty=$dataa['qty'];
$keterangan=$dataa['keterangan'];
$nomor=$dataa['nomor'];
$nofaktur=$dataa['nofaktur'];
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
	<td>Tgl Surat:<?echo $tgl;?></td>
	<td>Nama  :<?echo $nama;?></td>
		<td>Permintaan  :<?echo $namabarang;?></td>
	</tr>
	<tr>
	<td>Qty :<?echo $qty;?></td>
	<td>Bagian :<?echo $bagian;?></td>
	<td>Keterangan :<?echo $keterangan;?></td>
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
  
<?$b = mysql_query("SELECT *  FROM rincipermintaan where nomor='$nomor'");
	if(mysql_num_rows($b) > 0){
	while($datab = mysql_fetch_array($b)){
$qtymasuk=$datab['qtymasuk'];
$nofakturmasuk=$datab['nofaktur'];
$qtykeluar=$datab['qtykeluar'];
$nbbar=$datab['namabarang'];

if($qtymasuk > 0){
$c = mysql_query("SELECT *  FROM tpembelian,tsupplier where tpembelian.idsupp=tsupplier.idsupp and tpembelian.nofaktur='$nofakturmasuk'");
	if(mysql_num_rows($c) > 0){
	while($datac = mysql_fetch_array($c)){
$tglbeli=$datac['tglbeli'];
$namasupp=$datac['namasupp'];
$ket=$datac['keterangan'];
?>
<tr>
<td><?echo $nofakturmasuk;?></td>
<td><?echo $tglbeli;?></td>
      <td><?echo $namasupp;?></td>

   <td><?echo $nbbar;?></td>
   <td><?echo $qtymasuk;?></td>
</tr>

<?}}
else{$f = mysql_query("SELECT *  FROM tpc where idpc='$nbbar'");
	while($dataf = mysql_fetch_array($f)){
	$tglrakit=$dataf['tglrakit'];	}	?>
<tr>
	<td><?echo $tglrakit;?></td>
      <td><?echo 'Stock PC (Perakitan / 1 Set PC)';?></td>

   <td><?echo $nbbar;?></td>
   <td><?echo $qtymasuk;?></td>
   </tr>
<?}
}


	}}
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

  
 
  <?$e = mysql_query("SELECT *  FROM rincipermintaan where nomor='$nomor'");
	if(mysql_num_rows($e) > 0){
	while($datae = mysql_fetch_array($e)){
$qtymasuk=$datae['qtymasuk'];
$nofakturkeluar=$datae['nofaktur'];
$qtykeluar=$datae['qtykeluar'];
$nb=$datae['namabarang'];

if($qtykeluar > 0){
$d = mysql_query("SELECT *  FROM tpengambilan,bagian  where tpengambilan.bagian=bagian.id_bagian and
tpengambilan.nofaktur='$nofakturkeluar'");
	while($datad = mysql_fetch_array($d)){
$tglambil=$datad['tglambil'];
$nama=$datad['nama'];
$bagian=$datad['bagian'];
$divisi=$datad['divisi'];?>	
<tr>
<td>
<?echo $nofakturkeluar;?></td>
<td><?echo $tglambil;?></td>
      <td><?echo $nama.'/'.$bagian.'/'.$divisi;?></td>

   <td><?echo $nb;?></td>
   <td><?echo $qtykeluar;?></td>
</tr>
   <?}}


	}}
?>


</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>


