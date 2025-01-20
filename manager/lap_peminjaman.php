<?php
// Menonaktifkan output sebelum PDF dihasilkan
ob_start();

require('mc_table.php');
include('../config.php');

// Inisialisasi PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetWidths(array(7, 25, 65, 65, 25));

// Ambil data dari form
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';

// Query SQL Server
$sql = "SELECT tpinjam.tgl1, trincipinjam.tgl2, tpinjam.telp, trincipinjam.namabarang, 
               tpinjam.nama, bagian.bagian, tpinjam.divisi
        FROM tpinjam
        INNER JOIN trincipinjam ON tpinjam.nopinjam = trincipinjam.nopinjam
        INNER JOIN bagian ON tpinjam.bagian = bagian.id_bagian
        WHERE MONTH(tpinjam.tgl1) = '".$bln_akhir."' AND YEAR(tpinjam.tgl1) = '".$thn_akhir."'
        ORDER BY tpinjam.tgl1";

// Gunakan parameterized query untuk keamanan
$params = array($bln_akhir, $thn_akhir);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) { 	
    exit(); // Jika error, hentikan skrip tanpa mencetak output
}

// Pengambilan data dari query
$no = 0;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $no++;
    $tgl1 = $database['tgl1']->format('Y-m-d');
    $tgl2 = $database['tgl2']->format('Y-m-d');
    $nama = strtoupper($database['nama']);
    $bagian = $database['bagian'];
    $divisi = $database['divisi'];
    $barang = strtoupper($database['namabarang']);
    $telp = $database['telp'];

    // Format tanggal
    $tglbaru = date("d-m-Y", strtotime($tgl1));
    $tglbaru2 = date("d-m-Y", strtotime($tgl2));

    // Tambahkan data ke dalam PDF
    $pdf->Row(array($no, $tglbaru, $nama . "\n" . $bagian . ' - ' . $divisi, $barang, $telp));
}

// Menutup koneksi SQL Server
sqlsrv_close($conn);

// Output PDF setelah semua eksekusi selesai
ob_end_clean(); // Bersihkan output buffer sebelum mencetak PDF
$pdf->Output();
?>


#region peminjaman pdf lama
<?php
// require('mc_table.php');
// include('../config.php');

 
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


// $pdf=new PDF ();
// $pdf->AddPage();
// $pdf->SetFont('Arial','',10);
// //Table with 20 rows and 5 columns
// $pdf->SetWidths(array(7,25,65,65,25));
// //srand(microtime()*1000000);

// //koneksi ke database

// //$status=$_POST['status'];
// $bln_akhir=$_POST['bln_akhir'];
// $thn_akhir=$_POST['thn_akhir'];

 
// // Query SQL Server
// $sql = "SELECT tpinjam.tgl1, trincipinjam.tgl2, tpinjam.telp, trincipinjam.namabarang, 
//                tpinjam.nama, bagian.bagian, tpinjam.divisi
//         FROM tpinjam
//         INNER JOIN trincipinjam ON tpinjam.nopinjam = trincipinjam.nopinjam
//         INNER JOIN bagian ON tpinjam.bagian = bagian.id_bagian
//         WHERE 

// 		MONTH(tpinjam.tgl1) = '".$bln_akhir."'
// 		AND YEAR(tpinjam.tgl1) = '".$thn_akhir."'
//         ORDER BY tpinjam.tgl1";

// //$params = array($tanggal_akhir_format . '%');
// $stmt = sqlsrv_query($conn, $sql);

// if ($stmt === false) { 	
//     die(print_r(sqlsrv_errors(), true));
// }

// // Pengambilan data dari query
// $no = 0;
// while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//     $no++;
//     $tgl1 = $database['tgl1']->format('Y-m-d');
//     $tgl2 = $database['tgl2']->format('Y-m-d');
//     $nama = strtoupper($database['nama']);
//     $bagian = $database['bagian'];
//     $divisi = $database['divisi'];
//     $barang = strtoupper($database['namabarang']);
//     $telp = $database['telp'];

//     // Format tanggal
//     $tglbaru = date("d-m-Y", strtotime($tgl1));
//     $tglbaru2 = date("d-m-Y", strtotime($tgl2));

//     // Tambahkan data ke dalam PDF
//     $pdf->Row(array($no, $tglbaru, $nama . "\n" . $bagian . ' - ' . $divisi, $barang, $telp));
// }

// // Menutup koneksi SQL Server
// sqlsrv_close($conn);

// // Output PDF
// $pdf->Output();
?>
#endregion
