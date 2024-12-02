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
$tanggal_akhir_format=$thn_akhir."-".$bln_akhir;

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
               
                  
                    <th>No</th>
					<th>Barang</th>
					<th>QTY</th>
					<th>TGL</th>
					<th>Bagian / Nama</th>
                   
				</tr>
<?php
$no=0;
//$perintah=mysql_query("SELECT a.namabarang,b.jumlah,a.tglambil,a.nama,c.bagian,a.divisi from tpengambilan as a,trincipengambilan as b,bagian as c where 
//a.nofaktur=b.nofaktur and a.bagian=c.id_bagian and
//b.status<>'perakitan' and a.bagian<>'B079' and  a.tglambil like '".$tanggal_akhir_format."%' order by a.nofaktur asc");

$perintah=mysql_query("select namabarang,jumlah,tglambil,nama,c.bagian,divisi from (select nofaktur,tglambil,nama,bagian,divisi from tpengambilan ) as a,(select nofaktur,namabarang,jumlah,status from trincipengambilan) as b ,
bagian as c where a.nofaktur=b.nofaktur and a.bagian=c.id_bagian and b.status<>'perakitan' and a.bagian<>'B079' and  a.tglambil like '2019-07%' order by a.nofaktur asc" );

while($download=mysql_fetch_array($perintah)){
	$no=$no+1;
$namabarang=$download['namabarang'];
$jumlah=$download['jumlah'];
$tglambil=$download['tglambil'];
$nama=$download['nama'];
$bagian=$download['bagian'];
$divisi=$download['divisi'];

?>
           
<tr class="isi_tabel" >
    

    <td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo $namabarang; ?></td>
	<td align="left" valign="top"><?php echo $jumlah; ?></td>
	<td align="left" valign="top"><?php echo $tglambil; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian; ?><?php echo "-".$divisi; ?></td>
	
  </tr>
<?php } ?>