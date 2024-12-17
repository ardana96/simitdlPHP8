<?php
require('kop_ambil.php');
include('../config.php');
 
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

function generatetgl($tgl){
	$tahun=substr($tgl,0,4);
	$bulan=substr($tgl,-5,2);
	$tanggal=substr($tgl,-2,2);

	return $tanggal.'-'.$bulan.'-'.$tahun;
}


$pdf=new PDF ();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(10,65,10,40,55));
//srand(microtime()*1000000);

//koneksi ke database
// Ambil parameter dari POST
//$status = $_POST['status'];
$bln_akhir = $_POST['bln_akhir'];
$thn_akhir = $_POST['thn_akhir'];

// Format tanggal akhir
$tanggal_akhir_format = $thn_akhir . "-" . $bln_akhir;

// Query SQL untuk mengambil data dari tabel
$query = "
    SELECT 
        d.namabarang, 
        a.nama, 
        c.bagian, 
        b.jumlah, 
        a.tglambil, 
        a.divisi
    FROM tpengambilan a
    INNER JOIN trincipengambilan b ON a.nofaktur = b.nofaktur
    INNER JOIN bagian c ON a.bagian = c.id_bagian
    INNER JOIN tbarang d ON b.idbarang = d.idbarang
    WHERE 
        d.rutin = 'rutin' AND 
        b.status <> 'perakitan' AND 
        a.bagian <> 'B079' 
        AND MONTH(a.tglambil) = '".$bln_akhir."'
		AND YEAR(a.tglambil) = '".$thn_akhir."'
    ORDER BY a.tglambil ASC
";

// Eksekusi query dengan parameter
$params = [$tanggal_akhir_format];
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Inisialisasi variabel untuk PDF
$count = 0;
$no = 1;

while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $namabarang = $database['namabarang'];
    $nama = $database['nama'];
    $bagian = $database['bagian'];
    $jumlah = $database['jumlah'];
    $tglambil = $database['tglambil'];
    $divisi = $database['divisi'];

    // Format tanggal untuk tampilan
    $tglbaru = generatetgl($tglambil->format('Y-m-d'));

    // Masukkan data ke PDF
    $pdf->Row(array(
        $no++,
        strtoupper($namabarang),
        $jumlah,
        $tglbaru,
        strtoupper($nama) . "\n" . $bagian . "-" . $divisi
    ));
}
$pdf->Output();
?>

