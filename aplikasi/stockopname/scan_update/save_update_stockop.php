<?php
session_start();
include('../../../config.php');
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$session_user=$_SESSION['user'];
error_log("Session sebelum update: " . print_r($_SESSION, true));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //data dari perubahan
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
    // $ram1 = $_POST['ram1'];
    // $ram2 = $_POST['ram2'];
    // $hd1 = $_POST['hd1'];
    // $hd2 = $_POST['hd2'];
    $mobo = $_POST['mobo'];
    $prosesor = $_POST['prosesor'];
    //$powersuply = $_POST['powersuply'];
    //$cassing = $_POST['cassing'];
    //$dvd = $_POST['dvd'];
    $seri = $_POST['seri'];
    $bulan = $_POST['bulan'];
    $keterangan = $_POST['keterangan'];
    //insert ke history
    $sqlHis = "SELECT * FROM pcaktif WHERE idpc = ?";
    $paramsHis = [$idpc];
    $stmtHis = sqlsrv_query($conn, $sqlHis, $paramsHis);

    // if ($stmtHis === false) {
    //     die("Query gagal: " . print_r(sqlsrv_errors(), true));
    // }

    if ($result = sqlsrv_fetch_array($stmtHis, SQLSRV_FETCH_ASSOC)) {
        $nomorHis = $result['nomor'];
        $userHis = $result['user'];
        $divisiHis = $result['divisi'];
        $bagianHis = $result['bagian'];
        $subbagianHis = $result['subbagian'];
        $lokasiHis = $result['lokasi'];
        $idpcHis = $result['idpc'];
        $ippcHis = $result['ippc'];
        $osHis = $result['os'];
        $prosesorHis = $result['prosesor'];
        $moboHis = $result['mobo'];
        $monitorHis = $result['monitor'];
        $ramHis = $result['ram'];
        $harddiskHis = $result['harddisk'];
        $jumlahHis = $result['jumlah'];
        $tgl_updateHis = $result['tgl_update'];
        $bulanHis = $result['bulan'];
        $tgl_masukHis = $result['tgl_masuk'];
        $ram1His = $result['ram1'];
        $ram2His= $result['ram2'];
        $hd1His = $result['hd1'];
        $hd2His = $result['hd2'];

        
        $modelHis = $result['model'];
        $namapcHis = $result['namapc'];
        $powersuplyHis = $result['powersuply'];
        //$powersuplyHis = 'a';
        $cassingHis = $result['cassing'];
        //$cassingHis = 'a';
        $dvdHis = $result['dvd'];
        //$dvdHis = 'a';
        $seriHis = $result['seri'];
        $userHis = $result['user'];

        $sql_bulan = "SELECT bulan FROM bulan WHERE id_bulan = ?";
        $params_bulan = [$bulan];
        $stmt_bulan = sqlsrv_query($conn, $sql_bulan, $params_bulan);
        $namabulanHis = ($dataa = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) ? $dataa['bulan'] : '';
        $keteranganHis = $result['keterangan'];
        
        $tglupdateHis = ($tgl_update instanceof DateTime) ? $tgl_update->format('Y-m-d') : substr($tgl_update, 0, 10);
        //$tglupdateHis = date('Y-m-d');
        $modifiedDate = date('Y-m-d');
        $tgl_perawatan = $result['tgl_perawatan'];
        $updateFrom = "OPNAME";

        $queryInsertHis = "INSERT INTO HistoryPcaktif (
            nomor,
            [user],
            divisi, 
            bagian, 
            subbagian, 
            lokasi,
            idpc, 
            namapc, 
            ippc, 
            os, 
            prosesor, 
            mobo, 
            monitor,
            ram, 
            harddisk, 
            jumlah,
            tgl_update, 
            bulan,
            tgl_perawatan,
            ram1, 
            ram2, 
            hd1, 
            hd2, 
            powersuply,
            cassing, 
            tgl_masuk,
            dvd, 
            model, 
            seri, 
            modifiedBy,
            modifiedDate,
            keterangan,
            updateFrom
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
       
        $paramInsertHis =  [
            $nomorHis,
            $userHis,  
            $divisiHis, 
            $bagianHis,
            $subbagianHis, 
            $lokasiHis, 
            $idpcHis,  
            $namapcHis, 
            $ippcHis,
            $osHis, 
            $prosesorHis,
            $moboHis,
            $monitorHis,
            $ramHis, 
            $harddiskHis, 
            $jumlahHis,
            $tglupdateHis,
            $namabulanHis,
            $tgl_perawatan,
            $ram1His,
            $ram2His, 
            $hd1His, 
            $hd2His, 
            $powersuplyHis,
            $cassingHis,
            $tgl_masukHis,
            $dvdHis,
            $modelHis,
            $seriHis,
            $session_user,
            $modifiedDate,
            $keteranganHis,
            $updateFrom
        ];
        $stmtInsertHis = sqlsrv_query($conn, $queryInsertHis, $paramInsertHis);

        

       
        if (!$stmtInsertHis) {
            echo implode(", ", $paramInsertHis);
            //die("Error inserting item: " . print_r(sqlsrv_errors(), true));
            error_log("❌ INSERT gagal, tetapi lanjut ke UPDATE.");
        }else {
            error_log("✅ INSERT INTO HistoryPcaktif berhasil!");
        }
        sqlsrv_free_stmt($stmtInsertHis);
    } else {
        
        echo "Data tidak ditemukan untuk id: $id dan nomor: $nomor";
        exit;
    }



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
               
                mobo = ?, 
                prosesor = ?, 
               
                seri = ?, 
                bulan = ?,
                keterangan = ?
            WHERE idpc = ?";
    
    $params = [$tgl_update, $divisi, $bagian, $subbagian, $lokasi, $user, $idpc, $namapc, 
               $os, $ippc, $harddisk, $ram, $monitor, $model, 
               $mobo, $prosesor,  $seri, $bulan, $keterangan, $idpc];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        error_log("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
        echo "Gagal menyimpan data: " . print_r(sqlsrv_errors(), true);
        exit;
    } else {
        // Panggil save_lastpage.php untuk memperbarui dengan current_page
        $url = $base_url . '/simitdlPHP8/aplikasi/stockopname/actionstop/save_lastpage.php';
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
        header("Location: $base_url/simitdlPHP8/user.php?menu=stockop");
        exit;
    }

    sqlsrv_free_stmt($stmt);
} else {
    echo "Metode request tidak valid.";
    exit;
}


sqlsrv_close($conn);
?>