<?php
// Include konfigurasi database dari root
//include('../../../config.php'); // Dari stockopname -> aplikasi -> simitdlPHP8

// Periksa apakah id dan nomor dikirim melalui POST
if (isset($_POST['id']) && isset($_POST['nomor'])) {
    $id = $_POST['id'];
    $nomor = $_POST['nomor'];

    // Query untuk mengambil data dari pcaktif berdasarkan id dan nomor
    $sql = "SELECT * FROM pcaktif WHERE id = ? AND nomor = ?";
    $params = [$id, $nomor];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Query gagal: " . print_r(sqlsrv_errors(), true));
    }

    if ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Ekstrak semua kolom ke variabel
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

        // Ambil nama bulan dari tabel bulan
        $sql_bulan = "SELECT bulan FROM bulan WHERE id_bulan = ?";
        $params_bulan = [$bulan];
        $stmt_bulan = sqlsrv_query($conn, $sql_bulan, $params_bulan);
        $namabulan = ($dataa = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) ? $dataa['bulan'] : '';

        // Format tanggal update ke YYYY-MM-DD
        $tglupdate = ($tgl_update instanceof DateTime) ? $tgl_update->format('Y-m-d') : substr($tgl_update, 0, 10);
    } else {
        echo "Data tidak ditemukan untuk id: $id dan nomor: $nomor";
        exit;
    }
} else {
    echo "ID atau nomor tidak ditemukan dalam request.";
    exit;
}

// Include file HTML
include('update_index.php'); // Path relatif dari stockopname
?>