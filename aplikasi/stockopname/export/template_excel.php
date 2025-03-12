<?php
// Pastikan variabel $templateData tersedia dari exportexcel_data.php
if (!isset($templateData) || empty($templateData)) {
    echo "<table border='1'><tr><td colspan='14' style='text-align:center; font-weight:bold; color:red;'>Tidak ada data yang tersedia!</td></tr></table>";
    return;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        .header { 
            background-color: #D3D3D3; 
            font-weight: bold; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <th colspan="14" style="text-align:center;"><h2>DAFTAR PEMAKAI KOMPUTER</h2></th>
        </tr>
        <tr class="header">
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
            <th>Cek Perawatan</th>
        </tr>

        <?php 
        $no = 1;
        foreach ($templateData as $row) { ?>
            <tr>
                <td><?php echo htmlspecialchars($no, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['ippc'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['idpc'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['namapc'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['divisi'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['subbagian'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['lokasi'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['prosesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['mobo'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['ram'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['harddisk'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['bulan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['tgl_perawatan'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php 
            $no++; 
        } ?>
    </table>
</body>
</html>