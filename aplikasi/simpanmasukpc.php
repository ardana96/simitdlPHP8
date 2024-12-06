<?php
session_start();
include('../config.php');

if(isset($_POST['tombol'])){
    // Mengambil data dari form
    $nofaktur = $_POST['nofaktur'];
    $tglbeli = $_POST['tglbeli'];
    $jam = $_POST['jam'];
    $pl = $_POST['pl'];
    $seri = $_POST['seri'];
    $nomor = $_POST['nomor'];
    $idsupp = $_POST['idsupp'];
    $idpc = $_POST['idpc'];
    $mobo = $_POST['mobo'];
    $prosesor = $_POST['prosesor'];
    $ps = $_POST['ps'];
    $casing = $_POST['casing'];
    $hd1 = $_POST['hd1'];
    $hd2 = $_POST['hd2'];
    $ram1 = $_POST['ram1'];
    $ram2 = $_POST['ram2'];
    $fan = $_POST['fan'];
    $dvd = $_POST['dvd'];
    $noper = $_POST['noper'];
    $keterangan = $_POST['keterangan'];
    $namapeminta = $_POST['namapeminta'];

    // Data untuk model selain CPU
    $moboo = $_POST['moboo'];
    $prosesorr = $_POST['prosesorr'];
    $pss = $_POST['pss'];
    $casingg = $_POST['casingg'];
    $hd11 = $_POST['hd11'];
    $hd22 = $_POST['hd22'];
    $ram11 = $_POST['ram11'];
    $ram22 = $_POST['ram22'];
    $fann = $_POST['fann'];
    $dvdd = $_POST['dvdd'];

    if($pl == 'CPU'){
        // Query untuk CPU
        $ww = "INSERT INTO tpc (idpc, mobo, prosesor, ps, casing, hd1, hd2, ram1, ram2, tglrakit, status, fan, dvd, keterangan, model, seri, permintaan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'digudang', ?, ?, ?, ?, ?, ?)";
        $params = array($idpc, $mobo, $prosesor, $ps, $casing, $hd1, $hd2, $ram1, $ram2, $tglbeli, $fan, $dvd, $keterangan, $pl, $seri, $namapeminta);
    } else {
        // Query untuk model selain CPU
        $ww = "INSERT INTO tpc (idpc, mobo, prosesor, ps, casing, hd1, hd2, ram1, ram2, tglrakit, status, fan, dvd, keterangan, model, seri, permintaan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'digudang', ?, ?, ?, ?, ?, ?)";
        $params = array($idpc, $moboo, $prosesorr, $pss, $casingg, $hd11, $hd22, $ram11, $ram22, $tglbeli, $fann, $dvdd, $keterangan, $pl, $seri, $namapeminta);
    }

    // Eksekusi query untuk tpc
    $stmt = sqlsrv_query($conn, $ww, $params);

    // Query untuk trincipembelian
    $qq = "INSERT INTO trincipembelian (nofaktur, idbarang, namabarang, jumlah) 
           VALUES (?, '1pc', ?, '1')";
    $params_qq = array($nofaktur, $idpc);
    $stmt_qq = sqlsrv_query($conn, $qq, $params_qq);

    // Query untuk tpembelian
    $query = "INSERT INTO tpembelian (nofaktur, idsupp, tglbeli) 
              VALUES (?, ?, ?)";
    $params_query = array($nofaktur, $idsupp, $tglbeli);
    $stmt_query = sqlsrv_query($conn, $query, $params_query);

    // Tambahan untuk permintaan
    if($noper <> ""){
        $cmdper = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtymasuk, tanggal) 
                   VALUES (?, ?, ?, '1', ?)";
        $params_cmdper = array($noper, $nofaktur, $idpc, $tglbeli);
        $stmt_cmdper = sqlsrv_query($conn, $cmdper, $params_cmdper);
    }

    // Mengecek jika query berhasil
    if($stmt && $stmt_qq && $stmt_query){
        header('Location: ../user.php?menu=masukpc');
    } else {
        echo "Transaksi gagal: " . print_r(sqlsrv_errors(), true);
    }
} else {
    header('Location: ../user.php?menu=masukpc');
}
?>
