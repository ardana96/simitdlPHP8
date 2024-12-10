<?php
include('../config.php');

if ($_POST['nomorr']) {
    $nomorr = $_POST['nomorr'];
    $cek = $_POST['cek'];

    $query_update = "UPDATE software SET cetak = ? WHERE nomor = ?";
    $params = [$cek, $nomorr];

    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Menampilkan pesan error jika terjadi kesalahan
        echo "Error in query execution.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    } else {
        header("location:../user.php?menu=software&stt=Update Berhasil");
    }
}
?>
