<?php
session_start();
include('../config.php');

if (isset($_POST['tombol'])) {
    $divisi = $_POST['divisi'];
} elseif (isset($_POST['refresh'])) {
    $divisi = null; // Jika tombol refresh diklik, jangan tampilkan data
} else {
    $divisi = null; // Jika tombol tidak diklik, jangan tampilkan data
}
?>

<style>
#pilih_laporan {
    background-color: #666;
    height: 30px;
    width: 100%;
    font-weight: bold;
    color: #FFF;
    text-transform: capitalize;
}
#tampil_laporan {
    height: auto;
    width: 100%;
    overflow: auto;
    text-transform: capitalize;
}
.judul_laporan {
    font-size: 14pt;
    font-weight: bold;
    color: #000;
    text-align: center;
}
.header_footer {
    background-color: #F5F5F5;
    text-align: center;
    font-weight: bold;
}
.isi_laporan {
    font-size: 10pt;
    color: #000;
    background-color: #FFF;
}
.resume_laporan {
    background-color: #333;
    font-weight: bold;
    color: #FFF;
}
@media print {
    #pilih_laporan {
        display: none;
    }
}
</style>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pemakaian Laptop</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="pilih_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td align="left">
                <form id="form_filter" name="form_filter" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <font color='white'>Divisi</font>
                    <select name="divisi" id="divisi">
                        <option value="">.:: Silahkan Pilih Divisi ::.</option>
                        <option value="garment">Garment</option>
                        <option value="textile">Textile</option>
                    </select>
                    <input type="submit" name="tombol" id="tombol" value="Filter" />
                    <input type="submit" name="refresh" id="refresh" value="Refresh" />
                    <input type="button" name="button_print" id="button_print" value="Cetak" onclick="window.print()" />
					<input type='button' value='Cetak PDF & EXCEL' onClick='top.location="lap_laptop_cetak.php"'>
                    <!-- <input type='button' value='Cetak PDF & EXCEL' onClick='top.location="lap_laptop_cetak_V2.php"'> -->
                </form>
            </td>
        </tr>
    </table>
</div>

<?php if ($divisi !== null) { ?>
<div id="tampil_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td colspan="6" align="center" class="judul_laporan">
                <p>Daftar Pemakaian Laptop</p>
                <br>
            </td>
        </tr>
        <tr class="header_footer">
            <td>Nomor</td>
            <td>User</td>
            <td>Divisi</td>
            <td>Bagian</td>
            <td>ID PC</td>
            <td>Nama PC</td>
        </tr>
        
        <?php
        $no = 1;
        $sql = "SELECT * FROM pcaktif WHERE model='laptop' " . ($divisi ? "AND (divisi = ? OR ? = '')" : "");
        $params = $divisi ? array($divisi, $divisi) : array();
        $stmt = sqlsrv_query($conn, $sql, $params);
        
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        while ($dataaa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $user = htmlspecialchars($dataaa['user']);
            $divisi = htmlspecialchars($dataaa['divisi']);
            $bagian = htmlspecialchars($dataaa['bagian']);
            $idpc = htmlspecialchars($dataaa['idpc']);
            $namapc = htmlspecialchars($dataaa['namapc']);
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $user; ?></td>
                <td><?php echo $divisi; ?></td>
                <td><?php echo $bagian; ?></td>
                <td><?php echo $idpc; ?></td>
                <td><?php echo $namapc; ?></td>
            </tr>
            <tr>
                <td colspan=6><hr></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php } ?>
</body>
</html>