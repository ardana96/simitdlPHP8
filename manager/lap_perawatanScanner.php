<?php
require('kop_perawatanScanner.php');

 
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
$pdf->SetWidths(array(7,25,25,25,37,55,20,20,15,15,15,20));
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
//$sql=mysql_query("Select * from scaner where  (bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (status LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') order by nomor ");
//$sql=mysql_query("Select * from pcaktif2  where  divisi='".$pdivisi."'order by nomor ");

$sql=mysql_query("SELECT 
    a.id_perangkat ,
    a.user AS user,
    a.status AS bagian,
    b.tipe_perawatan_id,
    a.`tgl_perawatan` AS tgl_perawatan,
	a.lokasi,
	a.printer,
	b.tanggal_perawatan,
	(SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND  tahun = $tahun_rawat) AS treated_by,
    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = $tahun_rawat) AS approve_by,
    MAX(CASE WHEN d.nama_perawatan = 'Kesesuaian Aset' THEN 'true' END) AS item1,
    MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi Fisik Scanner' THEN 'true' END) AS item2,
    MAX(CASE WHEN d.`nama_perawatan` = 'Test Scan' THEN 'true' END) AS item3

FROM 
    scaner a
LEFT JOIN 
    

	(SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = '".$tahun_rawat."'  ) AS b ON a.id_perangkat = b.idpc

LEFT JOIN  
 	tipe_perawatan_item d ON b.`tipe_perawatan_item_id` = d.`id`

WHERE (a.bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (a.status LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') 
GROUP BY 
    a.id_perangkat, a.user, b.tipe_perawatan_id


");
$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
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

// $user=$database['user'];
// $keterangan=$database['keterangan'];
// $osbesar=strtoupper($os);
// $appsbesar=strtoupper($apps);
// $cpubesar=strtoupper($cpu);
// $monitorbesar=strtoupper($monitor);
// $printerbesar=strtoupper($printer);
// $bagian = $database['bagian'];
// $lokasi= $database['lokasi'];
// $bagianbesar = strtoupper($bagian);
// $id_perangkat = $database['id_perangkat'];
// $printer = $database['printer'];
$printer=$database['printer'];

$nomor=$database['nomor'];
$periode=$database['periode'];
$tgl_realisasi=$database['tgl_perawatan'];

$namapc=$database['namapc'];

$user=$database['user'];
$keterangan=$database['keterangan'];
$osbesar=strtoupper($os);
$appsbesar=strtoupper($apps);
$cpubesar=strtoupper($cpu);
$monitorbesar=strtoupper($monitor);
$printerbesar=strtoupper($printer);
$bagian = $database['bagian'];
$lokasi= $database['lokasi'];
$bagianbesar = strtoupper($bagian);
$id_perangkat = $database['id_perangkat'];
$tanggal_realisasi = $database['tanggal_perawatan'];
$item1 = $database['item1'];
$item2 = $database['item2'];
$item3 = $database['item3'];
$item4 = $database['item4'];
$treated_by = $database['treated_by'];
$approve_by = $database['approve_by'];
$b=mysql_query("select * from bulan where id_bulan='".$bulan."'");
while($dat=mysql_fetch_array($b)){
	$namabulan=$dat['bulan'];
	$bulanbesar=strtoupper($namabulan);
}

$tgl_jadwal = date('Y-m-d', strtotime('+1 year', strtotime( $tgl_realisasi )));

if ($tgl_jadwal == '1971-01-01')
	$tgl_jadwal2 = '-';
else 
	$tgl_jadwal2 = $tgl_jadwal;



//$pdf->Row(array($no++,$bulanbesar,$tgl_jadwal2,$ippc,$namapc.'/'.$user,$osbesar,$appsbesar,'',$cpubesar,$monitorbesar,$printerbesar,'','',$petugas,$a,$keterangan));

$data = array(
	//array($no++, $bagianbesar, $tgl_jadwal2, '', $id, $namapc.'/'.$user, $item1, $item2, $item3, $item4, $item5, $item6, $item7, '', '', ''),
	array($no++, $lokasi,$tgl_jadwal2,$tanggal_realisasi ,$id_perangkat,$printer.'/'.$user,$item1, $item2, $item3, $treated_by , $approve_by ,'')
	
	// Tambahkan baris lain jika diperlukan
);

//$pdf->Row(array($no++, $lokasi,$tgl_jadwal2,'',$id_perangkat,$printer.'/'.$user,'', '','','','',''));
foreach ($data as $row) {
    // Angka dalam array menunjukkan indeks kolom yang akan menampilkan gambar ceklis
    $pdf->RowWithCheck($row, 'true'); // Kolom ke-4, ke-7, dan ke-11 berisi gambar ceklis
}


}}
$pdf->Output();
?>
