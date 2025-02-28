<?php
include('../config.php');
include('bar128.php');

$idbarang = $_POST['idbarang'] ?? '';

$query = "SELECT * FROM tbarang WHERE barcode = ?";
$params = [$idbarang];

// Menggunakan SQLSRV untuk SQL Server
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="../css/form.css" type="text/css">
    <link rel="stylesheet" href="../css/lap.css" type="text/css">
    <style>
        .glow { text-align: center; font-size: 30px; color: #fff; animation: blur .75s ease-out infinite; text-shadow: 0px 0px 5px #fff, 0px 0px 7px #fff; }
        @keyframes blur { from { text-shadow: 0px 0px 10px #fff, 0px 0px 50px #7B96B8; } }
        #pilih_laporan { background-color: #666; height: 30px; width: 100%; font-weight: bold; color: #FFF; text-transform: capitalize; }
        #tampil_laporan { height: auto; width: 100%; overflow: auto; text-transform: capitalize; }
        .judul_laporan { font-size: 14pt; font-weight: bold; color: #000; text-align: center; }
        .header_footer { background-color: #999; text-align: center; font-weight: bold; }
        .isi_laporan { font-size: 10pt; color: #000; background-color: #FFF; }
        .resume_laporan { background-color: #333; font-weight: bold; color: #FFF; }
        @media print { #pilih_laporan { display: none; } }
    </style>
    <script language="JavaScript" type="text/javascript" src="anggota.js"></script>
</head>
<body>
    <div id="view_oke">
        <div id="info_query">
            <?php if(isset($_GET['stt'])): ?>
                <p>Pesan: <?= htmlspecialchars($_GET['stt']); ?> <img src="img/centang.png" style="width: 50px; height: 30px;"></p>
            <?php endif; ?>
        </div>

        <div>
            <div id="pilih_laporan">
                <form id="form_filter" name="form_filter" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <font color="white">ID Barang:</font>
                    <input type="text" name="idbarang" required>
                    <input type="submit" name="button_filter" value="Filter">
                    <input type="button" name="button_print" value="Print" onclick="window.print();">
                </form>
            </div>

            <table width="auto" height="50px" cellpadding="3" cellspacing="0" border="0">
                <?php while ($faktur = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars($faktur['namabarang']); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="border: 3px double #ababab; padding: 5px; margin: 5px auto; width: auto;">
                                <?= bar128(stripslashes($idbarang)); ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
