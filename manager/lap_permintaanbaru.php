<?php
session_start();
include('../config.php'); // Koneksi SQL Server

// Inisialisasi tanggal awal dan akhir
$tanggal_awal = $_POST['tgl_awal'] ?? '';
$tanggal_akhir = $_POST['tgl_akhir'] ?? '';
$tampilkan_data = isset($_POST['button_filter']); // Hanya tampilkan data jika filter diklik

// Format tanggal untuk tampilan
$tglbaru = empty($tanggal_awal) ? 'Semua' : date("d-m-Y", strtotime($tanggal_awal));
$tglbaru2 = empty($tanggal_akhir) ? 'Semua' : date("d-m-Y", strtotime($tanggal_akhir));

// Query untuk mendapatkan daftar permintaan utama
if (empty($tanggal_awal) || empty($tanggal_akhir)) {
    // Jika tanggal kosong, ambil semua data tanpa filter tanggal
    $query_permintaan = "SELECT * FROM permintaan ORDER BY nomor ASC";
    $get_permintaan = sqlsrv_query($conn, $query_permintaan);
} else {
    // Jika tanggal diisi, gunakan filter tanggal
    $query_permintaan = "SELECT * FROM permintaan WHERE tgl BETWEEN ? AND ? ORDER BY nomor ASC";
    $params = [$tanggal_awal, $tanggal_akhir];
    $get_permintaan = sqlsrv_query($conn, $query_permintaan, $params);
}

if ($get_permintaan === false) {
    die(print_r(sqlsrv_errors(), true));
}

$permintaan_data = [];
while ($row = sqlsrv_fetch_array($get_permintaan, SQLSRV_FETCH_ASSOC)) {
    $nomor = $row['nomor'];
    $permintaan_data[$nomor] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permintaan Barang</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .table-laporan {
            width: 95%;
            border-collapse: collapse;
            margin: auto;
            background: white;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table-laporan th {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            background-color: #555;
            color: white;
        }
        .table-laporan td {
            border: none;
            padding: 10px;
            text-align: left;
        }
        .table-laporan tr.separasi td {
            border-top: 2px solid #000;
        }
        .filter-container {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: transparent;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-container label {
            color: #333;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 10px;
        }
        .filter-container input[type="date"] {
            padding: 10px;
            margin: 8px;
            border: none;
            border-radius: 8px;
            background: #ffffff;
            color: #333;
            font-size: 14px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .filter-container input[type="date"]:hover,
        .filter-container input[type="date"]:focus {
            background: #e0e0ff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            outline: none;
        }
        .filter-container input[type="submit"],
        .filter-container input[type="button"] {
            padding: 12px 20px;
            margin: 8px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            background: #007bff;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
        }
        .filter-container input[type="submit"]:hover,
        .filter-container input[type="button"]:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.6);
        }
        .filter-container input[name="button_refresh"] {
            background: #28a745;
        }
        .filter-container input[name="button_refresh"]:hover {
            background: #1e7e34;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.6);
        }
        .filter-container input[name="button_print"] {
            background: #ff9500;
        }
        .filter-container input[name="button_print"]:hover {
            background: #cc7a00;
            box-shadow: 0 6px 20px rgba(255, 149, 0, 0.6);
        }
        /* Media query untuk mencetak */
        @media print {
            .filter-container {
                display: none; /* Menyembunyikan filter saat mencetak */
            }
            body {
                background: none; /* Menghilangkan background body saat mencetak */
                padding: 0; /* Menghilangkan padding saat mencetak */
            }
            .table-laporan {
                width: 100%; /* Membuat tabel penuh saat mencetak */
                box-shadow: none; /* Menghilangkan bayangan saat mencetak */
                border-radius: 0; /* Menghilangkan sudut melengkung */
            }
        }
    </style>
</head>
<body>

<div class="filter-container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="tgl_awal">Tanggal Awal:</label>
        <input type="date" name="tgl_awal" value="<?php echo htmlspecialchars($tanggal_awal); ?>">
        
        <label for="tgl_akhir">Tanggal Akhir:</label>
        <input type="date" name="tgl_akhir" value="<?php echo htmlspecialchars($tanggal_akhir); ?>">
        
        <input type="submit" name="button_filter" value="Filter">
        <input type="submit" name="button_refresh" value="Refresh">
        <input type="button" name="button_print" value="Print" onclick="window.print()">
    </form>
</div>

<?php if ($tampilkan_data) { ?>
<div id="tampil_laporan">
    <table class="table-laporan">
        <tr>
            <th colspan="7">
                Laporan Permintaan Barang <br> Periode: <?php echo "$tglbaru s/d $tglbaru2"; ?>
            </th>
        </tr>
        <tr>
            <th>Pemesan</th>
            <th>Bagian</th>
            <th>Tanggal</th>
            <th>Barang Pesanan</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Status</th>
        </tr>

        <?php 
        $firstRow = true;
        foreach ($permintaan_data as $nomor => $info) { 
            $tglbeliformat = ($info['tgl'] instanceof DateTime) ? $info['tgl']->format('d-m-Y') : date("d-m-Y", strtotime($info['tgl']));
        ?>
            <tr class="<?php echo $firstRow ? '' : 'separasi'; ?>">
                <td><?php echo htmlspecialchars($info['nama']); ?></td>
                <td><?php echo htmlspecialchars($info['bagian'] . '/' . $info['divisi']); ?></td>
                <td><?php echo $tglbeliformat; ?></td>
                <td><?php echo htmlspecialchars($info['namabarang']) . " (" . $info['qty'] . ")"; ?></td>
                <td>-</td>
                <td>-</td>
                <td><?php echo htmlspecialchars($info['status']); ?></td>
            </tr>

            <?php
            // Ambil rincian permintaan berdasarkan nomor
            $query_rincian = "SELECT * FROM rincipermintaan WHERE nomor = ?";
            $get_rincian = sqlsrv_query($conn, $query_rincian, [$nomor]);

            while ($rinci = sqlsrv_fetch_array($get_rincian, SQLSRV_FETCH_ASSOC)) {
                $ttrans = ($rinci['tanggal'] instanceof DateTime) ? $rinci['tanggal']->format('d-m-Y') : date("d-m-Y", strtotime($rinci['tanggal']));
            ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?php echo $ttrans; ?></td>
                    <td><?php echo htmlspecialchars($rinci['namabarang']); ?></td>
                    <td><?php echo htmlspecialchars($rinci['qtymasuk']); ?></td>
                    <td><?php echo htmlspecialchars($rinci['qtykeluar']); ?></td>
                    <td>-</td>
                </tr>
            <?php }
            $firstRow = false;
        } ?>
    </table>
</div>
<?php } ?>

</body>
</html>