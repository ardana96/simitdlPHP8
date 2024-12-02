<?php
include('../config.php');

function kdauto($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
	
}
$nomor=kdauto("software","");

if(isset($_POST['tombol_simpan'])){

$tgl=$_POST['tgl'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$penerima=$_POST['penerima'];
$kasus=$_POST['kasus'];
$tglRequest= $_POST['tglRequest'];
$tglApprove = $_POST['tglApprove'];

$query_insert="insert into software (nomor,tgl,jam,nama,bagian,divisi,penerima,kasus,tglrequest,tglapprove) 
values ('".$nomor."','".$tgl."','".$jam."','".$nama."','".$bagian."','".$divisi."','".$penerima."','".$kasus."', '".$tglrequest."', '".$tglApprove."')";

// $query_insert="insert into software (nomor,tgl,jam,nama,bagian,divisi,penerima,kasus) 
// values ('".$nomor."','".$tgl."','".$jam."','".$nama."','".$bagian."','".$divisi."','".$penerima."','".$kasus."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=tasoftware&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=tasoftware&stt=gagal");}}



if(isset($_POST['tombol_selesai'])){

$tgl=$_POST['tgl'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$penerima=$_POST['penerima'];
$kasus=$_POST['kasus'];

$tgl2=$_POST['tgl2'];
$jam2=$_POST['jam2'];
$tindakan=$_POST['tindakan'];
$svc_kat = $_POST['svc_kat'];
$tglRequest= $_POST['tglRequest'];
$tglApprove = $_POST['tglApprove'];

// Echo $tgl2.'<br>'.$jam2.'<br>'.$tindakan.'<br>'; }

$query_insert="insert into software (nomor,tgl,jam,nama,bagian,divisi,penerima,kasus,svc_kat, tglRequest, tglapprove) 
values ('".$nomor."','".$tgl."','".$jam."','".$nama."','".$bagian."','".$divisi."','".$penerima."','".$kasus."', '".$svc_kat."', '".$tglRequest."', '".$tglApprove."')";	
$update=mysql_query($query_insert);

$ubah="UPDATE software SET tgl2= '".$tgl2."',jam2= '".$jam2."',tindakan= '".$tindakan."',oleh= '".$penerima."', svc_kat='".$svc_kat."', status='Selesai' where nomor = '".$nomor."' ";	
$pubah=mysql_query($ubah);


if($update){
header("location:../user.php?menu=tasoftware&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=tasoftware&stt=gagal");}}

?>
