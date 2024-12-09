<?php
session_start();
include('../config.php');

if (isset($_POST['tombol'])) {
    $nofaktur = $_POST['nofaktur'];
    $tglbeli = $_POST['tglbeli'];
    $jam = $_POST['jam'];
    $idpc = $_POST['idpc'];
    $nomor = $_POST['nomor'];
    $idsupp = $_POST['idsupp'];
    $idpc = $_POST['idpc'];
    $mobo = $_POST['mobo'];
    $namapeminta = $_POST['namapeminta'];
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
    $noperlama = $_POST['noperlama'];
    $keterangan = $_POST['keterangan'];

    // Query untuk mendapatkan nofaktur dari trincipembelian
    $bbb = "SELECT nofaktur FROM trincipembelian WHERE namabarang = ?";
    $params_bbb = array($idpc);
    $stmt_bbb = sqlsrv_query($conn, $bbb, $params_bbb);

    $nofakturr = null;
    while ($rincibbb = sqlsrv_fetch_array($stmt_bbb, SQLSRV_FETCH_ASSOC)) {
        $nofakturr = $rincibbb['nofaktur'];
    }

    // Jika noper tidak kosong
    if ($noper !== "") {
        $aaa = "SELECT * FROM rincipermintaan WHERE nomor = ? AND namabarang = ? AND qtymasuk = '1'";
        $params_aaa = array($noperlama, $idpc);
        $stmt_aaa = sqlsrv_query($conn, $aaa, $params_aaa);

        if (sqlsrv_has_rows($stmt_aaa)) {
            // Update nomor pada rincipermintaan jika data ditemukan
            $cmdper = "UPDATE rincipermintaan SET nomor = ? WHERE nomor = ? AND namabarang = ? AND qtymasuk = '1'";
            $params_cmdper = array($noper, $noperlama, $idpc);
            sqlsrv_query($conn, $cmdper, $params_cmdper);
        } else {
            // Insert data baru ke rincipermintaan jika data tidak ditemukan
            $cmdper = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtymasuk, tanggal) 
                       VALUES (?, ?, ?, '1', ?)";
            $params_cmdper = array($noper, $nofakturr, $idpc, $tglbeli);
            sqlsrv_query($conn, $cmdper, $params_cmdper);
        }
    }

    // Query untuk update data pada tpc
    $query_update = "UPDATE tpc SET 
        mobo = ?, permintaan = ?, prosesor = ?, ps = ?, casing = ?, hd1 = ?, hd2 = ?, 
        ram1 = ?, ram2 = ?, fan = ?, dvd = ?, keterangan = ? WHERE idpc = ?";
    $params_update = array(
        $mobo, $namapeminta, $prosesor, $ps, $casing, $hd1, $hd2,
        $ram1, $ram2, $fan, $dvd, $keterangan, $idpc
    );
    $stmt_update = sqlsrv_query($conn, $query_update, $params_update);

    // Redirect berdasarkan hasil update
    if ($stmt_update) {
        header("location:../user.php?menu=stockpc&stt=Update Berhasil");
    } else {
        header("location:../user.php?menu=stockpc&stt=gagal");
    }
}
?>
