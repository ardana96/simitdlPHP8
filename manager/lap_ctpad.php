<?php
ob_start(); // Menangani output buffering untuk menghindari error FPDF
require('kop_ctpad.php');
include('../config.php'); // Menggunakan koneksi SQL Server dari config.php


function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
// Table dengan 10 kolom
$pdf->SetWidths(array(10, 20, 25, 25, 60, 25, 30, 25, 20, 30));

$status = $_POST['status'] ?? '';
$bulan = $_POST['bulan'] ?? '';
$pdivisi = $_POST['pdivisi'] ?? '';

// Query untuk mengambil data dari tabel pcaktif
$query = "SELECT * FROM pcaktif WHERE bulan = ? AND divisi = ? ORDER BY nomor";
$params = [$bulan, $pdivisi];
$stmt = sqlsrv_query($conn, $query, $params);

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $nomor = $database['nomor'];
    $periode = $database['periode'];
    $tgl_realisasi = $database['tgl_perawatan'];
    $ippc = $database['ippc'];
    $namapc = $database['namapc'];
    $user = $database['user'];
    $petugas = $database['petugas'];
    $keterangan = $database['keterangan'];

    // Ambil nama bulan dari tabel bulan
    $query_bulan = "SELECT bulan FROM bulan WHERE id_bulan = ?";
    $stmt_bulan = sqlsrv_query($conn, $query_bulan, [$bulan]);

    if ($stmt_bulan === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $bulanbesar = '';
    if ($dat = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) {
        $bulanbesar = strtoupper($dat['bulan']);
    }

    // Konversi tanggal jadwal
    if ($tgl_realisasi instanceof DateTime) {
        $tgl_jadwal = $tgl_realisasi->modify('+1 year')->format('Y-m-d');
    } else {
        $tgl_jadwal = '-';
    }

    $pdf->Row(array($no++, $bulanbesar, $tgl_jadwal, $ippc, $namapc . '/' . $user, '', '', '', $petugas, $keterangan));
}

ob_end_clean(); // Bersihkan buffer sebelum Output
$pdf->Output();
?>


#region old code
<?php
// require('kop_ctpad.php');

 
// function GenerateWord()
// {
// 	//Get a random word
// 	$nb=rand(3,10);
// 	$w='';
// 	for($i=1;$i<=$nb;$i++)
// 		$w.=chr(rand(ord('a'),ord('z')));
// 	return $w;
// }

// function GenerateSentence()
// {
// 	//Get a random sentence
// 	$nb=rand(1,10);
// 	$s='';
// 	for($i=1;$i<=$nb;$i++)
// 		$s.=GenerateWord().' ';
// 	return substr($s,0,-1);
// }


// $pdf=new PDF ('L');
// $pdf->AddPage();
// $pdf->SetFont('Arial','',8);
// //Table with 20 rows and 5 columns
// $pdf->SetWidths(array(10,20,25,25,60,25,30,25,20,30));
// //srand(microtime()*1000000);

// //koneksi ke database
// mysql_connect("localhost","root","dlris30g");
// mysql_select_db("sitdl");

// $status=$_POST['status'];
// $bulan=$_POST['bulan'];
// $pdivisi=$_POST['pdivisi'];



// //mengambil data dari tabel
// $sql=mysql_query("Select * from pcaktif where bulan='".$bulan."' and divisi='".$pdivisi."' order by nomor ");
// $count=mysql_num_rows($sql);
// $no=1;
// for($i=0;$i<$count;$i++);{
// while ($database = mysql_fetch_array($sql)) {
// $nomor=$database['nomor'];
// $periode=$database['periode'];
// $tgl_realisasi=$database['tgl_perawatan'];
// $ip=$database['ip'];
// $nama=$database['nama_perangkat'];
// $os=$database['osp'];
// $apps=$database['apps'];
// $cpu=$database['cpu'];
// $urut=$database['urut'];
// $monitor=$database['monitorp'];
// $printer=$database['printer'];
// $petugas=$database['petugas'];
// $namapc=$database['namapc'];
// $ippc=$database['ippc'];
// $user=$database['user'];
// $keterangan=$database['keterangan'];
// $osbesar=strtoupper($os);
// $appsbesar=strtoupper($apps);
// $cpubesar=strtoupper($cpu);
// $monitorbesar=strtoupper($monitor);
// $printerbesar=strtoupper($printer);

// $b=mysql_query("select * from bulan where id_bulan='".$bulan."'");
// while($dat=mysql_fetch_array($b)){
// 	$namabulan=$dat['bulan'];
// 	$bulanbesar=strtoupper($namabulan);
// }

// $tgl_jadwal = date('Y-m-d', strtotime('+1 year', strtotime( $tgl_realisasi )));

// if ($tgl_jadwal == '1971-01-01')
// 	$tgl_jadwal2 = '-';
// else 
// 	$tgl_jadwal2 = $tgl_jadwal;

// $pdf->Row(array($no++,$bulanbesar,$tgl_jadwal2,$ippc,$namapc.'/'.$user,'','','',$petugas,$keterangan));
// }}
// $pdf->Output();
?>
#endregion