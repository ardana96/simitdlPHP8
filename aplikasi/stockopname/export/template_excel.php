<?php
// Pastikan variabel $templateData tersedia dari exportexcel_data.php
if (!isset($templateData) || empty($templateData)) {
    echo "<table border='1'><tr><td colspan='16' style='text-align:center; font-weight:bold; color:red;'>Tidak ada data yang tersedia!</td></tr></table>";
    return;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        .warna { 
            background-color: #D3D3D3; 
            font-weight: bold; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <table border="1" cellpadding="3" cellspacing="0" width="100%">
        <tr>
            <th align="center" colspan="16"><h2>DAFTAR PEMAKAI KOMPUTER</h2></th>
        </tr>
        <tr class="warna">
            <th>No</th>
            <th>Bagian</th>
            <th>Sub Bagian</th>
            <th>User</th>
            <th>ID PC</th>
            <th>Nama PC</th>
            <th>Lokasi</th>
            <th>Prosesor</th>
            <th>Motherboard</th>
            <th>RAM</th>
            <th>Harddisk</th>
            <th>Monitor</th>
            <th>OS</th>
            <th>TCP/IP</th>
            <th>Cek Perawatan</th>
            <th>Jumlah</th> <!-- Kolom baru -->
        </tr>

        <?php
        $no = 1;
        foreach ($templateData as $database) {
            echo "<tr>";
            echo "<td align='left' valign='top'>" . $no++ . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['divisi']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['subbagian']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['user']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['idpc']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['namapc']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['lokasi']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['prosesor']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['mobo']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['ram']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['harddisk']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['monitor']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['os']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['ippc']) . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['tgl_perawatan'] ?? 'N/A') . "</td>";
            echo "<td align='left' valign='top'>" . htmlspecialchars($database['jumlah'] ?? 'N/A') . "</td>"; // Kolom Jumlah ditambahkan
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>