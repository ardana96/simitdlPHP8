<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Laporan Pengeluaran Barang.xls");//ganti nama sesuai keperluan
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


$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir_format=$thn_akhir."-".$bln_akhir;
$kd_barang=$_POST['kd_barang'];

if($bln_akhir == 01){
	$bln_nama = "Januari";
}
else if ($bln_akhir == 02) {
	$bln_nama="Februari";
}
else if ($bln_akhir == 03) {
	$bln_nama="Maret";
}
else  if ($bln_akhir == 04){
	$bln_nama="April";
}
else if ($bln_akhir == 05) {
	$bln_nama="Mei";
}
else if ($bln_akhir == 06) {
	$bln_nama="Juni";
}
else if ($bln_akhir == 07) {
	$bln_nama="Juli";
}
else if ($bln_akhir == 08) {
	$bln_nama="Agustus";
}
else if ($bln_akhir == 09) {
	$bln_nama="September";
}
else if ($bln_akhir = 10) {
	$bln_nama="Oktober";
}
else if ($bln_akhir = 11) {
	$bln_nama="November";
}
else if($bln_akhir = 12) {
	$bln_nama="Desember";
}

?>
<style>
.warna{background-color:#D3D3D3;
	
}
</style>
 <table  width="100%" cellpadding="3" cellspacing="0" border="1">

<tr>
<th align="center" colspan="6"><h2>LAPORAN PENGELUARAN BARANG - <?php echo strtoupper($bln_nama) ;?> <?php echo $thn_akhir ;?></h2></th> 
</tr> 
 <tr class="warna">
               
                  	<th>No</th>
                    <th>Nama</th>
                    <th>Bagian</th>
					<th>Divisi</th>
					<th>Nama Barang</th>
					<th>Jumlah</th>
<?php
$no=0;
$perintah=mysql_query("SELECT * from tpengambilan a, trincipengambilan b  where  a.nofaktur = b.nofaktur and idbarang='$kd_barang' 
				and a.tglambil like '".$tanggal_akhir_format."%'");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$nama=$database['nama'];
$divisi=$database['divisi'];
$bagian=$database['bagian'];
$namabarang=$database['namabarang'];
$jumlah=$database['jumlah'];
?>
           
<tr class="isi_tabel" >
    <td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?></td>
	<td align="left" valign="top"><?php echo $bagian; ?></td>
	<td align="left" valign="top"><?php echo strtoupper($divisi); ?></td>
	<td align="left" valign="top"><?php echo $namabarang; ?></td>
	<td align="left" valign="top"><?php echo $jumlah; ?></td>
	
  </tr>
<?php } ?>