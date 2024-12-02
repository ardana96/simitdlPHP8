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
	font-size: 12pt; color: #000;
	background-color: #FFF;}
.resume_laporan{
	background-color: #333;
	font-weight: bold; color: #FFF;}
@media print {  
#pilih_laporan{display: none;} } 
</style>
<?php
if(isset($_POST['button_filter'])){
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;
$tanggal=true;
//$kd_toko=$_POST['kd_toko'];
}
else{
$tanggal=true;
$bln_akhir=date('m');
$thn_akhir=date('20y');

//$kd_toko=$_SESSION['kd_toko'];
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td align="center"><form id="form_filter" name="form_filter" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
   
 <font color='white'>   Bulan Tahun : </font>

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
   
    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
	<input type='button' value='Cetak EXCEL' onClick='top.location="cetaktahunanexcel.php"'>
    </form></td>
  </tr>
</table>
</div>
<div id="tampil_laporan"><table width="95%" border="1" align="center">
  <tr>
    <td colspan="6" align="center" class="judul_laporan"><p>KARTU PERSEDIAN BARANG</p>
	  <?$bb = mysql_query("SELECT * FROM bulan where id_bulan='$bln_akhir'");
	if(mysql_num_rows($bb) > 0){
	while($databb = mysql_fetch_array($bb)){
	$namabulan=$databb['bulan'];}}
		?>
      <p>Bulan : <?php if($tanggal==true){echo $namabulan.'-'.$thn_akhir; } ?></p></td>
    </tr>
<tr>

</tr>
  <tr class="header_footer">
    <td width=60%>Nama Barang</td>

    <td width=10%>Awal</td>
	<td width=10%>Masuk</td>
	<td width=10%>Keluar</td>
	<td width=10%>Sisa</td>

  </tr>
<?php


$sl=mysql_query("select * from tbarang where report='y' order by namabarang ");
while($datarinci = mysql_fetch_array($sl)){
$namabarang=$datarinci['namabarang'];
$idbarang=$datarinci['idbarang'];

$tanggal=$thn_akhir.'-'.$bln_akhir.'-'.$tgll;
$tanggall=$thn_akhir.'-01-01';
$tambah=0;
$kurang=0;
$sq=mysql_query("select stockawal from tbarang where idbarang='".$idbarang."' ");
$dat=mysql_fetch_array($sq);
$stockk=$dat['stockawal'];

$a=mysql_query("select sum(jumlah)as jumta from tpembelian,trincipembelian where tpembelian.nofaktur=trincipembelian.nofaktur
and  idbarang='".$idbarang."' and DATE_FORMAT(tpembelian.tglbeli,'%Y-%m-%d')<='".$tanggal."'");
while($dataa = mysql_fetch_array($a)){
$jumm=$dataa['jumta'];
}

$b=mysql_query("select sum(jumlah)as jumta from tpengambilan,trincipengambilan where tpengambilan.nofaktur=trincipengambilan.nofaktur
and  idbarang='".$idbarang."'  and DATE_FORMAT(tpengambilan.tglambil,'%Y-%m-%d')<='".$tanggal."'");
while($datab = mysql_fetch_array($b)){
$jummb=$datab['jumta'];
}

$stockawal=$stockk+$jumm-$jummb;

$squi=mysql_query("select * from tpembelian,trincipembelian where tpembelian.nofaktur=trincipembelian.nofaktur
and tpembelian.tglbeli like '".$tanggal."%' and trincipembelian.idbarang='$idbarang'  ");
while($datt = mysql_fetch_array($squi)){
$nofaktur=$datt['nofaktur'];
$jumlah=$datt['jumlah'];
$tambah=$tambah+$jumlah;
}

$squii=mysql_query("select * from tpengambilan,trincipengambilan where tpengambilan.nofaktur=trincipengambilan.nofaktur
and tpengambilan.tglambil like '".$tanggal."%' and trincipengambilan.idbarang='$idbarang'  ");
while($datttt = mysql_fetch_array($squii)){
$nofaktur=$datttt['nofaktur'];
$jumlahh=$datttt['jumlah'];
$kurang=$kurang+$jumlahh;
}

$sisa=$stockawal+$tambah-$kurang;



 ?>


<tr class="isi_laporan">
    <td><?php echo $namabarang; ?>&nbsp;</td>
	   
		    <td align="center"><?php echo $stockawal; ?>&nbsp;</td>
			    <td align="center"><?php echo $tambah; ?>&nbsp;</td>
    <td align="center"><?php echo $kurang; ?>&nbsp;</td>
    <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $sisa; ?>&nbsp;</td>

  </tr>


 

<?php }?>
 <tr class="header_footer">
    <td></td>
    <td>&nbsp;</td>
	    <td>&nbsp;</td>
		    <td>&nbsp;</td>
			

    <td> <?php echo $total_pembelian; ?></td>
  </tr>
</table>
</div>
</body>
</html>