<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=pengambilan.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="5"><h4 align="right">FM-IT.00-25-002/R1</h4><br><h2>DAFTAR PENGAMBILAN</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>id Bagian</th>
					<th>Bagian</th>
		
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("select * from bagian");
while($download=mysql_fetch_array($perintah)){
	$no=$no+1;
$id_bagian=$download['id_bagian'];
$bagian=$download['bagian']; 


?>
           
<tr class="isi_tabel" >
    

    <td align="left" valign="top"><?php echo $id_bagian; ?></td>
	<td align="left" valign="top"><?php echo $bagian; ?></td>

	
  </tr>
<?php } ?>