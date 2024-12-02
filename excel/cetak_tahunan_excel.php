<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Laporan Stock.xls");//ganti nama sesuai keperluan
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


$divisi=$_POST['divisi'];
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
<th align="center" colspan="6"><h2>LAPORAN STOCK</h2></th> 
</tr> 
 <tr class="warna">
               
                  	<th>Nama Barang</th>
                    <th>Awal</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Sisa</th>
<?php


$sl=mysql_query("select * from tbarang where report='y' order by namabarang ");
while($datarinci = mysql_fetch_array($sl)){
$namabarang=$datarinci['namabarang'];
$idbarang=$datarinci['idbarang'];

$tanggal=$thn_akhir.'-'.$bln_akhir.'-'.$tgll;
$tanggall=$thn_akhir.'-01-01';
$tambah=0;
$kurang=0;

$sq=mysql_query("select stockawal from tbarang where idbarang='".$idbarang."' ");
$dat=mysql_fetch_array($sq);
$stockk=$dat['stockawal'];

$a=mysql_query("select sum(jumlah)as jumta from tpembelian,trincipembelian where tpembelian.nofaktur=trincipembelian.nofaktur
and  idbarang='".$idbarang."' and DATE_FORMAT(tpembelian.tglbeli,'%Y-%m-%d')<='".$tanggal."'");
while($dataa = mysql_fetch_array($a)){
$jumm=$dataa['jumta'];
}

$b=mysql_query("select sum(jumlah)as jumta from tpengambilan,trincipengambilan where tpengambilan.nofaktur=trincipengambilan.nofaktur
and  idbarang='".$idbarang."'  and DATE_FORMAT(tpengambilan.tglambil,'%Y-%m-%d')<='".$tanggal."'");
while($datab = mysql_fetch_array($b)){
$jummb=$datab['jumta'];
}

$stockawal=$stockk+$jumm-$jummb;

$squi=mysql_query("select * from tpembelian,trincipembelian where tpembelian.nofaktur=trincipembelian.nofaktur
and tpembelian.tglbeli like '".$tanggal."%' and trincipembelian.idbarang='$idbarang'  ");
while($datt = mysql_fetch_array($squi)){
$nofaktur=$datt['nofaktur'];
$jumlah=$datt['jumlah'];
$tambah=$tambah+$jumlah;
}

$squii=mysql_query("select * from tpengambilan,trincipengambilan where tpengambilan.nofaktur=trincipengambilan.nofaktur
and tpengambilan.tglambil like '".$tanggal."%' and trincipengambilan.idbarang='$idbarang'  ");
while($datttt = mysql_fetch_array($squii)){
$nofaktur=$datttt['nofaktur'];
$jumlahh=$datttt['jumlah'];
$kurang=$kurang+$jumlahh;
}

$sisa=$stockawal+$tambah-$kurang;



 ?>

           
<tr class="isi_tabel" >
    <td align="left" valign="top"><?php echo $namabarang; ?></td>
	<td align="left" valign="top"><?php echo $stockawal;  ?></td>
	<td align="left" valign="top"><?php echo $tambah;  ?></td>
	<td align="left" valign="top"><?php echo $kurang; ?></td>
	<td align="left" valign="top"><?php echo $sisa; ?></td>
	
  </tr>
<?php } ?>