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
// if (!sqlsrv_has_rows($stmt)) {
//     echo "<tr><td colspan='8' align='center'>Tidak ada data untuk bulan: $bln_akhir tahun: $thn_akhir</td></tr>";
// }


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
