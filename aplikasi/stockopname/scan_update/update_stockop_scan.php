<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sesuaikan path inklusi config.php
include(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');

// Panggil save_lastpage.php untuk menyimpan status saat ini sebelum menampilkan form
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$saveLastPageUrl = $base_url . "/simitdlPHP8/aplikasi/stockopname/actionstop/save_lastpage.php";

$ch = curl_init($saveLastPageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'page' => isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1,
    'recordsPerPage' => isset($_SESSION['records_per_page']) ? $_SESSION['records_per_page'] : 10
]));
$response = curl_exec($ch);
if ($response === false) {
    error_log("Gagal memanggil save_lastpage.php saat Update: " . curl_error($ch));
} else {
    error_log("Respons dari save_lastpage.php saat Update: " . $response);
}
curl_close($ch);

// Periksa apakah id dan nomor dikirim melalui POST
if ( isset($_POST['nomor'])) {
    
    $nomor = $_POST['nomor'];

    $sql = "SELECT * FROM pcaktif WHERE  idpc = ?";
    $params = [$nomor];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Query gagal: " . print_r(sqlsrv_errors(), true));
    }

    if ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nomor = $result['nomor'];
        $user = $result['user'];
        $divisi = $result['divisi'];
        $bagian = $result['bagian'];
        $subbagian = $result['subbagian'];
        $lokasi = $result['lokasi'];
        $idpc = $result['idpc'];
        $ippc = $result['ippc'];
        $os = $result['os'];
        $prosesor = $result['prosesor'];
        $mobo = $result['mobo'];
        $monitor = $result['monitor'];
        $ram = $result['ram'];
        $harddisk = $result['harddisk'];
        $jumlah = $result['jumlah'];
        $tgl_update = $result['tgl_update'];
        $bulan = $result['bulan'];
        $tgl_masuk = $result['tgl_masuk'];
        $ram1 = $result['ram1'];
        $ram2 = $result['ram2'];
        $hd1 = $result['hd1'];
        $hd2 = $result['hd2'];
        $model = $result['model'];
        $namapc = $result['namapc'];
        $powersuply = $result['powersuply'];
        $cassing = $result['cassing'];
        $dvd = $result['dvd'];
        $seri = $result['seri'];
        $keterangan = $result['keterangan'];

        $sql_bulan = "SELECT bulan FROM bulan WHERE id_bulan = ?";
        $params_bulan = [$bulan];
        $stmt_bulan = sqlsrv_query($conn, $sql_bulan, $params_bulan);
        $namabulan = ($dataa = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) ? $dataa['bulan'] : '';

        

        $tglupdate = ($tgl_update instanceof DateTime) ? $tgl_update->format('Y-m-d') : substr($tgl_update, 0, 10);
    } else {
        echo "Data tidak ditemukan untuk  nomor: $nomor";
        exit;
    }
} else {
    echo "ID atau nomor tidak ditemukan dalam request.";
    exit;
}

include('update_index.php');
?>