<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $user = $_POST['user'];
    $divisi = $_POST['divisi'];
    $bagian = $_POST['bagian'];
    $subbagian = $_POST['subbagian'];
    $lokasi = $_POST['lokasi'];
    $idpc = $_POST['idpc'];
    //$idpcc = $_POST['idpcc'];
    $namapc = $_POST['namapc'];
    $ippc = $_POST['ippc'];
    $os = $_POST['os'];
    $prosesor = $_POST['prosesor'];
    $mobo = $_POST['mobo'];
    $monitor = $_POST['monitor'];
    $ram = $_POST['ram'];
    $harddisk = $_POST['harddisk'];
    $bulan = $_POST['bulan'];
    $ram1 = $_POST['ram1'];
    $ram2 = $_POST['ram2'];
    $hd1 = $_POST['hd1'];
    $dvd = $_POST['dvd'];
    $hd2 = $_POST['hd2'];
    $powersuply = $_POST['powersuply'];
    $cassing = $_POST['cassing'];
    $tgl_perawatan = $_POST['tgl_perawatan'];

    // Query untuk update data
    $query_update = "
        UPDATE pcaktif
        SET tgl_perawatan = ?, 
           [user] = ?, 
            idpc = ?, 
            namapc = ?,  
            bagian = ?, 
            subbagian = ?, 
            lokasi = ?
        WHERE nomor = ?
    ";

    // Parameter untuk query
    $params = [
        $tgl_perawatan, $user, $idpc, $namapc,  $bagian, $subbagian, $lokasi, $nomor
    ];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        header("location:../user.php?menu=rpemakaipc&stt=Update Berhasil");
    } else {
        echo "Gagal melakukan update. Error:<br>";
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
