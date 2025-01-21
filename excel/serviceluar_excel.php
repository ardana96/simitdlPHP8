<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=servicekeluar.xls");
header("Pragma: no-cache");
header("Expires: 0");

require('../config.php'); // Gunakan koneksi dari config.php

if (!$conn) {
	die("Koneksi ke server gagal: " . print_r(sqlsrv_errors(), true));
}

// Cek data dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$bln_akhir = isset($_POST['bln_akhir']) ? $_POST['bln_akhir'] : '';
$thn_akhir = isset($_POST['thn_akhir']) ? $_POST['thn_akhir'] : '';

// Pastikan format tanggal sesuai dengan SQL Server
$tanggal_akhir_format = str_pad($bln_akhir, 2, '0', STR_PAD_LEFT) . "-" . $thn_akhir;

// Query dengan filter bulan dan tahun
$sql = "
	SELECT service.*, divisi.* 
	FROM service
	INNER JOIN divisi ON service.divisi = divisi.namadivisi
	WHERE service.status = 'Selesai' 
	AND service.ket = 'L' 
	AND MONTH(service.tgl) = ?
	AND YEAR(service.tgl) = ?
	ORDER BY service.tgl ASC";
$params = [(int)$bln_akhir, (int)$thn_akhir]; 

$stmt = sqlsrv_query($conn, $sql, $params);

// Debugging: Cek apakah query berhasil
if ($stmt === false) {
	die("Query Error: " . print_r(sqlsrv_errors(), true));
}

// Debugging: Cek apakah ada data
if (!sqlsrv_has_rows($stmt)) {
	die("Tidak ada data untuk bulan: $bln_akhir tahun: $thn_akhir");
}

?>
<style>
.warna {
	background-color: #D3D3D3;
}
</style>
<table width="100%" cellpadding="3" cellspacing="0" border="1">
	<tr>
		<th align="center" colspan="8">
			<h4 align="right">FM-IT.00-25-004/R1</h4>
			<h2>DAFTAR SERVICE KELUAR PERANGKAT KOMPUTER</h2>
		</th>
	</tr>
	<tr class="warna">
		<th>No</th>
		<th>Waktu</th>
		<th>Pengirim</th>
		<th>Jenis Perangkat</th>
		<th>Permasalahan</th>
		<th>Penerima</th>
		<th>Status Kembali</th>
		<th>Lama</th>
	</tr>

<?php
$no = 0;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	$no++;
	$tgl = isset($database['tgl']) ? $database['tgl']->format('Y-m-d') : '';
	$tgl2 = isset($database['tgl2']) ? $database['tgl2']->format('Y-m-d') : '';
	$tgl3 = isset($database['tgl3']) ? $database['tgl3']->format('Y-m-d') : ''; // Tambahkan ini
	$nama = $database['nama'];
	$bagian = $database['bagian'];
	$perangkat = $database['perangkat'];
	$kasus = $database['kasus'];
	$penerima = $database['penerima'];
	$status = $database['status'];
	$luar = isset($database['luar']) ? $database['luar'] : '-';
	
	if (!empty($tgl2) && !empty($tgl3)) {
		$awal = date('d', strtotime($tgl2));
		$akhir = date('d', strtotime($tgl3));
		$bulan_awal = date('m', strtotime($tgl2));
		$bulan_akhir = date('m', strtotime($tgl3));
		$total_bulan = $bulan_akhir - $bulan_awal;
		$hbulan = ($total_bulan * 30) + ($akhir - $awal);

		if ($hbulan == 0) {
			$hbulan = 1;
		}
	} else {
		$hbulan = 1; // Jika tanggal kosong, default ke 1
	}

	$awal_cuti = $tgl;
	$akhir_cuti = $tgl2;
	
	// Pastikan tanggal valid sebelum diproses
	if (!$awal_cuti || !$akhir_cuti) {
		die("Error: Tanggal awal atau akhir cuti tidak valid.");
	}
	
	$awal_cuti = date_create($awal_cuti);
	$awal_cuti = date_format($awal_cuti, 'Y-m-d');
	$awal_cuti = strtotime($awal_cuti);
	
	$akhir_cuti = date_create($akhir_cuti);
	$akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
	$akhir_cuti = strtotime($akhir_cuti);
	
	// Pastikan tanggal awal lebih kecil dari tanggal akhir
	if ($akhir_cuti < $awal_cuti) {
		$temp = $awal_cuti;
		$awal_cuti = $akhir_cuti;
		$akhir_cuti = $temp;
	}
	
	$haricuti = array();
	$sabtuminggu = array();
	
	for ($i = $awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
		if (date('w', $i) !== '0' && date('w', $i) !== '6') {
			$haricuti[] = $i;
		} else {
			$sabtuminggu[] = $i;
		}
	}
	
	$jumlah_cuti = count($haricuti);
	$jumlah_sabtuminggu = count($sabtuminggu);
	$abtotal = $jumlah_cuti + $jumlah_sabtuminggu;
	
	// Pastikan jumlah cuti tidak negatif atau nol
	if ($jumlah_cuti == 1) {
		$jumlah_cuti = $jumlah_cuti;
	}
	
	if ($jumlah_cuti > 1) {
		$jumlah_cuti = $jumlah_cuti - 1;
	}
	
	if ($jumlah_cuti == 0) {
		$jumlah_cuti = 1;
	}
?>

	<tr class="isi_tabel">
		<td align="left" valign="top"><?php echo $no; ?></td>
		<td align="left" valign="top"><?php echo "&nbsp;" . $tgl; ?></td>
		<td align="left" valign="top"><?php echo $nama . "<br>" . $bagian; ?></td>
		<td align="left" valign="top"><?php echo $perangkat; ?></td>
		<td align="left" valign="top"><?php echo $kasus; ?></td>
		<td align="left" valign="top"><?php echo $penerima; ?></td>
		<td align="left" valign="top"><?php echo $status . "<br>- " . $luar . " (" . $tgl2 . ")"; ?></td>
		<td align="left" valign="top"><?php echo $hbulan . " hr"; ?></td>
	</tr>

<?php
}
?>
</table>

<!-- #region code lawas -->
<?php

// header("Content-type: application/octet-stream");
// header("Content-Disposition: attachment; filename=servicekeluar.xls");//ganti nama sesuai keperluan
// header("Pragma: no-cache");
// header("Expires: 0");

// $user_database="root";
// $password_database="dlris30g";
// $server_database="localhost";
// $nama_database="sitdl";
// $koneksi=mysql_connect($server_database,$user_database,$password_database);
// if(!$koneksi){
// die("Tidak bisa terhubung ke server".mysql_error());}
// $pilih_database=mysql_select_db($nama_database,$koneksi);
// if(!$pilih_database){
// die("Database tidak bisa digunakan".mysql_error());}

// $status=$_POST['status'];
// $bln_akhir=$_POST['bln_akhir'];
// $thn_akhir=$_POST['thn_akhir'];
// $tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
// $tanggal_akhir_format=$bln_akhir."-".$thn_akhir;

?>
<!-- // <style>
// .warna{background-color:#D3D3D3;
	
// }
// </style>
//  <table  width="100%" cellpadding="3" cellspacing="0" border="1">

// <tr>
// <th align="center" colspan="8"><h4 align="right">FM-IT.00-25-004/R1</h4><br><h2>DAFTAR SERVICE KELUAR PERANGKAT KOMPUTER</h2></th> 
// </tr> 
//  <tr class="warna">
               
//                   	<th>No</th>
//                     <th>Waktu </th>
// 					<th>Pengirim</th>
// 					<th>Jenis Perangkat</th>
// 					<th>Permasalahan</th>
// 					<th>Penerima</th>
// 					<th>Status Kembali</th>
// 					<th>Lama</th>
                   
// 				</tr> -->
 <?php
// $no=0;
// $perintah=mysql_query("SELECT service.*,divisi.* from service,divisi where service.divisi=divisi.kd AND service.status='Selesai' and service.ket='L' and service.tgl like '%".$tanggal_akhir_format."' ORDER BY service.tgl ASC");
// while($database=mysql_fetch_array($perintah)){
// 	$no=$no+1;
// $tgl=$database['tgl'];
// $nama=$database['nama'];
// $bagian=$database['bagian'];
// $barang=$database['barang'];
// $tgl2=$database['tgl2'];
// $divisi=$database['namadivisi'];
// $kasus=$database['kasus'];
// $penerima=$database['penerima'];
// $teknisi=$database['teknisi'];
// $tindakan=$database['tindakan'];
// $status=$database['status'];
// $ippc=$database['ippc'];
// $tgl3=$database['tgl3'];
// $luar=$database['luar'];
// $perangkat=$database['perangkat'];
// $awal=substr($tgl2,0,2);
// $akhir=substr($tgl3,0,2);
// $semua=$hbulan;
// $bulan_awal=substr($tgl2,3,2);
// $bulan_akhir=substr($tgl3,3,2);
// $total_bulan=$bulan_akhir-$bulan_awal;
// $hbulan=$total_bulan*30+$akhir-$awal;
// if($hbulan == 0){
// $hbulan=1;	
// }

// //$tanggal1 = new DateTime($tgl);
// //$tanggal2 = new DateTime($tgl2);

// //$days = round(($tanggal2->format('U') - $tanggal1->format('U')) / (60*60*24));

// //if($days == 0)
// //{
// //	$selisih = 1;
// //}
// //else
// //{
// //	$selisih = $days;
// //}

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
//     if (date('w', $i) !== '0' && date('w', $i) !== '6') {
//         $haricuti[] = $i;
//     } else {
//         $sabtuminggu[] = $i;
//     }
 
// }

// $jumlah_cuti = count($haricuti);
// $jumlah_sabtuminggu = count($sabtuminggu);
// $abtotal = $jumlah_cuti + $jumlah_sabtuminggu;

// if($jumlah_cuti == 1){

// 	$jumlah_cuti = $jumlah_cuti;
// }

// if($jumlah_cuti > 1){
// 	$jumlah_cuti = $jumlah_cuti - 1;
// }

// if($jumlah_cuti == 0){

// 	$jumlah_cuti = 1;
// }

?>
           
<!-- // <tr class="isi_tabel" >
    

//   //  <td align="left" valign="top"><?php echo $no; ?></td>
// 	//<td align="left" valign="top"><?php echo "&nbsp;".$tgl; ?></td>
// 	//<td align="left" valign="top"><?php echo $nama; ?><br><?php echo $bagian; ?><?php echo"-". $divisi; ?></td>
// 	//<td align="left" valign="top"><?php echo $perangkat; ?></td>
// 	//<td align="left" valign="top"><?php echo $kasus; ?></td>
// //	<td align="left" valign="top"><?php echo $penerima; ?></td>
// 	//<td align="left" valign="top"><?php echo $status; ?><br><?php echo "-".$luar; ?><?php echo "(".$tgl2.")"; ?></td>
// //	<td align="left" valign="top"><?php echo $jumlah_cuti."hr"; ?></td>
	
//   </tr> -->
<?php 
// } 
?>
<!-- #endregion -->