<?php
require('kop_ctpad.php');

 
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
$pdf->SetWidths(array(10,20,25,25,60,25,30,25,20,30));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");

$status=$_POST['status'];
$bulan=$_POST['bulan'];
$pdivisi=$_POST['pdivisi'];



//mengambil data dari tabel
$sql=mysql_query("Select * from pcaktif where bulan='".$bulan."' and divisi='".$pdivisi."' order by nomor ");
$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$nomor=$database['nomor'];
$periode=$database['periode'];
$tgl_realisasi=$database['tgl_perawatan'];
$ip=$database['ip'];
$nama=$database['nama_perangkat'];
$os=$database['osp'];
$apps=$database['apps'];
$cpu=$database['cpu'];
$urut=$database['urut'];
$monitor=$database['monitorp'];
$printer=$database['printer'];
$petugas=$database['petugas'];
$namapc=$database['namapc'];
$ippc=$database['ippc'];
$user=$database['user'];
$keterangan=$database['keterangan'];
$osbesar=strtoupper($os);
$appsbesar=strtoupper($apps);
$cpubesar=strtoupper($cpu);
$monitorbesar=strtoupper($monitor);
$printerbesar=strtoupper($printer);

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

$pdf->Row(array($no++,$bulanbesar,$tgl_jadwal2,$ippc,$namapc.'/'.$user,'','','',$petugas,$keterangan));
}}
$pdf->Output();
?>
