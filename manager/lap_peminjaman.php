<?php
require('mc_table.php');

 
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


$pdf=new PDF ();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(7,25,65,65,25));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$thn_akhir."-".$bln_akhir;
 
//mengambil data dari tabel
$sql=mysql_query("SELECT * from tpinjam,trincipinjam,bagian where tpinjam.nopinjam=trincipinjam.nopinjam and tpinjam.bagian=bagian.id_bagian
and tpinjam.tgl1 like '".$tanggal_akhir_format."%'  order by tpinjam.tgl1 ");
$count=mysql_num_rows($sql);
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$no =$no+1;
$tgl1=$database['tgl1'];
$nama=$database['nama'];
$bagian=$database['bagian'];
$barang=$database['namabarang'];
$tgl2=$database['tgl2'];
$divisi=$database['divisi'];
$telp=$database['telp'];

$namabesar=strtoupper($nama);
$barangbesar=strtoupper($barang);
$tahun=substr($tgl1,0,4);
$bulan=substr($tgl1,-5,2);
$tanggal=substr($tgl1,-2,2);
$tglbaru=$tanggal.'-'.$bulan.'-'.$tahun;

$tahun2=substr($tgl2,0,4);
$bulan2=substr($tgl2,-5,2);
$tanggal2=substr($tgl2,-2,2);
$tglbaru2=$tanggal2.'-'.$bulan2.'-'.$tahun2;

$pdf->Row(array($no, $tglbaru,$namabesar."\n".$bagian.' - '.$divisi,$barangbesar,$telp));

}}
$pdf->Output();
?>

