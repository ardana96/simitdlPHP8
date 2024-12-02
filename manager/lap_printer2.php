<?php
require('kop_printer.php');

 
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
$pdf->SetWidths(array(15,55,55,55,55));
//srand(microtime()*1000000);



//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;
 
//mengambil data dari tabel
$sql=mysql_query("SELECT * from printer where status='$status' order by id_perangkat");
$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$id_perangkat=$database['id_perangkat'];
$printer=$database['printer'];
$keterangan=$database['keterangan'];
$jenisprint=$database['jenisprint'];

$namabesar=strtoupper($nama);
$pdf->Row(array($no++,$id_perangkat,$printer,$keterangan));

}}

//mengambil data dari tabel
$sql2=mysql_query("SELECT * from scaner where status='$status' order by id_perangkat");
$count2=mysql_num_rows($sql2);
$no2=1;
for($i2=0;$i2<$count;$i2++);{
while ($database2 = mysql_fetch_array($sql2)) {
$id_perangkat2=$database2['id_perangkat'];
$printer2=$database2['printer'];
$keterangan2=$database2['keterangan'];
$jenisprint2=$database2['jenisprint'];

$namabesar2=strtoupper($nama);
$pdf->Row(array($no2++,$id_perangkat2,$printer2,$keterangan2));

}}



$pdf->Output();






?>



