<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=pemakaipc.xls");//ganti nama sesuai keperluan
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
$id_divisi=$_POST['id_divisi'];
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
<th align="center" colspan="5"><h2>DAFTAR PEMAKAI PC</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>No</th>
					<th>Bagian</th>
					<th>Sub Bagian</th>
					<th>user</th>
					<th>ID PC</th>
					<th>Nama PC</th>
					<th>Lokasi</th>
					<th>Prosesor</th>
					<th>Motherboard</th>
					<th>Ram</th>
					<th>Harddisk</th>
					<th>Monitor</th>
					<th>OS</th>
					<th>TCP/IP</th>
					<th>Jumlah</th>
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT * from pcaktif where divisi like '%".$id_divisi."' and model='CPU' ");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$nomor=$database['nomor'];
$tanggal=$database['tanggal'];
$user=$database['user'];
$id_divisi=$database['id_divisi'];
$bagian=$database['bagian'];
$id_pc=$database['idpc'];
$os=$database['os'];
$prosesor=$database['prosesor'];
$mobo=$database['mobo'];
$id_monitor=$database['id_monitor'];
$monitor=$database['monitor'];
$ram=$database['ram'];
$harddisk=$database['harddisk'];
$jumlah=$database['jumlah'];
$ganti=$database['ganti'];
$keterangan=$database['keterangan'];
$nama_pc=$database['namapc'];
$ip_pc=$database['ippc'];
$subbagian=$database['subbagian'];
$lokasi=$database['lokasi'];

?>
           
<tr class="isi_tabel" >
    

  
	<td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo $bagian;?></td>
	<td align="left" valign="top"><?php echo $subbagian;?></td>
	<td align="left" valign="top"><?php echo $user; ?></td>
	<td align="left" valign="top"><?php echo $id_pc; ?></td>
	<td align="left" valign="top"><?php echo $nama_pc; ?></td>
	<td align="left" valign="top"><?php echo $lokasi;?></td>
	<td align="left" valign="top"><?php echo $prosesor; ?></td>
	<td align="left" valign="top"><?php echo $mobo; ?></td>
	<td align="left" valign="top"><?php echo $ram;?></td>
	<td align="left" valign="top"><?php echo $harddisk; ?></td>
	<td align="left" valign="top"><?php echo $monitor; ?></td>
	<td align="left" valign="top"><?php echo $os; ?></td>
	<td align="left" valign="top"><?php echo $ip_pc; ?></td>
	<td align="left" valign="top"><?php echo $jumlah; ?></td>
  </tr>
<?php } ?>