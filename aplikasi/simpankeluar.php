<?php
session_start();
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
$nomorprinter=kdauto("printer",'');
$nomorscanner=kdauto("scaner",'');




if(isset($_POST['button_selesai'])){
$no_faktur=$_POST['no_faktur'];
$tglambil=$_POST['tglambil'];
$jam=$_POST['jam'];
$nomor=$_POST['nomor'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$tahun=substr($tglambil,-4,4);
$bulan=substr($tglambil,-7,2);
$tanggal=substr($tglambil,0,2);
$tglbaru=$tahun.'-'.$bulan.'-'.$tanggal;
//khusus untuk pemasukan printer
$jenisprinter=$_POST['jenisprinter'];
$id_perangkat=$_POST['id_perangkat'];
$printer=$_POST['printer'];
$keterangan=$_POST['keterangan'];
$ketlokasi=$_POST['ketlokasi'];





$query="INSERT INTO tpengambilan (nofaktur,tglambil,jam,nama,bagian,divisi,keterangan) 
VALUES ('".$no_faktur."','".$tglbaru."','".$jam."','".$nama."','".$bagian."','".$divisi."','".$keterangan."')";
$insert=mysql_query($query);
	
//tambahan untuk permintaan 
if($nomor<>"" ){

$cek=mysql_query("select * from trincipengambilan where nofaktur='".$no_faktur."'");
	  while($result=mysql_fetch_array($cek)){
	  $namabarang=$result['namabarang'];
	  $jumlah=$result['jumlah'];

	  $perintah="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtykeluar,tanggal) 
VALUES ('".$nomor."','".$no_faktur."','".$namabarang."','".$jumlah."','".$tglbaru."')";
	  $perintahh=mysql_query($perintah);}
	  
	  
	  	 $cstatus=mysql_query("select sum(qtymasuk) as totalmasuk,sum(qtykeluar) as totalkeluar from rincipermintaan where nomor='".$nomor."' ");
	  while($result=mysql_fetch_array($cstatus)){
	  $totalkeluar=$result['totalkeluar'];}
	  
	  $ccstatus=mysql_query("select * from permintaan where nomor='".$nomor."' ");
	  while($result=mysql_fetch_array($ccstatus)){
	  $totalpermintaan=$result['qty'];}
	  
	  if ($totalpermintaan==$totalkeluar){
		  $upstatus="UPDATE permintaan SET status= 'SELESAI' WHERE nomor='".$nomor."'";	
$uppstatus=mysql_query($upstatus);
	  }
}
	

if($jenisprinter=="printer" ){
$insprinter="insert into printer (nomor,id_perangkat,printer,keterangan,status) values 
('".$nomorprinter."','".$id_perangkat."','".$printer."','".$ketlokasi."','".$divisi."')";	
$inssprinter=mysql_query($insprinter);
}	

if($jenisprinter=="scanner" ){
$insprinter="insert into scaner (nomor,id_perangkat,printer,keterangan,status) values 
('".$nomorscanner."','".$id_perangkat."','".$printer."','".$ketlokasi."','".$divisi."')";	
$inssprinter=mysql_query($insprinter);
}	

$dd="update trincipengambilan set sesi='' where sesi='ADM'";
$ddd=mysql_query($dd);
	
	
if($insert){
header('location:../user.php?menu=keluar');}
else{echo "transaksi gagal";}}
else{
header('location:../user.php?menu=keluar');
}
?>