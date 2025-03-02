<?php
// Mulai session untuk mengakses dan menyimpan data halaman
session_start();

// Include konfigurasi database dari level atas
include('../../../config.php');

// Periksa apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form
    $id = $_POST['id'];
    $nomor = $_POST['nomor'];
    $tgl_update = $_POST['tgl_update'];
    $divisi = $_POST['divisi'];
    $bagian = $_POST['bagian'];
    $subbagian = $_POST['subbagian'];
    $lokasi = $_POST['lokasi'];
    $user = $_POST['user'];
    $idpc = $_POST['idpc'];
    $namapc = $_POST['namapc'];
    $os = $_POST['os'];
    $ippc = $_POST['ippc'];
    $harddisk = $_POST['harddisk'];
    $ram = $_POST['ram'];
    $monitor = $_POST['monitor'];
    $model = $_POST['model'];
    $ram1 = $_POST['ram1'];
    $ram2 = $_POST['ram2'];
    $hd1 = $_POST['hd1'];
    $hd2 = $_POST['hd2'];
    $mobo = $_POST['mobo'];
    $prosesor = $_POST['prosesor'];
    $powersuply = $_POST['powersuply'];
    $cassing = $_POST['cassing'];
    $dvd = $_POST['dvd'];
    $seri = $_POST['seri'];
    $bulan = $_POST['bulan'];

    // Query untuk update data di tabel pcaktif
    $sql = "UPDATE pcaktif SET 
                tgl_update = ?, 
                divisi = ?, 
                bagian = ?, 
                subbagian = ?, 
                lokasi = ?, 
                [user] = ?, 
                idpc = ?, 
                namapc = ?, 
                os = ?, 
                ippc = ?, 
                harddisk = ?, 
                ram = ?, 
                monitor = ?, 
                model = ?, 
                ram1 = ?, 
                ram2 = ?, 
                hd1 = ?, 
                hd2 = ?, 
                mobo = ?, 
                prosesor = ?, 
                powersuply = ?, 
                cassing = ?, 
                dvd = ?, 
                seri = ?, 
                bulan = ?
            WHERE id = ? AND nomor = ?";
    
    $params = [
        $tgl_update, $divisi, $bagian, $subbagian, $lokasi, $user, $idpc, $namapc, 
        $os, $ippc, $harddisk, $ram, $monitor, $model, $ram1, $ram2, $hd1, $hd2, 
        $mobo, $prosesor, $powersuply, $cassing, $dvd, $seri, $bulan, $id, $nomor
    ];

    $stmt = sqlsrv_query($conn, $sql, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        echo "Gagal menyimpan data: " . print_r(sqlsrv_errors(), true);
        exit;
    } else {
        // Ambil currentPage dan recordsPerPage dari session (debug)
        $currentPage = isset($_SESSION['current_page']) && $_SESSION['current_page'] > 0 ? (int)$_SESSION['current_page'] : 1;
        $recordsPerPage = isset($_SESSION['records_per_page']) && $_SESSION['records_per_page'] > 0 ? (int)$_SESSION['records_per_page'] : 10;
        error_log("Session saat redirect: current_page = $currentPage, records_per_page = $recordsPerPage");

        // Redirect ke user.php tanpa parameter page dan limit di URL
        header("Location: http://localhost/simitdlPHP8/user.php?menu=stockop");
        exit;
    }

    // Bebaskan resource
    sqlsrv_free_stmt($stmt);
} else {
    echo "Metode request tidak valid.";
    exit;
}

// Tutup koneksi
sqlsrv_close($conn);
?>