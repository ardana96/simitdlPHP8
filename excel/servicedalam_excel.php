<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=servicedalam.xls");//ganti nama sesuai keperluan
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
<th align="center" colspan="9"><h4 align="right">FM-IT.00-25-003/R2</h4><br><h2>PERMINTAAN PERBAIKAN PERANGKAT KOMPUTER</h2></th> 
</tr> 
 <tr class="warna">
               
                  	<th>No</th>
                    <th>Waktu </th>
					<th>Pengirim</th>
					<th>Jenis Perangkat</th>
					<th>Permasalahan</th>
					<th>Penerima</th>
					<th>Status</th>
					<th>Kategori</th>
					<th>Lama</th>
                   
				</tr>
<?php
function selisihHari($tglAwal, $tglAkhir){
// list tanggal merah selain hari minggu
    $tglLibur = Array("2021-10-20","2021-08-17", "2021-08-10", "2021-07-20");
	
	// $tglAwal = "16-08-2021";
	// $tglAkhir = "18-08-2021";
     
    // memecah string tanggal awal untuk mendapatkan
    // tanggal, bulan, tahun
    $pecah1 = explode("-", $tglAwal);
    $date1 = $pecah1[0];
    $month1 = $pecah1[1];
    $year1 = $pecah1[2];
	$tanggalGabungan1 = $date1."-".$month1."-".$year1;
    // memecah string tanggal akhir untuk mendapatkan
    // tanggal, bulan, tahun
    $pecah2 = explode("-", $tglAkhir);
    $date2 = $pecah2[0];
    $month2 = $pecah2[1];
    $year2 =  $pecah2[2];
 
    // mencari total selisih hari dari tanggal awal dan akhir
    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);
 
    $selisih = $jd2 - $jd1;
     
    // proses menghitung tanggal merah dan hari minggu
    // di antara tanggal awal dan akhir
    for($i=1; $i<=$selisih; $i++)
    {
        // menentukan tanggal pada hari ke-i dari tanggal awal
        $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
        $tglstr = date("Y-m-d", $tanggal);
         
        // menghitung jumlah tanggal pada hari ke-i
        // yang masuk dalam daftar tanggal merah selain minggu
        if (in_array($tglstr, $tglLibur)) 
        {
           $libur1++;
        }
         
        // menghitung jumlah tanggal pada hari ke-i
        // yang merupakan hari minggu
        if ((date("N", $tanggal) == 7))
        {
           $libur2++;
        }
		if ((date("N", $tanggal) == 6))
        {
           $libur3++;
        }
		//$hari = date("N", $tanggal) == 7;
		
    }
     
    // menghitung selisih hari yang bukan tanggal merah dan hari minggu
    $selisihTotal=$selisih-$libur1-$libur2-$libur3; 
	
	if($selisihTotal == 1){

		$jselisihTotal = $selisihTotal;
    }
	if($selisihTotal== 0){

		$selisihTotal = 1;
	}
	return $selisihTotal;
}

$no=0;
$perintah=mysql_query("SELECT service.*,divisi.* from service,divisi where service.divisi=divisi.kd AND service.status='Selesai' and service.ket='D' and  service.tgl like '%".$tanggal_akhir_format."' ORDER BY service.tgl ASC");
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
$perangkat=$database['perangkat'];
$kategori = $database['svc_kat'];
$awal=substr($tgl,0,2);
$akhir=substr($tgl2,0,2);
$semua=$hbulan;
$bulan_awal=substr($tgl,3,2);
$bulan_akhir=substr($tgl2,3,2);
$total_bulan=$bulan_akhir-$bulan_awal;
$hbulan=$total_bulan*30+$akhir-$awal;

// $awal_cuti = $tgl;
// $akhir_cuti = $tgl2;
 
// // tanggalnya diubah formatnya ke Y-m-d 
// //$awal_cuti = DateTime::createFromFormat('d-m-Y', $awal_cuti);
// $awal_cuti = date_create($awal_cuti);
// $awal_cuti = date_format($awal_cuti, 'Y-m-d');
// $awal_cuti = strtotime($awal_cuti);
 
// $akhir_cuti = date_create($akhir_cuti);
// $akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
// $akhir_cuti = strtotime($akhir_cuti);
 
// $haricuti = array();
// $sabtuminggu = array();
 
// for ($i=$awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
    // if (date('w', $i) !== '0' && date('w', $i) !== '6') {
        // $haricuti[] = $i;
    // } else {
        // $sabtuminggu[] = $i;
    // }
 
// }

// $jumlah_cuti = count($haricuti);
// $jumlah_sabtuminggu = count($sabtuminggu);
// $abtotal = $jumlah_cuti + $jumlah_sabtuminggu;

// if($jumlah_cuti == 1){

	// $jumlah_cuti = $jumlah_cuti;
// }

// if($jumlah_cuti > 1){
	// $jumlah_cuti = $jumlah_cuti - 1;
// }

// if($jumlah_cuti == 0){

	// $jumlah_cuti = 1;
// }


$tgl_format = date_create($tgl);

$tgl_format1 = date_format($tgl_format, 'd-m-Y');

if($kategori == "NON_SP"){
	$kategori_text = "NON SPAREPART";
}else if ($kategori == "SP"){
	$kategori_text = "SPAREPART";
}else {
	$kategori_text = "-";
}

?>
           
<tr class="isi_tabel" >
    

    <td align="left" valign="top"><?php echo $no; ?></td>
	<td align="left" valign="top"><?php echo "&nbsp;".$tgl_format1; ?></td>
	<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian; ?><?php echo"-". $divisi; ?></td>
	<td align="left" valign="top"><?php echo $perangkat; ?></td>
	<td align="left" valign="top"><?php echo $kasus; ?></td>
	<td align="left" valign="top"><?php echo $penerima; ?></td>
	<td align="left" valign="top"><?php echo $status; ?><br><?php echo "-".$teknisi; ?><?php echo "(".$tgl2.")"; ?></td>
	<td align="left" valign="top"><?php echo $kategori_text; ?></td>
	<td align="left" valign="top"><?php echo selisihHari($tgl,$tgl2) ." hr"; ?></td>
	
  </tr>
<?php } ?>