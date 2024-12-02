<?php
require('kop_perawatanRouter.php');

 
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
$pdf->SetWidths(array(7,25,25,25,37,55,20,22,18,15,15,15));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");

$status=$_POST['status'];
$bulan=$_POST['bulan'] ? $_POST['bulan'] : $_GET['bulan'];
$pdivisi=$_POST['pdivisi'] ? $_POST['pdivisi'] : $_GET['pdivisi'];
$tahun_rawat=$_POST['tahun'] ? $_POST['tahun'] : $_GET['tahun'];
function generatebulan($tgl)
{

	$bln_angka =  $tgl;
	
	$tahun = substr($tgl, 0,4);
	 console.log($bln_angka);
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
//$sql=mysql_query("Select * from peripheral where (bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (divisi LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '')and tipe = 'Switch/Router'  order by nomor ");
//$sql=mysql_query("Select * from pcaktif2  where  divisi='".$pdivisi."'order by nomor ");

$sql=mysql_query("SELECT 
    
    a.id_perangkat ,
    a.user,
    a.divisi AS bagian,
    b.tipe_perawatan_id,
    a.`tgl_perawatan` AS tgl_perawatan,
	a.lokasi,
	a.perangkat,
	
	b.tanggal_perawatan,
	(SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND  tahun = $tahun_rawat) AS treated_by,
    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = $tahun_rawat) AS approve_by,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Fisik Switch/Router' THEN 'true' END) AS item1,
    MAX(CASE WHEN d.`nama_perawatan` = 'Lampu Indikator Power dan Link' THEN 'true' END) AS item2,
    MAX(CASE WHEN d.`nama_perawatan` = 'Manageable Switch' THEN 'true' END) AS item3

FROM 
    peripheral a
LEFT JOIN 
    

	(SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = '".$tahun_rawat."'  ) AS b ON a.id_perangkat = b.idpc

LEFT JOIN  
 	tipe_perawatan_item d ON b.`tipe_perawatan_item_id` = d.`id`
WHERE LOWER(a.tipe) = 'switch/router' 
AND
(a.bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (a.divisi LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') 



GROUP BY 
    a.id_perangkat, a.user, b.tipe_perawatan_id



");
$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$nomor=$database['nomor'];
$tgl_perawatan=$database['tgl_perawatan'];
$tanggal_realisasi = $database['tanggal_perawatan'];
$user=$database['user'];
$keterangan=$database['keterangan'];

$bagian = $database['bagian'];
$lokasi= $database['lokasi'];

$id_perangkat = $database['id_perangkat'];
$perangkat = $database['perangkat'];
$item1 = $database['item1'];
$item2 = $database['item2'];
$item3 = $database['item3'];
$treated_by = $database['treated_by'];
$approve_by = $database['approve_by'];
$b=mysql_query("select * from bulan where id_bulan='".$bulan."'");
while($dat=mysql_fetch_array($b)){
	$namabulan=$dat['bulan'];
	$bulanbesar=strtoupper($namabulan);
}

// $tgl_jadwal = date('Y-m-d', strtotime('+1 year', strtotime( $tgl_realisasi )));

// if ($tgl_jadwal == '1971-01-01')
// 	$tgl_jadwal2 = '-';
// else 
// 	$tgl_jadwal2 = $tgl_jadwal;
$data = array(
	//array($no++, $bagianbesar, $tgl_jadwal2, '', $id, $namapc.'/'.$user, $item1, $item2, $item3, $item4, $item5, $item6, $item7, '', '', ''),
	array($no++, $lokasi,$tgl_perawatan,$tanggal_realisasi ,$id_perangkat,$perangkat.' / '.$user,$item1, $item2, $item3, $treated_by , $approve_by,'')
	//array($no++, $lokasi,$tgl_perawatan,'',$id_perangkat,$perangkat.' / '.$user,'','','','','','')
	
	
	// Tambahkan baris lain jika diperlukan
);
foreach ($data as $row) {
    // Angka dalam array menunjukkan indeks kolom yang akan menampilkan gambar ceklis
    $pdf->RowWithCheck($row, 'true'); // Kolom ke-4, ke-7, dan ke-11 berisi gambar ceklis
}


//$pdf->Row(array($no++,$bulanbesar,$tgl_jadwal2,$ippc,$namapc.'/'.$user,$osbesar,$appsbesar,'',$cpubesar,$monitorbesar,$printerbesar,'','',$petugas,$a,$keterangan));

//$pdf->Row(array($no++, $lokasi,$tgl_perawatan,'',$id_perangkat,$perangkat.' / '.$user,'','','','','',''));
}}
$pdf->Output();
?>
