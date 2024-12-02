<?php
require('kop_ambil.php');

 
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
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$thn_akhir."-".$bln_akhir;
 
//mengambil data dari tabel
$sql=mysql_query("SELECT * from tpengambilan a,trincipengambilan b,bagian c,tbarang d where b.idbarang=d.idbarang and  
a.nofaktur=b.nofaktur and a.bagian=c.id_bagian and d.rutin='rutin' and
b.status<>'perakitan' and a.bagian<>'B079' and a.tglambil like '".$tanggal_akhir_format."%' order by a.tglambil asc  ");


$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$namabarang=$database['namabarang'];
$nama=$database['nama'];

$bagian=$database['bagian'];
$jumlah=$database['jumlah'];

$tglambil=$database['tglambil'];
$divisi=$database['divisi'];
$qty=$database['qty_keluar'];



$tglbaru=generatetgl($tglambil);

$pdf->Row(array($no++,strtoupper($namabarang),$jumlah,$tglbaru,strtoupper($nama)."\n".$bagian."-".$divisi));

}}
$pdf->Output();
?>

