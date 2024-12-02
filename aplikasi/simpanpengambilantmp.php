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
$nofaktur=kdauto("tpengambilan",'');


if(isset($_POST['button_selesai'])){
$ip=$_POST['ip'];
$tglambil=$_POST['tglambil'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$tgl_penjualan=date('Ymd');

//memasukan ke ke header tpengambilan 
$query="INSERT INTO tpengambilan (nofaktur,tglambil,jam,nama,bagian,divisi) 
VALUES ('".$nofaktur."','".$tglambil."','".$jam."','".$nama."','".$bagian."','".$divisi."')";
$insert=mysql_query($query);


//memasukan rinci pengambilan dati temporari

$ckrinci = mysql_query("SELECT * FROM tmprinciambil where ip='$ip'");
				if(mysql_num_rows($ckrinci) > 0){
				while($datackrinci = mysql_fetch_array($ckrinci)){
$idbarangrin=$datackrinci['idbarang'];
$namabarangrin=$datackrinci['namabarang'];
$jumlahrin=$datackrinci['jumlah'];
$nomorbarang = $datackrinci['NomorBarang'];
$nomorbarangL = $datackrinci['NomorBarangL'];

$mrinci="INSERT INTO trincipengambilan (nofaktur,idbarang,namabarang,jumlah,NomorBarang,NomorBarangKembali) 
VALUES ('".$nofaktur."','".$idbarangrin."','".$namabarangrin."','".$jumlahrin."','".$nomorbarang."', '".$nomorbarangL."')";
$insertt=mysql_query($mrinci);


				}}


//hapus file temporari 
$dd="delete from tmprinciambil where ip='$ip'";
$ddd=mysql_query($dd);
	
				
				
if($insert){
header('location:../pemakai.php?menu=ambiltmp&stt= Simpan Berhasil');}
else{echo "transaksi gagal";}}
else{
header('location:../pemakai.php?menu=ambiltmp&stt= Simpan Gagal');
}
?>