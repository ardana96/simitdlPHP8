<?php
require('laptop_table.php');

 
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
$pdf->SetFont('Arial','',10);
//Table with 20 rows and 5 columns
//$pdf->SetWidths(array(40,25,40,45,40));
$pdf->SetWidths(array(10,22,20,20,25,28,20,27,25,10,13,17,10,20,8,8));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
//$status=$_POST['status'];
$divisi=$_POST['divisi'];
$no=1;
 
//mengambil data dari tabel
$sql=mysql_query("SELECT * from pcaktif2  where model='laptop' and divisi='$divisi' ");
$count=mysql_num_rows($sql);
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
// data lama
// $user=$database['user'];
// $divisi=$database['divisi'];
// $bagian=$database['bagian'];
// $idpc=$database['idpc'];
// $namapc=$database['namapc'];

//$pdf->Row(array($user,strtoupper($divisi),$bagian,$idpc,$namapc));

$nomor=$database['nomor'];
$tanggal=$database['tanggal'];
$user=$database['user'];
$divisi=$database['divisi'];
$bagian=$database['bagian'];
$idpc=$database['idpc'];
$os=$database['os'];
$prosesor=$database['prosesor'];
$mobo=$database['mobo'];
$monitor=$database['monitor'];
$monitor=$database['monitor'];
$ram=$database['ram'];
$harddisk=$database['harddisk'];
$jumlah=$database['jumlah'];
$ganti=$database['ganti'];
$keterangan=$database['keterangan'];
$namapc=$database['namapc'];
$ippc=$database['ippc'];
$kabeh=mysql_num_rows($sql);
$subbagian = $database['subbagian'];
$lokasi = $database['lokasi'];


$pdf->Row(array($no++,$bagian,$subbagian,$user,$idpc,$namapc,$lokasi,$prosesor,$mobo,$ram,$harddisk,$monitor,$os,$ippc,$jumlah,$a));

}}
$pdf->Output();
?>

