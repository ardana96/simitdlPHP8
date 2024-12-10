<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = trim($_POST['nomor']);
    $tgl = $_POST['tgl'];
    $tgl2 = $_POST['tgl2'];
    $jam = $_POST['jam'];
    $nama = $_POST['nama'];
    $ippc = $_POST['ippc'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $perangkat = $_POST['perangkat'];
    $permasalahan = $_POST['permasalahan'];
    $it = $_POST['it'];
    $svc_kat = $_POST['svc_kat'];
    $tindakan = $_POST['tindakan'];

    //Query untuk update
    $query_update = "UPDATE service SET tgl = ?, jam = ?, nama = ?, ippc = ?, bagian = ?, divisi = ?, 
                         perangkat = ?, kasus = ?, penerima = ?, tgl2 = ?, svc_kat = ?, tindakan = ?
                     WHERE nomor = ?";
    $params = array($tgl, $jam, $nama, $ippc, $bagian, $divisi, $perangkat, $permasalahan, $it, $tgl2, $svc_kat, $tindakan, $nomor);
	
	// $query_update = "UPDATE service SET  nama = ?
    //                  WHERE nomor = '$nomor'";
    // $params = array( $nama);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

	// if ($stmt === false) {
	// 	$errors = sqlsrv_errors();
	// 	foreach ($errors as $error) {
	// 		echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
	// 		echo "Kode Kesalahan: " . $error[0] . "<br>";
	// 		echo "Pesan Kesalahan: " . $error[2] . "<br>";
	// 		echo $nomor;
	// 	}
	// 	die("Proses dihentikan karena error.");
	// } else {
	// 	echo "Data berhasil disimpan.";
	// 	echo $nomor;
	// 	echo $nama;
	// 	echo $ippc;
	// 	echo $bagian;
	// 	echo $divisi;
	// 	echo $perangkat;
	// 	echo $permasalahan;
	// 	echo $it;
	// 	echo $tgl;
	// }

    if ($stmt) {
        header("location:../user.php?menu=riwayat&stt=Update Berhasil");
    } else {
        echo "Error: " . print_r(sqlsrv_errors(), true);
        header("location:../user.php?menu=riwayat&stt=gagal");
    }
}
?>
