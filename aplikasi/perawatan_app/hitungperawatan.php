<?php
session_start();
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database, $conn);

// Buat query untuk menampilkan data berdasarkan filter
$query = "SELECT * FROM pcaktif WHERE nomor=0";

if (!empty($_GET['perangkat'])) {
    $perangkat = mysql_real_escape_string($_GET['perangkat']);
    $tahun = mysql_real_escape_string($_GET['tahun']);
    $qry	= mysql_query("SELECT nama_perangkat FROM tipe_perawatan WHERE id = $perangkat");
    $row	= mysql_fetch_array($qry); 
    $tipe = strtolower($row[0]);

    // $qry_item = mysql_query("SELECT COUNT(*) as jumlahperawatan FROM tipe_perawatan_item WHERE tipe_perawatan_id = $perangkat");
    // $row_item	= mysql_fetch_array($qry); 
    // $jumlahperawatan = $row_item[0];

    $qry_item = mysql_query("SELECT id as jumlahperawatan FROM tipe_perawatan_item WHERE tipe_perawatan_id = $perangkat");
    $jumlahperawatan = mysql_num_rows($qry_item);


    if(strtolower($tipe) == 'pc dan laptop')
    {
        $query = "SELECT 
                    idpc, 
                    user, 
                    lokasi, 
                    'PC' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND  tahun = $tahun) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND  tahun = $tahun) AS treated_by
                    FROM 
                    pcaktif WHERE 1=1";
 

    }else if(strtolower($tipe)  == 'printer'){
        //$query = "SELECT id_perangkat As idpc, user, lokasi as lokasi FROM printer where  1=1  ";

        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'printer' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat  AND  tahun = $tahun) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND  tahun = $tahun) AS treated_by
                    FROM 
                    printer WHERE 1=1";
    }
    else if(strtolower($tipe)  == 'scaner'){
        //$query = "SELECT id_perangkat As idpc, user, lokasi as lokasi FROM scaner where  1=1  ";
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'scaner' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND  tahun = $tahun) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND  tahun = $tahun) AS treated_by
                    FROM 
                    scaner WHERE 1=1";
    }
    
    else {
       
        //$query = "SELECT id_perangkat As idpc, user, lokasi as lokasi FROM peripheral where tipe = '$tipe' and 1=1  ";
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun ) AS hitung,
                    (SELECT tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND  YEAR(tanggal_perawatan) = $tahun LIMIT 1) AS tanggal,
                    (SELECT ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND  tahun = $tahun) AS keterangan,
                    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND  tahun = $tahun) AS treated_by
                    FROM 
                    peripheral WHERE tipe = '$tipe' and 1=1 ";
        //$query = "SELECT * FROM pcaktif WHERE 1=1";
    }
    // var_dump($perangkat);
    // exit;
    //$query = "SELECT * FROM pcaktif WHERE 1=1";
}

if (!empty($_GET['bulan'])) {
    $bulan = mysql_real_escape_string($_GET['bulan']);
    $query .= " AND bulan LIKE '%$bulan%'";
}

if (!empty($_GET['namadivisi'])) {
    $namadivisi = mysql_real_escape_string($_GET['namadivisi']);
    if(strtolower($tipe)  == 'printer' || strtolower($tipe)  == 'scaner'){
        $query .= " AND status LIKE '%$namadivisi%'";
    }else{
        $query .= " AND divisi LIKE '%$namadivisi%'";
    }
    //$namadivisi = mysql_real_escape_string($_GET['namadivisi']);
    
}


if (!empty($_GET['perangkat'])) {
$query .= " ORDER BY tanggal DESC";
}

// if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
//     $start_date = mysql_real_escape_string($_GET['start_date']);
//     $end_date = mysql_real_escape_string($_GET['end_date']);
//     $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
// }

$result = mysql_query($query, $conn);

$output = "";
if (mysql_num_rows($result) > 0) {
    $sudah = 0;
    $sedang =0;
    $belum = 0;
    while ($row = mysql_fetch_assoc($result)) {
       
        if ($row['hitung'] ==  $jumlahperawatan ) {
            $sudah++;
        } else if ($row['hitung'] < $jumlahperawatan && $row['hitung'] > 0  ){
            $sedang++;
        } else {
            $belum++;
        } 
        
    }
    $total = mysql_num_rows($result);
    $progress = $sudah/$total * 100;
        $output .= "<tr>";
        $output .= "<td>" . $sudah . "</td>";
        $output .= "<td>" . $sedang . "</td>";
        $output .= "<td>" . $belum . "</td>";
        $output .= "<td>" . $total  . "</td>";
        if($progress < 50){
            $output .= "<td style='background-color:#FE6868;'>" . round($progress, 2). " % </td>";
        }else if($progress >= 50){
            $output .= "<td style='background-color:#59F2ED;'>" . round($progress, 2). " % </td>";
        }
        $output .= "</tr>";

} else {
    $output .= "<tr><td colspan='3'>Tidak ada data ditemukan.</td></tr>";
}

echo $output;

mysql_close($conn);
?>
