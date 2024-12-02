<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=dafar_kamera.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="5"><h2>DAFTAR PEMAKAI KAMERA </h2></th> 
</tr> 
<tr class="header_tabel">
               
                    <th>NOMOR</th>
				
					<th>KAMERA</th>
                    <th>KETERANGAN</th>
                    
				
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT * from kamera order by kamera asc ");
while($database=mysql_fetch_array($perintah)){
	$nomor=$no+1;
$id_perangkat=$database['id_perangkat'];
$kamera=$database['kamera'];
$keterangan=$database['keterangan'];


?>
           
  
<tr class="isi_tabel" >
    
   
    <td align="left"><?php echo $nomor; ?></td>

	<td align="center"><?php echo $kamera; ?></td>
	<td align="center"><?php echo $keterangan; ?></td>


	
  </tr>
<?php } ?>