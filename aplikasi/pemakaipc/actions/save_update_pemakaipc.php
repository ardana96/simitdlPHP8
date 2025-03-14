<?php
session_start();
include('../../../config.php');
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

error_log("Session sebelum update: " . print_r($_SESSION, true));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    
    $params = [$tgl_update, $divisi, $bagian, $subbagian, $lokasi, $user, $idpc, $namapc, 
               $os, $ippc, $harddisk, $ram, $monitor, $model, $ram1, $ram2, $hd1, $hd2, 
               $mobo, $prosesor, $powersuply, $cassing, $dvd, $seri, $bulan, $id, $nomor];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        error_log("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
        echo "Gagal menyimpan data: " . print_r(sqlsrv_errors(), true);
        exit;
    } else {
        // Panggil save_lastpage.php untuk memperbarui dengan current_page
        $url = $base_url . '/simitdlPHP8/aplikasi/pemakaipc/actions/save_lastpage.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'page' => isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1,
            'recordsPerPage' => isset($_SESSION['records_per_page']) ? $_SESSION['records_per_page'] : 10
        ]));
        $response = curl_exec($ch);
        if ($response === false) {
            error_log("Gagal memanggil save_lastpage.php: " . curl_error($ch));
        } else {
            error_log("Respons dari save_lastpage.php: " . $response);
        }
        curl_close($ch);

        // Perbarui session dengan nilai terakhir
        $currentPage = isset($_SESSION['last_page']) && $_SESSION['last_page'] > 0 ? (int)$_SESSION['last_page'] : (isset($_SESSION['current_page']) ? (int)$_SESSION['current_page'] : 1);
        $recordsPerPage = isset($_SESSION['last_limit']) && $_SESSION['last_limit'] > 0 ? (int)$_SESSION['last_limit'] : (isset($_SESSION['records_per_page']) ? (int)$_SESSION['records_per_page'] : 10);
        $_SESSION['current_page'] = $currentPage;
        $_SESSION['records_per_page'] = $recordsPerPage;
        error_log("Session dikonfirmasi sebelum redirect: current_page = $currentPage, records_per_page = $recordsPerPage");

        // Redirect ke user.php
        header("Location: $base_url/simitdlPHP8/user.php?menu=rpemakaipc");
        exit;
    }

    sqlsrv_free_stmt($stmt);
} else {
    echo "Metode request tidak valid.";
    exit;
}

sqlsrv_close($conn);
?>