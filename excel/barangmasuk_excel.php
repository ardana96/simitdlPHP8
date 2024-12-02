<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=barangmasuk.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="4"><br><h2>DAFTAR BARANG MASUK</h2></th> 
</tr> 
 <tr class="warna">
               
                  
                    <th>Tanggal</th>
					<th>Jam</th>
					<th>Barang</th>
					<th>Qty</th>
				</tr>
<?php
$no=0;
$perintah=mysql_query("select barang.*,masuk.*,masuk_detail.* from barang,masuk,masuk_detail where barang.kodeb=masuk_detail.kodeb and masuk.nomor=masuk_detail.nomor AND masuk.tgl like '%".$tanggal_akhir_format."'");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$tgl=$database['tgl'];
$jam=$database['jam'];
$qty=$database['qty'];
$barang=$database['barang'];

$awal=substr($tgl,0,2);
$akhir=substr($tgl2,0,2);
$semua=$hbulan;
$bulan_awal=substr($tgl,3,2);
$bulan_akhir=substr($tgl2,3,2);
$total_bulan=$bulan_akhir-$bulan_awal;
$hbulan=$total_bulan*30+$akhir-$awal;

?>
           
<tr class="isi_tabel" >
    

 
	<td align="left" valign="top"><?php echo $tgl; ?></td>
	<td align="left" valign="top"><?php echo $jam; ?></td>
	<td align="left" valign="top"><?php echo $barang; ?></td>
	<td align="left" valign="top"><?php echo $qty; ?></td>
	
  </tr>
<?php } ?>