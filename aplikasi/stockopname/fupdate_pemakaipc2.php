

<?php
// include('config.php'); // Koneksi database

// // Pastikan parameter nomor dan id tersedia
// if (!isset($_GET['nomor']) ) {
//     die("Parameter tidak lengkap.");
// }

// $nomor = $_GET['nomor'];


// $sql = "SELECT * 
//         FROM HistoryPcaktif WHERE nomor = ?  ORDER BY modifiedDate DESC";
// $params = [$nomor];
// $stmt = sqlsrv_query($conn, $sql, $params);

// if ($stmt === false) {
//     die("Gagal mengambil data: " . print_r(sqlsrv_errors(), true));
// }
?>

<?php
include(dirname(dirname(dirname(__FILE__))) . '/config.php');
?>
<?php
if (isset($_POST['nomor'], $_POST['id'])) {
    $nomor = $_POST['nomor'];
    $id = $_POST['id'];

    $query = "
DECLARE @nomor VARCHAR(10) = '30';
SELECT *
FROM (
    -- Mengambil data dari tabel HistoryPcaktif
    SELECT 
	nomor,
        ippc, 
        idpc, 
        [user], 
        namapc, 
        bagian, 
        subbagian, 
        lokasi,
        prosesor, 
        mobo, 
        ram, 
        harddisk, 
        bulan, 
        keterangan, 
        0 AS LastData,
		modifiedBy, 
		modifiedDate,
		updateFrom
    FROM HistoryPcaktif 
  
    
    UNION ALL
    
    -- Mengambil data dari tabel pcaktif
    SELECT 
	nomor,
        ippc, 
        idpc, 
        [user], 
        namapc, 
        bagian, 
        subbagian, 
        lokasi,
        prosesor, 
        mobo, 
        ram, 
        harddisk, 
        bulan, 
        keterangan, 
        1 AS LastData,
		(select Top 1 modifiedBy from HistoryPcaktif where nomor = @nomor Order By id DESC  ) As modifiedBy ,
		(select Top 1 modifiedDate from HistoryPcaktif where nomor = @nomor Order By id DESC  )  AS modifiedDate,
		(select Top 1 updateFrom from HistoryPcaktif where nomor = @nomor Order By id DESC  ) AS updateFrom
    FROM pcaktif 
) AS datass   WHERE nomor = @nomor Order By LastData";
   
    $params = [$nomor];
    $stmt = sqlsrv_query($conn, $query, $params);


} else {
    die("Error: Nomor atau ID tidak ditemukan dalam request.");
}

?>



<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemakai Komputer V2</title>
    <link rel="stylesheet" href="aplikasi/stockopname/stockopstyle/styleop.css">
    <!-- Jika ada Bootstrap atau CSS lain, pastikan tetap disertakan -->
</head>
<body>
<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Stock Opname</h2>
        </div>
    </div>
    <hr />

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                
                <div class="panel-body">
                    <div id="recordsPerPageContainer"></div>
                    <div class="table-responsive" style='overflow: scroll;'>
                        <table class="table table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>IP PC</th>
                                    <th>ID PC</th>
                                    <th>User</th>
                                    <th>Nama PC</th>
                                    <th>Bagian</th>
                                    <th>Sub Bagian</th>
                                    <th>Lokasi</th>
                                    <th>Prosesor</th>
                                    <th>Motherboard</th>
                                    <th>Ram</th>
                                    <th>Harddisk</th>
                                    <th>Bulan</th>
                                    <th>PIC</th>
                                    <th>Tanggal Update</th>
                                    <th>Keterangan</th>
                                    <th>Update Dari</th>
                                </tr>
                            </thead>
                            <tbody id="dataBodys">
                            <?php
                                if (sqlsrv_has_rows($stmt)) {
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $tgl_update = isset($row['modifiedDate']) ? $row['modifiedDate']->format('Y-m-d') : '-';

                                        // **Pastikan LastData ada & ubah ke integer untuk perbandingan**
                                        $rowStyle = (isset($row['LastData']) && intval($row['LastData']) === 1) ? "style='background-color:#d4edda;'" : "";
                                        ?>
                                        
                                        <tr <?php echo $rowStyle; ?>>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo htmlspecialchars($row['ippc']); ?></td>
                                            <td><?php echo htmlspecialchars($row['idpc']); ?></td>
                                            <td><?php echo htmlspecialchars($row['user']); ?></td>
                                            <td><?php echo htmlspecialchars($row['namapc']); ?></td>
                                            <td><?php echo htmlspecialchars($row['bagian']); ?></td>
                                            <td><?php echo htmlspecialchars($row['subbagian']); ?></td>
                                            <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                                            <td><?php echo htmlspecialchars($row['prosesor']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mobo']); ?></td>
                                            <td><?php echo htmlspecialchars($row['ram']); ?></td>
                                            <td><?php echo htmlspecialchars($row['harddisk']); ?></td>
                                            <td><?php echo htmlspecialchars($row['bulan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['modifiedBy']); ?></td>
                                            <td><?php echo $tgl_update; ?></td>
                                            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['updateFrom']); ?></td>
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='17'>Data tidak ditemukan.</td></tr>";
                                }

                                // **Bersihkan hasil query & tutup koneksi**
                                sqlsrv_free_stmt($stmt);
                                sqlsrv_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('scriptstop/scriptop.php'); ?>
</body>
</html>