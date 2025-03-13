<?php
session_start();
include('../../../config.php');

// Tentukan BASE_URL secara dinamis
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomoroke'];
    $user = $_POST['user'];
    $divisi = $_POST['divisi'];
    $bagian = $_POST['bagian'];
    $subbagian = $_POST['subbagian'];
    $lokasi = $_POST['lokasi'];
    //$bagianambil = $_POST['bagianambil'];
    $idpc = $_POST['idpc'];
    $namapc = $_POST['namapc'];
    $ippc = $_POST['ippc'];
    $os = $_POST['os'];
    $prosesor = $_POST['prosesor'];
    $mobo = $_POST['mobo'];
    $monitor = $_POST['monitor'];
    $ram = $_POST['ram'];
    $harddisk = $_POST['harddisk'];
    $jumlah = 1;
    $bulan = $_POST['bulan'];
    $ram1 = $_POST['ram1'];
    $ram2 = $_POST['ram2'];
    $hd1 = $_POST['hd1'];
    $hd2 = $_POST['hd2'];
    $powersupply = $_POST['powersuply'];
    $cassing = $_POST['cassing'];
    //$idpcc = $_POST['idpcc'];
    $dvd = $_POST['dvd'];
    //$teknisi = $_POST['teknisi'];
    //$keterangan = $_POST['keterangan'];
    $model = $_POST['model'];

    $query = "INSERT INTO pcaktif 
            (nomor, [user], divisi, bagian, subbagian, lokasi, idpc, namapc, ippc, os, prosesor, mobo, monitor, 
             ram, harddisk, jumlah, bulan, ram1, ram2, hd1, hd2, powersuply, cassing, dvd, model) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              
    $params = [
        $nomor, $user, $divisi, $bagian, $subbagian, $lokasi, $idpc, $namapc, $ippc, $os, $prosesor, $mobo, 
        $monitor, $ram, $harddisk, $jumlah, $bulan, $ram1, $ram2, $hd1, $hd2, $powersupply, $cassing, $dvd, $model
    ];
    
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt) {
        // Redirect ke halaman dengan BASE_URL yang sesuai
        header("Location: $base_url/simitdlPHP8/user.php?menu=stockop&stt=Simpan%20Berhasil");
        exit();
    } else {
        // Menampilkan error jika query gagal
        echo "Gagal menyimpan data. Error:<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "Code: " . $error['code'] . "<br />";
                echo "Message: " . $error['message'] . "<br />";
            }
        }
    }
}
?>
