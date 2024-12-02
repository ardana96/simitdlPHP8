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
$sql=mysql_query("SELECT * from tpengambilan,trincipengambilan,bagian,tbarang where trincipengambilan.idbarang=tbarang.idbarang and  
tpengambilan.nofaktur=trincipengambilan.nofaktur and tpengambilan.bagian=bagian.id_bagian and tbarang.rutin='rutin' and
trincipengambilan.status<>'perakitan' and tpengambilan.bagian<>'B079' and tbarang.report='y' and tpengambilan.tglambil like '".$tanggal_akhir_format."%' order by tpengambilan.tglambil asc  ");
$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$namabarang=$database['namabarang'];
$nama=$database['nama'];
$nofaktur=$database['nofaktur'];
$bagian=$database['bagian'];
$jumlah=$database['jumlah'];
$jum=$database['jum'];
$tglambil=$database['tglambil'];
$divisi=$database['divisi'];
$qty=$database['qty_keluar'];
$namabesar=strtoupper($nama);
$barangbesar=strtoupper($namabarang);
$tahun=substr($tglambil,0,4);
$bulan=substr($tglambil,-5,2);
$tanggal=substr($tglambil,-2,2);
$tglbaru=$tanggal.'-'.$bulan.'-'.$tahun;
$pdf->Row(array($no++,$barangbesar,$jumlah,$tglbaru,$namabesar."\n".$bagian."-".$divisi));

}}
$pdf->Output();
?>

