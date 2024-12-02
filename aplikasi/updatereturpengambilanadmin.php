<?php
include('../config.php');
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



$query_update="UPDATE tpengambilan SET nama= '".$nama."',bagian= '".$bagian."',
divisi= '".$divisi."' WHERE nofaktur='".$no_faktur."'";	
$update=mysql_query($query_update);


//tambahan untuk permintaan 
if($nomor<>"" ){

$cek=mysql_query("select * from trincipengambilan where nofaktur='".$no_faktur."'");
	  while($result=mysql_fetch_array($cek)){
	  $namabarang=$result['namabarang'];
	  $jumlah=$result['jumlah'];

	  $perintah="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtykeluar,tanggal) 
VALUES ('".$nomor."','".$no_faktur."','".$namabarang."','".$jumlah."','".$tglambil."')";
	  $perintahh=mysql_query($perintah);
	  
	  }
	  
	  
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


if($update){
header("location:../user.php?menu=returadmin&stt= Update Berhasil");}
else{
header("location:../user.php?menu=returadmin&stt=gagal");}}
?>