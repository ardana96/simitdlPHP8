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

if(isset($_POST['tombol'])){
	$id=kdauto("boking","");
$idbarang=$_POST['idbarang'];
$tgl=$_POST['tgl'];
$keperluan=$_POST['keperluan'];





$query_insert="insert into boking (id,idbarang,tgl,keperluan) 
values ('".$id."','".$idbarang."','".$tgl."','".$keperluan."')";	
$update=mysql_query($query_insert);

if($update){
header("location:../pemakai.php?menu=booking&stt= Simpan Berhasil");}
else{
header("location:../pemakai.php?menu=booking&stt=gagal");}
}
?>