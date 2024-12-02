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
if(isset($_POST['button_filter'])){
$tanggal_awal=$_POST['tgl_awal'];
$tanggal_akhir=$_POST['tgl_akhir'];
$tahun=substr($tanggal_awal,0,4);
$bulan=substr($tanggal_awal,-5,2);
$tanggal=substr($tanggal_awal,-2,2);
$tglbaru=$tanggal.'-'.$bulan.'-'.$tahun;

$tahun2=substr($tanggal_akhir,0,4);
$bulan2=substr($tanggal_akhir,-5,2);
$tanggal2=substr($tanggal_akhir,-2,2);
$tglbaru2=$tanggal2.'-'.$bulan2.'-'.$tahun2;

$tanggal=true;
//$kd_toko=$_POST['kd_toko'];
$query_get_faktur="SELECT * from permintaan where tgl  BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' order by nomor asc";}
else{
$tanggal=false;
$tanggal_awal=date("20y-m-01");
$tanggal_akhir=date("20y-m-31");
//$kd_toko=$_SESSION['kd_toko'];
$query_get_faktur="SELECT * from permintaan  order by nomor asc";}

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

<body>
<div id="pilih_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td align="center"><form id="form_filter" name="postform2"  method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
     <font color='white'> Tanggal Awal :</font> 
       <input required='required'  type="text" id="from" name="tgl_awal" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="../calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                     
    <font color='white'> Tanggal Akhir :</font>
    <input required='required'  type="text" id="from2" name="tgl_akhir" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from2);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from2);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="../calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
            
   
    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
    </form></td>
  </tr>

</table>
</div>
<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="8" align="center" class="judul_laporan"><p>Laporan Permintaan  Barang</p>
	
      <p>Tanggal : <?php if($tanggal==true){echo $tglbaru." s/d ".$tglbaru2; } ?></p><br></td>
    </tr>
	
	  <tr class="header_footer">

   <td>Pemesan</td>
      <td>Bagian</td>
   <td>Tanggal</td>
   <td>Barang Pesanan</td>
      <td>Masuk</td>
	      <td>Keluar</td>
		 
	
      
	  <td>Status</td>
   


  </tr>
<?php
for($i=0; $i<$count_faktur; $i++){
$faktur=mysql_fetch_array($get_faktur);
$nomorpesan=$faktur['nomor'];
$nama=$faktur['nama'];
$tgl=$faktur['tgl'];
$qty=$faktur['qty'];
$status=$faktur['status'];
$bagian=$faktur['bagian'];
$divisi=$faktur['divisi'];
$namabarang=$faktur['namabarang'];
$tgll=substr($tgl,8,2);
$bln=substr($tgl,5,2);
$thn=substr($tgl,0,4);
$tglbeliformat=$tgll."-".$bln."-".$thn;
$total_pembelian=$faktur['total_pembelian']; ?>
<tr>
<td colspan='12'><hr></td>
</tr>
<tr>

 <td ><?php echo $nama; ?></td>
<td ><?php echo $bagian.'/'.$divisi; ?></td>
 <td><?php echo $tglbeliformat; ?></td>
 <td> <?php echo $namabarang.'('.$qty.')'; ?></td>
  <td></td>


	        <td></td>
 <td ><?php echo $status; ?></td>

</tr>

  <?php
$query_get_rinci_pembelian="SELECT * FROM rincipermintaan WHERE nomor='".$nomorpesan."'  ";
$get_rinci_pembelian=mysql_query($query_get_rinci_pembelian);
$total_item=0;
while($rinci_pembelian=mysql_fetch_array($get_rinci_pembelian)){
$nomor=$rinci_pembelian['nomor'];
$nofaktur=$rinci_pembelian['nofaktur'];
$namabrg=$rinci_pembelian['namabarang'];
$qtymasuk=$rinci_pembelian['qtymasuk'];
$qtykeluar=$rinci_pembelian['qtykeluar'];
$tanggal=$rinci_pembelian['tanggal'];
$tglll=substr($tanggal,8,2);
$blnnn=substr($tanggal,5,2);
$thnnn=substr($tanggal,0,4);
$ttrans=$tglll."-".$blnnn."-".$thnnn;


 ?>

<tr>
 <td colspan='3' ></td>


  <td><? echo $ttrans;?> </td>
    <td><? echo $namabrg;?> </td>
	    <td><? echo $qtymasuk;?> </td>
		    <td><? echo $qtykeluar;?> </td>
			
			  		


</tr>



<?php }?>

<?php }?>

</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>


