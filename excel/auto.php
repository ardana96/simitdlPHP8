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


?>
 <table  width="100%" cellpadding="3" cellspacing="0" border="1">
<tr>
<th align="center" colspan="4"><h2>DAFTAR BARANG MASUK</h2></th> 
</tr> 
 <tr class="header_tabel">
               
                  
                    <th>Tanggal</th>
					<th>Jam</th>
					<th>Barang</th>
					<th>Jumlah</th>
                   
				</tr>
<?php
$perintah=mysql_query("select barang.*,masuk.*,masuk_detail.* from barang,masuk,masuk_detail where masuk.nomor=masuk_detail.nomor and masuk_detail.kodeb=barang.kodeb");
while($download=mysql_fetch_array($perintah)){
$nomor=$download['nomor'];
$tgl=$download['tgl']; 
$jam=$download['jam']; 
$kodeb=$download['kodeb'];
$qty=$download['qty'];
$barang=$download['barang'];

?>
           
<tr class="isi_tabel" >
    

  
	<td align="left"><?php echo $tgl; ?></td>
	<td align="left"><?php echo $jam; ?></td>
	<td align="left"><?php echo $barang; ?></td>
	<td align="left"><?php echo $qty; ?></td>
	
  </tr>
<?php } ?>