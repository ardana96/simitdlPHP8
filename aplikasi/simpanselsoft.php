<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $tgl2 = $_POST['tgl2'];
    $jam2 = $_POST['jam2'];
    $tindakan = $_POST['tindakan'];
    $svc_kat = $_POST['svc_kat'];
    $penerima = $_POST['penerima'];

    // Query untuk update
    $ubah = "UPDATE software 
             SET tgl2 = ?, jam2 = ?, tindakan = ?, oleh = ?, status = 'Selesai', svc_kat = ? 
             WHERE nomor = ?";
    $params = [$tgl2, $jam2, $tindakan, $penerima, $svc_kat, $nomor];

    // Menjalankan query
    $stmt = sqlsrv_query($conn, $ubah, $params);

    if ($stmt) {
        header("location:../user.php?menu=software&stt=Simpan Berhasil");
    } else {
        // Menangani error jika terjadi
        header("location:../user.php?menu=software&stt=gagal");
        echo "Error occurred.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    }
}
?>
