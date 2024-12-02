<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=perubahan_pemakaipc.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="5"><h2>PERUBAHAN PEMAKAI PC</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>Tgl</th>
					<th>User</th>
					<th>Divisi</th>
					<th>Bagian</th>
					<th>IP PC</th>
					<th>Pengantian</th>
					<th>Keterangan</th>
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT ubahpemakaipc.*,bagian.*,divisi.* from ubahpemakaipc,bagian,divisi where ubahpemakaipc.id_divisi=divisi.kd and ubahpemakaipc.id_bagian=bagian.id_bagian and ubahpemakaipc.tgl like '%".$tanggal_akhir_format."' order by nomor desc");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$tgl=$database['tgl'];
$user=$database['user'];
$bagian=$database['bagian'];
$divisi=$database['namadivisi'];
$ip_pc=$database['ip_pc'];
$ganti=$database['ganti'];
$keterangan=$database['keterangan'];

?>
           
<tr class="isi_tabel" >
    

  
	<td align="left" valign="top"><?php echo $tgl; ?></td>
	<td align="left" valign="top"><?php echo $user; ?></td>
	<td align="left" valign="top"><?php echo $divisi; ?></td>
	<td align="left" valign="top"><?php echo $bagian; ?></td>
	<td align="left" valign="top"><?php echo $ip_pc; ?></td>
	<td align="left" valign="top"><?php echo $ganti; ?></td>
	<td align="left" valign="top"><?php echo $keterangan; ?></td>
  </tr>
<?php } ?>