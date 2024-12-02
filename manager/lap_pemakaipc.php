<?php
require('kop_pemakaipc.php');

 
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
$pdf->SetFont('Arial','',6);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(10,22,20,20,25,28,20,27,25,10,13,17,10,20,8,8));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");

$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;
$id_divisi=$_POST['id_divisi'];
$no=1;
//$s=mysql_query("select * from bagian_pemakai order by bag_pemakai asc");
//while($data=mysql_fetch_array($s)){
//$bag_pemakai=$data['bag_pemakai'];	


//mengambil data dari tabel
$sql=mysql_query("SELECT * from pcaktif where divisi like '%".$id_divisi."' and model='CPU' order by idpc asc  ");
//$sql=mysql_query("SELECT * from pcaktif where prosesor like '%DUAL CORE%' order by idpc asc  ");
$count=mysql_num_rows($sql);

for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
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

//$bag_pemakai=$database['bag_pemakai'];

//$pdf->Row(array($no++,$bagian,$user,$idpc,$namapc,$prosesor,$mobo,$ram,$harddisk,$monitor,$os,$ippc,$jumlah,$kabeh));

$pdf->Row(array($no++,$bagian,$subbagian,$user,$idpc,$namapc,$lokasi,$prosesor,$mobo,$ram,$harddisk,$monitor,$os,$ippc,$jumlah,$a));


//}//$pdf->Row(array($a,$a,$a,$a,$a,$a,$a,$a,$a,$a,$a,$a,$a,$a));
}


}
$pdf->Output();
?>
