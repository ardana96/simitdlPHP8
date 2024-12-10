<?php
include('../config.php');

function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);

    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);

    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;

    sqlsrv_free_stmt($stmt_max);

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}
$nomor=kdauto("software","");


if (isset($_POST['tombol_simpan'])) {

    $tgl = $_POST['tgl'];
    $jam = $_POST['jam'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $penerima = $_POST['penerima'];
    $kasus = $_POST['kasus'];
    $tglRequest = $_POST['tglRequest'];
    $tglApprove = $_POST['tglApprove'];

    $query_insert = "INSERT INTO software (nomor, tgl, jam, nama, bagian, divisi, penerima, kasus, tglrequest, tglapprove) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$nomor, $tgl, $jam, $nama, $bagian, $divisi, $penerima, $kasus, $tglRequest, $tglApprove];

    $stmt = sqlsrv_query($conn, $query_insert, $params);

    if ($stmt) {
        header("location:../user.php?menu=tasoftware&stt=Simpan Berhasil");
    } else {
        header("location:../user.php?menu=tasoftware&stt=gagal");
    }
}

if (isset($_POST['tombol_selesai'])) {

    $tgl = $_POST['tgl'];
    $jam = $_POST['jam'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $penerima = $_POST['penerima'];
    $kasus = $_POST['kasus'];

    $tgl2 = $_POST['tgl2'];
    $jam2 = $_POST['jam2'];
    $tindakan = $_POST['tindakan'];
    $svc_kat = $_POST['svc_kat'];
    $tglRequest = $_POST['tglRequest'];
    $tglApprove = $_POST['tglApprove'];

    $query_insert = "INSERT INTO software (nomor, tgl, jam, nama, bagian, divisi, penerima, kasus, svc_kat, tglrequest, tglapprove) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params_insert = [$nomor, $tgl, $jam, $nama, $bagian, $divisi, $penerima, $kasus, $svc_kat, $tglRequest, $tglApprove];

    $stmt_insert = sqlsrv_query($conn, $query_insert, $params_insert);

    $ubah = "UPDATE software SET tgl2 = ?, jam2 = ?, tindakan = ?, oleh = ?, svc_kat = ?, status = 'Selesai' 
             WHERE nomor = ?";
    $params_update = [$tgl2, $jam2, $tindakan, $penerima, $svc_kat, $nomor];

    $stmt_update = sqlsrv_query($conn, $ubah, $params_update);

    if ($stmt_insert && $stmt_update) {
        header("location:../user.php?menu=tasoftware&stt=Simpan Berhasil");
    } else {
        header("location:../user.php?menu=tasoftware&stt=gagal");
    }

	// if ($stmt_update) {
	// 	//header("location:../user.php?menu=tasoftware&stt=Simpan Berhasil");
	// 	echo 'sukses';
	// } else {
	// 	// Debugging error
	// 	echo "Query failed: " . $ubah . "<br>";
	// 	echo "Parameters: ";
	// 	print_r($params_update);
	// 	echo "<br>Error details:<br>";
	// 	if (($errors = sqlsrv_errors()) != null) {
	// 		foreach ($errors as $error) {
	// 			echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
	// 			echo "Code: " . $error['code'] . "<br>";
	// 			echo "Message: " . $error['message'] . "<br>";
	// 		}
	// 	}
	// 	//header("location:../user.php?menu=tasoftware&stt=gagal");
	// }
}

?>
