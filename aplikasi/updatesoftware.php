<?php
include('../config.php');
if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
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
    $oleh = $_POST['oleh'];
    $status = $_POST['status'];
    $svc_kat = $_POST['svc_kat'];
    $tglRequest = $_POST['tglRequest'];

    // Query untuk update
    $query_update = "UPDATE software 
                     SET oleh = ?, tgl = ?, jam = ?, nama = ?, bagian = ?, divisi = ?, 
                         penerima = ?, kasus = ?, tgl2 = ?, jam2 = ?, tindakan = ?, svc_kat = ?, tglRequest = ? 
                     WHERE nomor = ?";
    $params = [$penerima, $tgl, $jam, $nama, $bagian, $divisi, $penerima, $kasus, $tgl2, $jam2, $tindakan, $svc_kat, $tglRequest, $nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        header("location:../user.php?menu=software&stt=Update Berhasil");
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
