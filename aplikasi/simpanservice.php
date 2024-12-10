<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $tanggal = $_POST['tgl'];
    $jam = $_POST['jam'];
    $bagian = $_POST['bagian'];
    $devisi = $_POST['devisi'];
    $perangkat = $_POST['perangkat'];
    $permasalahan = $_POST['permasalahan'];
    $it = $_POST['it'];
    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $ippc = $_POST['ippc'];
    $idpc = $_POST['idpc'];
    $tglRequest = $_POST['tglRequest'];

    // Tentukan query berdasarkan apakah `$idpc` kosong atau tidak
    if ($idpc == '') {
        $query_insert = "INSERT INTO service 
            (nomor, tgl, jam, nama, bagian, divisi, perangkat, kasus, penerima, [status], ippc, tglRequest) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($nomor, $tanggal, $jam, $nama, $bagian, $devisi, $perangkat, $permasalahan, $it, $status, $ippc, $tglRequest);
        //$params = array(null, null, null, null, null, null, null, null, null, null, null, null);
    } else {
        $query_insert = "INSERT INTO service 
            (nomor, tgl, jam, nama, bagian, divisi, perangkat, kasus, penerima, [status], ippc, tglRequest) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($nomor, $tanggal, $jam, $nama, $bagian, $devisi, $perangkat, $permasalahan, $it, $status, $idpc, $tglRequest);
        //$params = array(null, null, null, null, null, null, null, null, null, null, null, null);
    }

    // Eksekusi query
    $insert = sqlsrv_query($conn, $query_insert, $params);
    // if ($insert === false) {
    //     // Ambil pesan kesalahan
    //     $errors = sqlsrv_errors();
    //     foreach ($errors as $error) {
    //         echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
    //         echo "Code: " . $error['code'] . "<br>";
    //         echo "Message: " . $error['message'] . "<br>";
    //     }
    // } else {
    //     echo "Data berhasil disimpan!";
    // }

    // Jangan lupa tutup koneksi jika sudah selesai
    

    //Cek hasil query
    if ($insert) {
        header("location:../user.php?menu=service&stt=DATA BERHASIL DISIMPAN");
    } else {
        header("location:../user.php?menu=service&stt=DATA GAGAL DISIMPAN");
    }
    sqlsrv_close($conn);
}
?>
