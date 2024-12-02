<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=stock.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="it";
$koneksi=mysql_connect($server_database,$user_database,$password_database);
if(!$koneksi){
die("Tidak bisa terhubung ke server".mysql_error());}
$pilih_database=mysql_select_db($nama_database,$koneksi);
if(!$pilih_database){
die("Database tidak bisa digunakan".mysql_error());}

$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;

?>
<style>
.warna{background-color:#D3D3D3;
	
}
</style>
 <table  width="100%" cellpadding="3" cellspacing="0" border="1">

<tr>
<th align="center" colspan="5"><h2>DAFTAR STOCK HARDWARE</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>Nama Barang</th>
					<th>Awal</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Akhir</th>
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("Select barang.*,stock.* from barang,stock where barang.kodeb=stock.kodeb and periode like '%".$tanggal_akhir_format."' ORDER BY barang ASC");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$barang=$database['barang'];
$awal=$database['awal'];
$masuk=$database['masuk'];
$keluar=$database['keluar'];
$akhir=$database['akhir'];

?>
           
<tr class="isi_tabel" >
    

  
	<td align="left" valign="top"><?php echo $barang; ?></td>
	<td align="left" valign="top"><?php echo $awal; ?></td>
	<td align="left" valign="top"><?php echo $masuk; ?></td>
	<td align="left" valign="top"><?php echo $keluar; ?></td>
	<td align="left" valign="top"><?php echo $akhir; ?></td>
	
  </tr>
<?php } ?>