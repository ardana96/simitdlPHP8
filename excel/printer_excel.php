<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=dafar_printer.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="sitdl";
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
<th align="center" colspan="4"><h2>DAFTAR PEMAKAI PRINTER & SCANNER </h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>NO</th>
					<th>ID Perangkat</th>
					<th>Jenis Printer</th>
					<th>Keterangan</th>
					
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT * from printer where status='$status'");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$id_perangkat=$database['id_perangkat'];
$jenisprint=$database['printer'];
$keterangan=$database['keterangan'];


?>
           
<tr class="isi_tabel" >
    

 
	<td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo $id_perangkat; ?></td>
	<td align="left" valign="top"><?php echo $jenisprint; ?></td>
	<td align="left" valign="top"><?php echo $keterangan; ?></td>

  </tr>
<?php } ?>


<?php
$no2=0;
$perintah2=mysql_query("SELECT * from scaner where status='$status'");
while($database2=mysql_fetch_array($perintah2)){
	$no2=$no2+1;
$id_perangkat2=$database2['id_perangkat'];
$jenisprint2=$database2['printer'];
$keterangan2=$database2['keterangan'];


?>
           
<tr class="isi_tabel" >
    

 
	<td align="left" valign="top"><?php echo $no2; ?></td>
	<td align="left" valign="top"><?php echo $id_perangkat2; ?></td>
	<td align="left" valign="top"><?php echo $jenisprint2; ?></td>
	<td align="left" valign="top"><?php echo $keterangan2; ?></td>

  </tr>
<?php } ?>
