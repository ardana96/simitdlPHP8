<?php
include('../config.php');
	include('bar128.php');
$idbarang=$_POST['idbarang'];


$a="select * from tbarang where barcode='$idbarang'  ";
$b=mysql_query($a);
$hitung_record=mysql_num_rows($b);

?>
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/lap.css" rel="stylesheet" type="text/css" />
 <style>
.glow{ text-align:center; font-size:30px; color:#fff; animation:blur .75s ease-out infinite; text-shadow:0px 0px 5px #fff, 0px 0px 7px #fff; }
@keyframes blur{ from{ text-shadow:0px 0px 10px #fff, 0px 0px 10px #fff, 0px 0px 25px #fff, 0px 0px 25px #fff, 0px 0px 25px #fff, 0px 0px 25px #fff, 0px 0px 25px #fff, 0px 0px 25px #fff, 0px 0px 50px #fff, 0px 0px 50px #fff, 0px 0px 50px #7B96B8, 0px 0px 150px #7B96B8, 0px 10px 100px #7B96B8, 0px 10px 100px #7B96B8, 0px 10px 100px #7B96B8, 0px 10px 100px #7B96B8, 0px -10px 100px #7B96B8, 0px -10px 100px #7B96B8;} }
</style>
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
<script language="JavaScript" type="text/javascript" src="anggota.js"></script>
<!DOCTYPE html>
<html>
<head>

	<title>Daftar </title>
    <link rel="stylesheet" type="css/form" href="style.css">
</head>
<body >

	<div id="view_oke">
    	<div id="info_query"> 
<?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "Pesan :".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?}
?> 
</div>
       
        <div >
<div id="pilih_laporan">

<table width="95%" border="0" align="center">

  <tr colspan="14">
    <td align="center"><form id="form_filter" name="form_filter" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">


      <font color="white">ID Barang:</font><input type="text" name="idbarang" method="POST">

   
    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
    </form></td>
  </tr>
</table>
</div>
    
            <table  width="auto"  height="50px" cellpadding="3" cellspacing="0" border="0" >
        
<?php

while($faktur=mysql_fetch_array($b)){
$idbarang=$faktur['idbarang'];
$namabarang=$faktur['namabarang'];
$nama=$faktur['nama'];
$tempat_lahir=$faktur['tempat_lahir'];
$tgl_lahir=$faktur['tgl_lahir'];
$jenis_kelamin=$faktur['jenis_kelamin'];
$alamat=$faktur['alamat'];
$agama=$faktur['agama'];
$hp=$faktur['hp'];
$foto=$faktur['foto'];
$tgl=substr($tgl_lahir,8,2);
$bln=substr($tgl_lahir,5,2);
$th=substr($tgl_lahir,0,4);
$sudah=$tgl.'-'.$bln.'-'.$th
?>
  

<tr >


<td >
<? echo $namabarang;?></td>

</tr>

<tr >


<td >
<?php echo '<div style="border:3px double #ababab; padding:5px;margin:5px auto;width:auto;">';
	echo bar128(stripslashes($_POST['idbarang']));
	echo '</div>'; ?></td>

</tr>








<?php } ?>
 
            </table>

            </p>
        </div>
    </div>

</body>
</html>