<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=peminjaman.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="5"><h4 align="right">FM-IT.00-25-001/R1</h4><br><h2>PEMINJAMAN ALAT</h2></th> 
</tr> 
 <tr class="warna">
               
                  	<th>No</th>
                    <th>Waktu</th>
					<th>Peminjam</th>
					<th>Jenis Perangkat</th>
					<th>Kembali</th>
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT * from tpinjam,trincipinjam,bagian where tpinjam.nopinjam=trincipinjam.nopinjam and tpinjam.bagian=bagian.id_bagian
and tpinjam.tgl1 like '".$tanggal_akhir_format."%'  order by tpinjam.nopinjam ");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$tgl1=$database['tgl1'];
$nama=$database['nama'];
$bagian=$database['bagian'];
$barang=$database['namabarang'];
$tgl2=$database['tgl2'];
$divisi=$database['divisi'];
$namabesar=strtoupper($nama);
$barangbesar=strtoupper($barang);
$tahun=substr($tgl1,0,4);
$bulan=substr($tgl1,-5,2);
$tanggal=substr($tgl1,-2,2);
$tglbaru=$tanggal.'-'.$bulan.'-'.$tahun;

$tahun2=substr($tgl2,0,4);
$bulan2=substr($tgl2,-5,2);
$tanggal2=substr($tgl2,-2,2);
$tglbaru2=$tanggal2.'-'.$bulan2.'-'.$tahun2;

?>
           
<tr class="isi_tabel" >
    

 	<td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo $tgl1; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian; ?><?php echo"-". $divisi; ?></td>
	<td align="left" valign="top"><?php echo $barang; ?></td>
	<td align="left" valign="top"><?php echo $tgl2; ?></td>
	
  </tr>
<?php } ?>