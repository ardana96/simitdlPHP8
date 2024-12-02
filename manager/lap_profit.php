<?php
session_start();
include('../koneksi/koneksi.php');
?>
<?php
if(isset($_POST['button_filter'])){
$tgl_awal=$_POST['tgl_awal'];
$bln_awal=$_POST['bln_awal'];
$thn_awal=$_POST['thn_awal'];
$tanggal_awal=$thn_awal.$bln_awal.$tgl_awal;
$tanggal_awal_format=$tgl_awal."-".$bln_awal."-".$thn_awal;
$tgl_akhir=$_POST['tgl_akhir'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$tgl_akhir."-".$bln_akhir."-".$thn_akhir;
$tanggal=true;
$kd_toko=$_POST['kd_toko'];
$query_get_penjualan="SELECT tabel_rinci_penjualan.kd_barang,SUM(tabel_rinci_penjualan.jumlah) as jumlah_jual,tabel_barang.* FROM tabel_rinci_penjualan,tabel_penjualan,tabel_barang WHERE tabel_rinci_penjualan.no_faktur_penjualan=tabel_penjualan.no_faktur_penjualan AND tabel_barang.kd_barang=tabel_rinci_penjualan.kd_barang AND tabel_penjualan.tgl_penjualan BETWEEN '".$tanggal_awal."' AND  '".$tanggal_akhir."' AND tabel_penjualan.no_faktur_penjualan LIKE '".$kd_toko."%' GROUP BY tabel_rinci_penjualan.kd_barang";}
else{
$tanggal=false;
$kd_toko=$_SESSION['kd_toko'];
$query_get_penjualan="SELECT tabel_rinci_penjualan.kd_barang, SUM(tabel_rinci_penjualan.jumlah) as jumlah_jual,tabel_barang.* FROM tabel_rinci_penjualan,tabel_penjualan,tabel_barang WHERE tabel_rinci_penjualan.no_faktur_penjualan=tabel_penjualan.no_faktur_penjualan AND tabel_barang.kd_barang=tabel_rinci_penjualan.kd_barang AND tabel_penjualan.no_faktur_penjualan LIKE '".$kd_toko."%' GROUP BY tabel_rinci_penjualan.kd_barang";}
$get_penjualan=mysql_query($query_get_penjualan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan"><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="form_filter"><table width="95%" border="0" align="center">
  <tr>
    <td align="center">Tanggal : 
      <select name="tgl_awal" size="1" id="tgl_awal">
<?php
for($i=1;$i<=31;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>      
      </select>
      <select name="bln_awal" size="1" id="bln_awal">
<?php
for($i=1;$i<=12;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>      
      </select>
      <select name="thn_awal" size="1" id="thn_awal">
<?php
for($i=2013;$i<=date('Y');$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>      
      </select> 
      Tanggal Akhir : 
      <select name="tgl_akhir" size="1" id="tgl_akhir">
<?php
for($i=1;$i<=31;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>         
      </select>
      <select name="bln_akhir" size="1" id="bln_akhir">
<?php
for($i=1;$i<=12;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>         
      </select>
      <select name="thn_akhir" size="1" id="thn_akhir">
<?php
for($i=2013;$i<=date('Y');$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>       
      </select> 
      Toko : 
      <select name="kd_toko" size="1" id="kd_toko">
<?php
if($_GET['view']=="cabang"&&$_SESSION['status_toko']=="pusat"){
$query_get_kd_toko=mysql_query("SELECT kd_toko FROM tabel_toko WHERE status='cabang'");
while($get_kd_toko=mysql_fetch_array($query_get_kd_toko)){
$kd_toko=$get_kd_toko['kd_toko'];
echo"<option value=".$kd_toko.">".$kd_toko."</option>";}}
else{
echo"<option value=".$_SESSION['kd_toko'].">".$_SESSION['kd_toko']."</option>";}
?>      
      </select> <input type="submit" name="button_filter" id="button_filter" value="Filter" />
      <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" /></td>
  </tr>
</table>
</form></div>
<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="8" align="center" class="judul_laporan"><p>Laporan Profit Penjualan</p>
      <p>Toko : <?php echo $kd_toko; ?></p>
      <p>Tanggal :  <?php if($tanggal==true){echo $tanggal_awal_format."s/d".$tanggal_akhir_format;} ?></p></td>
    </tr>
  <tr class="header_footer">
    <td>Kode Barang</td>
    <td>Nama Barang</td>
    <td>Harga Beli</td>
    <td>Harga Jual</td>
    <td>Jumlah</td>
    <td>Modal</td>
    <td>Pendapatan</td>
    <td>Profit</td>
  </tr>
<?php 
$total_modal=0; $total_pendapatan=0; $total_profit=0;
while($penjualan=mysql_fetch_array($get_penjualan)){
$kd_barang=$penjualan['kd_barang'];
$nm_barang=$penjualan['nm_barang'];
$hrg_beli=$penjualan['hrg_beli'];
$hrg_jual=$penjualan['hrg_jual'];
$jumlah=$penjualan['jumlah_jual'];
$modal=$jumlah*$hrg_beli;
$pendapatan=$jumlah*$hrg_jual;
$profit=$pendapatan-$modal;
$total_modal=$total_modal+$modal;
$total_pendapatan=$total_pendapatan+$pendapatan;
$total_profit=$total_profit+$profit; ?>
<tr class="isi_laporan">
    <td><?php echo $kd_barang; ?>&nbsp;</td>
    <td><?php echo $nm_barang; ?>&nbsp;</td>
    <td><?php echo $hrg_beli ?>&nbsp;</td>
    <td><?php echo $hrg_jual ?>&nbsp;</td>
    <td><?php echo $jumlah; ?>&nbsp;</td>
    <td><?php echo $modal; ?>&nbsp;</td>
    <td><?php echo $pendapatan; ?>&nbsp;</td>
    <td><?php echo $profit; ?>&nbsp;</td>
  </tr>
<?php } ?>  
  <tr class="resume_laporan">
    <td colspan="5" align="left">Total</td>
    <td>Rp. <?php echo $total_modal; ?></td>
    <td>Rp. <?php echo $total_pendapatan; ?></td>
    <td>Rp. <?php echo $total_profit; ?></td>
  </tr>
</table>
</div>
</body>
</html>