<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=permintaan_barang.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="5"><h2>DAFTAR PERMINTAAN BARANG</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>Pesan</th>
					<th>Nama / Bagian</th>
					<th>Barang</th>
					<th>Qty</th>
					<th>Keterangan</th>
					<th>Status</th>
					<th>Realisasi</th>
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT divisi.*,pesan.* from divisi,pesan where divisi.kd=pesan.divisi and pesan.tgl like '%".$tanggal_akhir_format."' order by pesan.nomor desc ");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$tgl=$database['tgl'];
$nama=$database['nama'];
$bagian=$database['bagian'];
$divisi=$database['namadivisi'];
$barang=$database['nama_barang'];
$qty=$database['qty'];
$keterangan=$database['keterangan'];
$status=$database['status'];
$tgl2=$database['tgl2'];

?>
           
<tr class="isi_tabel" >
    

  
	<td align="left" valign="top"><?php echo $tgl; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian.'-'; ?><?php echo $divisi; ?></td>
	<td align="left" valign="top"><?php echo $barang; ?></td>
	<td align="left" valign="top"><?php echo $qty; ?></td>
	<td align="left" valign="top"><?php echo $keterangan; ?></td>
	<td align="left" valign="top"><?php echo $status; ?></td>
	<td align="left" valign="top"><?php echo $tgl2; ?></td>
  </tr>
<?php } ?>