<?php
include('../../../config.php');
// Tentukan BASE_URL secara dinamis
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $id = $_POST['id']; // Gunakan id langsung dari form
    $nomor = $_POST['nomor'];
    $user = $_POST['user'];
    $divisi = $_POST['divisi'];
    $bagian = $_POST['bagian'];
    $subbagian = $_POST['subbagian'];
    $lokasi = $_POST['lokasi'];
    $idpc = $_POST['idpc'];
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
    $hd2 = $_POST['hd2'];
    $powersuply = $_POST['powersuply'];
    $cassing = $_POST['cassing'];
    $dvd = $_POST['dvd'];
    $tgl_perawatan = $_POST['tgl_perawatan'];

    // Pastikan id tersedia (nomor tidak lagi wajib)
    if (empty($id)) {
        die("Error: ID tidak ditemukan.");
    }

    // Query untuk update data
    $query_update = "
        UPDATE pcaktif
        SET 
            tgl_perawatan = ?, 
            [user] = ?, 
            idpc = ?, 
            namapc = ?,  
            bagian = ?, 
            subbagian = ?, 
            lokasi = ?,
            bulan = ?
        WHERE id = ?
    ";

    // Parameter untuk query
    $params = [
        $tgl_perawatan, $user, $idpc, $namapc, $bagian, $subbagian, $lokasi, $bulan, $id
    ];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        header("Location:$base_url/simitdlPHP8/user.php?menu=rpemakaipc&stt=Update Berhasil");
        exit;
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