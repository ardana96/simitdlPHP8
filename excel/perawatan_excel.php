<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=perawatan.xls");//ganti nama sesuai keperluan
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
<th align="right" colspan="13">FM-IT.00-25-007</th>
</tr> 
<tr>
<th align="left" colspan="13"><h2>PERAWATAN SOFTWARE DAN HARDWARE</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <td rowspan='2'>NO</td>
					<td rowspan='2'>BULAN</td>
					<td rowspan='2'>TGL REALISASI</td>
					<td rowspan='2'>ID</td>
					<td rowspan='2'>NAMA PERANGKAT</td>
						
						<td colspan='5'>ITEM YANG DICEK</td>
				
					
					<td colspan='2'>PARAF</td>
				
					<td rowspan='2'>KETARANGAN</td>
                   
				</tr>
				 <tr class="warna">
               
                  
                   
						
						<td>OS</td>
					<td>APPS</td>
					<td>CPU</td>
					<td>MONITOR</td>
					<td>PRINTER</td>
					
					<td>PETUGAS</td>
					<td>USER</td>
				
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("Select perawatan.*,pcaktif.* from perawatan,pcaktif where perawatan.nomor=pcaktif.nomor and perawatan.periode ='$tanggal_akhir_format' ORDER BY perawatan.nomor ASC");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$nomor=$database['nomor'];
$periode=$database['periode'];
$tgl=$database['tgl_realisasi'];
$ippc=$database['ippc'];
$namapc=$database['namapc'];
$osp=$database['osp'];
$apps=$database['apps'];
$cpu=$database['cpu'];
$monitorp=$database['monitorp'];
$printer=$database['printer'];
$keterangan=$database['keterangan'];
$bulan=substr($periode,'0','2');
$b=mysql_query("select * from bulan where id_bulan='$bulan'");
while($dat=mysql_fetch_array($b)){
	$namabulan=$dat['bulan'];
	$bulanbesar=strtoupper($namabulan);
}
?>
           
<tr class="isi_tabel" >
    
	<td align="left" valign="top"><?php echo $nomor; ?></td>
	<td align="left" valign="top"><?php echo $bulanbesar; ?></td>
	<td align="left" valign="top"><?php echo $tgl; ?></td>
	<td align="left" valign="top"><?php echo $ippc; ?></td>
	<td align="left" valign="top"><?php echo $namapc; ?></td>
	<td align="left" valign="top"><?php echo $osp; ?></td>
	<td align="left" valign="top"><?php echo $apps; ?></td>
	<td align="left" valign="top"><?php echo $cpu; ?></td>
	<td align="left" valign="top"><?php echo $monitorp; ?></td>
	<td align="left" valign="top"><?php echo $printer; ?></td>
	<td align="left" valign="top"><?php echo $petugas; ?></td>
	<td align="left" valign="top"><?php echo $user; ?></td>
	<td align="left" valign="top"><?php echo $keterangan; ?></td>
	
  </tr>
<?php } ?>