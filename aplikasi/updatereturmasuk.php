<?php
include('../config.php');
if(isset($_POST['button_selesai'])){
$no_faktur=$_POST['no_faktur'];
$tglbeli=$_POST['tglbeli'];
$jam=$_POST['jam'];
$nomor=$_POST['nomor'];
$idsupp=$_POST['idsupp'];
$keterangan=$_POST['keterangan'];
$tahun=substr($tglbeli,-4,4);
$bulan=substr($tglbeli,-7,2);
$tanggal=substr($tglbeli,0,2);
$tglbaru=$tahun.'-'.$bulan.'-'.$tanggal;



$query_update="UPDATE tpembelian SET tglbeli= '".$tglbaru."',idsupp= '".$idsupp."',
keterangan= '".$keterangan."' WHERE nofaktur='".$no_faktur."'";	
$update=mysql_query($query_update);

//tambahan untuk permintaan 
if($nomor<>"" ){

$cek=mysql_query("select * from trincipembelian where nofaktur='".$no_faktur."'");
	  while($result=mysql_fetch_array($cek)){
	  $namabarang=$result['namabarang'];
	  $jumlah=$result['jumlah'];

	  $perintah="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtymasuk,tanggal) 
VALUES ('".$nomor."','".$no_faktur."','".$namabarang."','".$jumlah."','".$tglbaru."')";
	  $perintahh=mysql_query($perintah);}
	 
}

if($update){
header("location:../user.php?menu=returmasuk&stt= Update Berhasil");}
else{
header("location:../user.php?menu=returmasuk&stt=gagal");}}
?>