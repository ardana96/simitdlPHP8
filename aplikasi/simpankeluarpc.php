<?
session_start();
include('../config.php');
$datee=date('20y-m-d');
 $jam = date("H:i");
$date=date('ymd');
function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);

    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);

    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;

    sqlsrv_free_stmt($stmt_max);

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}
$nofaktur=kdauto("tpengambilan",'');
$noservice=kdauto("service",'');


if (isset($_POST['button_selesai'])) {
    $nomor = $_POST['nomor'];
    $nomorminta = $_POST['nomorminta'];
    $user = $_POST['user'];
    $divisi = $_POST['divisi'];
    $bagian = $_POST['bagian'];
    $bagianambil = $_POST['bagianambil'];
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
    $powersupply = $_POST['powersupply'];
    $cassing = $_POST['cassing'];
    $idpcc = $_POST['idpcc'];
    $dvd = $_POST['dvd'];
    $model = $_POST['model'];
    $seri = $_POST['seri'];
    $teknisi = $_POST['teknisi'];
    $keterangan = $_POST['keterangan'];
    $datee = date('Y-m-d');
    $jam = date('H:i');

    // Update untuk monitor
    if (isset($_POST['monitor'])) {
        $monitor = $_POST['monitor'];
        $query = "SELECT * FROM tbarang WHERE namabarang = ?";
        $params = [$monitor];
        $cek = sqlsrv_query($conn, $query, $params);

        while ($result = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC)) {
            $idbarang = $result['idbarang'];
            $namabarang = $result['namabarang'];
            $stock = $result['stock'];
            $hasil = $stock - 1;

            $uk = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
            sqlsrv_query($conn, $uk, [$hasil, $idbarang]);

            $uk1y2 = "INSERT INTO trincipengambilan (nofaktur, idbarang, namabarang, jumlah) VALUES (?, ?, ?, ?)";
            sqlsrv_query($conn, $uk1y2, [$nofaktur, $idbarang, $namabarang, 1]);

            $rumus = "UPDATE pcaktif SET monitor = ? WHERE nomor = ?";
            sqlsrv_query($conn, $rumus, [$monitor, $nomor]);
        }
    }

    // Update untuk keyboard
    if (isset($_POST['keyboard'])) {
        $keyboard = $_POST['keyboard'];
        $query = "SELECT * FROM tbarang WHERE namabarang = ?";
        $params = [$keyboard];
        $cek1 = sqlsrv_query($conn, $query, $params);

        while ($result1 = sqlsrv_fetch_array($cek1, SQLSRV_FETCH_ASSOC)) {
            $idbarang1 = $result1['idbarang'];
            $namabarang1 = $result1['namabarang'];
            $stock1 = $result1['stock'];
            $hasil1 = $stock1 - 1;

            $uk1 = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
            sqlsrv_query($conn, $uk1, [$hasil1, $idbarang1]);

            $uk1y21 = "INSERT INTO trincipengambilan (nofaktur, idbarang, namabarang, jumlah) VALUES (?, ?, ?, ?)";
            sqlsrv_query($conn, $uk1y21, [$nofaktur, $idbarang1, $namabarang1, 1]);
        }
    }

    // Update untuk mouse
    if (isset($_POST['mouse'])) {
        $mouse = $_POST['mouse'];
        $query = "SELECT * FROM tbarang WHERE namabarang = ?";
        $params = [$mouse];
        $cek2 = sqlsrv_query($conn, $query, $params);

        while ($result2 = sqlsrv_fetch_array($cek2, SQLSRV_FETCH_ASSOC)) {
            $idbarang2 = $result2['idbarang'];
            $namabarang2 = $result2['namabarang'];
            $stock2 = $result2['stock'];
            $hasil2 = $stock2 - 1;

            $uk2 = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
            sqlsrv_query($conn, $uk2, [$hasil2, $idbarang2]);

            $uk1y22 = "INSERT INTO trincipengambilan (nofaktur, idbarang, namabarang, jumlah) VALUES (?, ?, ?, ?)";
            sqlsrv_query($conn, $uk1y22, [$nofaktur, $idbarang2, $namabarang2, 1]);
        }
    }

    // Tambahan untuk permintaan
    if (!empty($nomorminta)) {
        $perintah = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtykeluar, tanggal) VALUES (?, ?, ?, ?, ?)";
        sqlsrv_query($conn, $perintah, [$nomorminta, $nofaktur, $idpcc, 1, $datee]);

        $jrinciambil = "INSERT INTO trincipengambilan (nofaktur, idbarang, namabarang, jumlah) VALUES (?, ?, ?, ?)";
        sqlsrv_query($conn, $jrinciambil, [$nofaktur, '1pc', $idpcc, 1]);

        $jambil = "INSERT INTO tpengambilan (nofaktur, tglambil, jam, nama, bagian, divisi) VALUES (?, ?, ?, ?, ?, ?)";
        sqlsrv_query($conn, $jambil, [$nofaktur, $datee, $jam, $user, $bagianambil, $divisi]);
    }

    // Update tabel pcaktif
    $query = "INSERT INTO pcaktif (nomor, user, divisi, bagian, idpc, namapc, ippc, os, prosesor, mobo, monitor, ram, harddisk, jumlah, bulan, ram1, ram2, hd1, hd2, powersuply, cassing, tgl_masuk, dvd, model, seri)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$nomor, $user, $divisi, $bagian, $idpc, $namapc, $ippc, $os, $prosesor, $mobo, $monitor, $ram, $harddisk, $jumlah, $bulan, $ram1, $ram2, $hd1, $hd2, $powersupply, $cassing, $datee, $dvd, $model, $seri];
    $insert = sqlsrv_query($conn, $query, $params);

    if ($insert) {
        header('Location: ../user.php?menu=stockpc');
    } else {
        echo "Transaksi gagal.";
    }
} else {
    header('Location: ../user.php?menu=stockpc');
}
?>