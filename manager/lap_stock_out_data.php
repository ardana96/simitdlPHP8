<?php
require('kop_stock_out_pdf.php');

 
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

function generatebulan($tgl)
{

	$bln_angka = substr($tgl,5,2);
	
	$tahun = substr($tgl, 0,4);
	 console.log($bln_angka);
	 //var_dump($bln_angka);
	if($bln_angka == "01"){
	$bln_nama = "Januari";
}
else if ($bln_angka == "02") {
	$bln_nama="Februari";
}
else if ($bln_angka == "03") {
	$bln_nama="Maret";
}
else  if ($bln_angka == "04"){
	$bln_nama="April";
}
else if ($bln_angka == "05") {
	$bln_nama="Mei";
}
else if ($bln_angka == "06") {
	$bln_nama="Juni";
}
else if ($bln_angka == "07") {
	$bln_nama="Juli";
}
else if ($bln_angka == "08") {
	$bln_nama="Agustus";
}
else if ($bln_angka == "09") {
	$bln_nama="September";
}
else if ($bln_angka = "10") {
	$bln_nama="Oktober";
}
else if ($bln_angka = "11") {
	$bln_nama="November";
}
else {
	$bln_nama="Desember";
}

return $bln_nama." ".$tahun;

}


$pdf=new PDF ();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(10,30,25,35,45,20, 25));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
//$status=$_POST['status'];


$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$thn_akhir."-".$bln_akhir;
$kd_barang=$_POST['kd_barang'];
 
//mengambil data dari tabel
$sql=mysql_query("SELECT * from tpengambilan a, trincipengambilan b  where  a.nofaktur = b.nofaktur and idbarang='$kd_barang' 
				and a.tglambil like '".$tanggal_akhir_format."%'");
$count=mysql_num_rows($sql);
$no = 1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {

	
$user=$database['nama'];
$divisi=$database['divisi'];
$bagian=$database['bagian'];
$namabarang=$database['namabarang'];
$jumlah=$database['jumlah'];
$bulan = generatebulan($database['tglambil']);
//$bulan = "bulan";

$pdf->Row(array($no++, $user,$bagian,strtoupper($divisi),$namabarang,$jumlah, $bulan));

}}
$pdf->Output();
?>

