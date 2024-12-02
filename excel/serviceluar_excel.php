<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=servicekeluar.xls");//ganti nama sesuai keperluan
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
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;

?>
<style>
.warna{background-color:#D3D3D3;
	
}
</style>
 <table  width="100%" cellpadding="3" cellspacing="0" border="1">

<tr>
<th align="center" colspan="8"><h4 align="right">FM-IT.00-25-004/R1</h4><br><h2>DAFTAR SERVICE KELUAR PERANGKAT KOMPUTER</h2></th> 
</tr> 
 <tr class="warna">
               
                  	<th>No</th>
                    <th>Waktu </th>
					<th>Pengirim</th>
					<th>Jenis Perangkat</th>
					<th>Permasalahan</th>
					<th>Penerima</th>
					<th>Status Kembali</th>
					<th>Lama</th>
                   
				</tr>
<?php
$no=0;
$perintah=mysql_query("SELECT service.*,divisi.* from service,divisi where service.divisi=divisi.kd AND service.status='Selesai' and service.ket='L' and service.tgl like '%".$tanggal_akhir_format."' ORDER BY service.tgl ASC");
while($database=mysql_fetch_array($perintah)){
	$no=$no+1;
$tgl=$database['tgl'];
$nama=$database['nama'];
$bagian=$database['bagian'];
$barang=$database['barang'];
$tgl2=$database['tgl2'];
$divisi=$database['namadivisi'];
$kasus=$database['kasus'];
$penerima=$database['penerima'];
$teknisi=$database['teknisi'];
$tindakan=$database['tindakan'];
$status=$database['status'];
$ippc=$database['ippc'];
$tgl3=$database['tgl3'];
$luar=$database['luar'];
$perangkat=$database['perangkat'];
$awal=substr($tgl2,0,2);
$akhir=substr($tgl3,0,2);
$semua=$hbulan;
$bulan_awal=substr($tgl2,3,2);
$bulan_akhir=substr($tgl3,3,2);
$total_bulan=$bulan_akhir-$bulan_awal;
$hbulan=$total_bulan*30+$akhir-$awal;
if($hbulan == 0){
$hbulan=1;	
}

//$tanggal1 = new DateTime($tgl);
//$tanggal2 = new DateTime($tgl2);

//$days = round(($tanggal2->format('U') - $tanggal1->format('U')) / (60*60*24));

//if($days == 0)
//{
//	$selisih = 1;
//}
//else
//{
//	$selisih = $days;
//}

$awal_cuti = $tgl;
$akhir_cuti = $tgl2;
 
// tanggalnya diubah formatnya ke Y-m-d 
//$awal_cuti = DateTime::createFromFormat('d-m-Y', $awal_cuti);
$awal_cuti = date_create($awal_cuti);
$awal_cuti = date_format($awal_cuti, 'Y-m-d');
$awal_cuti = strtotime($awal_cuti);
 
$akhir_cuti = date_create($akhir_cuti);
$akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
$akhir_cuti = strtotime($akhir_cuti);
 
$haricuti = array();
$sabtuminggu = array();
 
for ($i=$awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
    if (date('w', $i) !== '0' && date('w', $i) !== '6') {
        $haricuti[] = $i;
    } else {
        $sabtuminggu[] = $i;
    }
 
}

$jumlah_cuti = count($haricuti);
$jumlah_sabtuminggu = count($sabtuminggu);
$abtotal = $jumlah_cuti + $jumlah_sabtuminggu;

if($jumlah_cuti == 1){

	$jumlah_cuti = $jumlah_cuti;
}

if($jumlah_cuti > 1){
	$jumlah_cuti = $jumlah_cuti - 1;
}

if($jumlah_cuti == 0){

	$jumlah_cuti = 1;
}

?>
           
<tr class="isi_tabel" >
    

    <td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo "&nbsp;".$tgl; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian; ?><?php echo"-". $divisi; ?></td>
	<td align="left" valign="top"><?php echo $perangkat; ?></td>
	<td align="left" valign="top"><?php echo $kasus; ?></td>
	<td align="left" valign="top"><?php echo $penerima; ?></td>
	<td align="left" valign="top"><?php echo $status; ?><br><?php echo "-".$luar; ?><?php echo "(".$tgl2.")"; ?></td>
	<td align="left" valign="top"><?php echo $jumlah_cuti."hr"; ?></td>
	
  </tr>
<?php } ?>