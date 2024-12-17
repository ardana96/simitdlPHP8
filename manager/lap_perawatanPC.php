<?php
require('kop_perawatanPC.php');
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



$pdf=new PDF ('L');
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(7,15,20,20,22,40,20,15,15,15,15,11,24,15,15,15));
//srand(microtime()*1000000);


//$status=$_POST['status'];
$bulan=$_POST['bulan'] ? $_POST['bulan'] : $_GET['bulan'];
$pdivisi=$_POST['pdivisi'] ? $_POST['pdivisi'] : $_GET['pdivisi'];
$tahun_rawat=$_POST['tahun'] ? $_POST['tahun'] : $_GET['tahun'];
function generatebulan($tgl)
{

	$bln_angka =  $tgl;
	
	$tahun = substr($tgl, 0,4);
	 //var_dump($bln_angka);
	if($bln_angka == "01"){
	$bln_nama = "JANUARI";
	}
	else if ($bln_angka == "02") {
		$bln_nama="FEBRUARI";
	}
	else if ($bln_angka == "03") {
		$bln_nama="MARET";
	}
	else  if ($bln_angka == "04"){
		$bln_nama="APRIL";
	}
	else if ($bln_angka == "05") {
		$bln_nama="MEI";
	}
	else if ($bln_angka == "06") {
		$bln_nama="JUNI";
	}
	else if ($bln_angka == "07") {
		$bln_nama="JULI";
	}
	else if ($bln_angka == "08") {
		$bln_nama="AGUSTUS";
	}
	else if ($bln_angka == "09") {
		$bln_nama="SEPTEMBER";
	}
	else if ($bln_angka == "10") {
		$bln_nama="OKTOBER";
	}
	else if ($bln_angka == "11") {
		$bln_nama="NOVEMBER";
	}
	else if ($bln_angka == "12"){
		$bln_nama="DESEMBER";
	}else{
		$bln_nama="SEMUA";
	}

	return $bln_nama;

}
$bulanGen = generatebulan($bulan);
$pdf->Header1($bulanGen);


//mengambil data dari tabel
//$sql=mysql_query("Select * from pcaktif where (bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (divisi LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') order by nomor ");
//$sql=mysql_query("Select * from pcaktif2  where  divisi='".$pdivisi."'order by nomor ");
$sql = "SELECT 
    a.idpc AS idpc,
    a.[user] AS [user],
    a.bagian AS bagian,
    b.tipe_perawatan_id,
    a.tgl_perawatan AS tgl_perawatan,
    a.namapc,
    b.tanggal_perawatan,
    (SELECT TOP 1 treated_by 
     FROM ket_perawatan 
     WHERE ket_perawatan.idpc = a.idpc AND tahun = ?) AS treated_by,
    (SELECT TOP 1 approve_by 
     FROM ket_perawatan 
     WHERE ket_perawatan.idpc = a.idpc AND tahun = ?) AS approve_by,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Fisik Pc dan Laptop' THEN 'true' ELSE '' END) AS item1,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi OS' THEN 'true' ELSE '' END) AS item2,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Apps' THEN 'true' ELSE '' END) AS item3,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi AV' THEN 'true' ELSE '' END) AS item4,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Monitor' THEN 'true' ELSE '' END) AS item5,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi CPU' THEN 'true' ELSE '' END) AS item6,
    MAX(CASE WHEN d.nama_perawatan = 'Kepatuhan penggunaan email dan internet' THEN 'true' ELSE '' END) AS item7
FROM 
    pcaktif a
LEFT JOIN 
    (SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = ?) AS b ON a.idpc = b.idpc
LEFT JOIN  
    tipe_perawatan_item d ON b.tipe_perawatan_item_id = d.id
WHERE 
    (a.bulan LIKE ? OR ? = '') AND 
    (a.divisi LIKE ? OR ? = '')
GROUP BY 
    a.idpc, a.[user], a.bagian, b.tipe_perawatan_id, a.tgl_perawatan, a.namapc, b.tanggal_perawatan
";

$params = array($tahun_rawat, $tahun_rawat, $tahun_rawat, "%$bulan%", $bulan, "%$pdivisi%", $pdivisi);

// Eksekusi Query
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tgl_perawatan = $database['tgl_perawatan'] ? $database['tgl_perawatan']->format('Y-m-d') : '';
    $namapc = $database['namapc'];
    $idpc = $database['idpc'];
    $user = $database['user'];
    $bagian = strtoupper($database['bagian']);
    $treated_by = $database['treated_by'];
    $approve_by = $database['approve_by'];
    $tanggal_realisasi = $database['tanggal_perawatan'] ? $database['tanggal_perawatan']->format('Y-m-d') : '';
    $item1 = $database['item1'];
    $item2 = $database['item2'];
    $item3 = $database['item3'];
    $item4 = $database['item4'];
    $item5 = $database['item5'];
    $item6 = $database['item6'];
    $item7 = $database['item7'];

    $tgl_jadwal = date('Y-m-d', strtotime('+1 year', strtotime($tgl_perawatan)));

    if ($tgl_jadwal == '1971-01-01') {
        $tgl_jadwal2 = '-';
    } else {
        $tgl_jadwal2 = $tgl_jadwal;
    }

    // Data untuk ditampilkan dalam PDF
    $data = array(
        array($no++, $bagian, $tgl_jadwal2, $tanggal_realisasi, $idpc, $namapc . '/' . $user, $item1, $item2, $item3, $item4, $item5, $item6, $item7, $treated_by, $approve_by, '')
    );

    // Cetak ke PDF
    foreach ($data as $row) {
        $pdf->RowWithCheck($row, 'true');
    }
}

// Output PDF
$pdf->Output();
sqlsrv_close($conn);
?>
