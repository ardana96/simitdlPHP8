<?php
session_start();
include('../config.php');


if(isset($_POST['tombol'])){
$nofaktur=$_POST['nofaktur'];
$tglbeli=$_POST['tglbeli'];
$jam=$_POST['jam'];
$idpc=$_POST['idpc'];
$nomor=$_POST['nomor'];
$idsupp=$_POST['idsupp'];
$idpc=$_POST['idpc'];
$mobo=$_POST['mobo'];
$namapeminta=$_POST['namapeminta'];
$prosesor=$_POST['prosesor'];
$ps=$_POST['ps'];
$casing=$_POST['casing'];
$hd1=$_POST['hd1'];
$hd2=$_POST['hd2'];
$ram1=$_POST['ram1'];
$ram2=$_POST['ram2'];
$fan=$_POST['fan'];
$dvd=$_POST['dvd'];
$noper=$_POST['noper'];
$noperlama=$_POST['noperlama'];
$keterangan=$_POST['keterangan'];

$bbb="SELECT nofaktur FROM trincipembelian WHERE namabarang='".$idpc."' ";
$pbbb=mysql_query($bbb);

while($rincibbb=mysql_fetch_array($pbbb)){
	$nofakturr=$rincibbb['nofaktur'];}

if($noper<>"" ){
	
	$aaa="SELECT * FROM rincipermintaan WHERE nomor='".$noperlama."' and namabarang='".$idpc."' and qtymasuk='1'  ";
$paaa=mysql_query($aaa);
	if(mysql_num_rows($paaa) > 0){
	     $cmdper="update rincipermintaan set nomor='".$noper."' WHERE nomor='".$noperlama."' and namabarang='".$idpc."' and qtymasuk='1'" ;
	     $cmdperr=mysql_query($cmdper);

	}else{
	  $cmdper="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtymasuk,tanggal) 
      VALUES ('".$noper."','".$nofakturr."','".$idpc."','1','".$tglbeli."')";
	  $cmdperr=mysql_query($cmdper);
	}
	 
}

$query_update="UPDATE tpc SET mobo= '".$mobo."',permintaan= '".$namapeminta."',prosesor= '".$prosesor."',ps= '".$ps."',casing= '".$casing."',hd1= '".$hd1."',
hd2= '".$hd2."',ram1= '".$ram1."',ram2= '".$ram2."',fan= '".$fan."',dvd= '".$dvd."',keterangan= '".$keterangan."' WHERE idpc='".$idpc."'";	
$update=mysql_query($query_update);

if($update){
header("location:../user.php?menu=stockpc&stt= Update Berhasil");}
else{
header("location:../user.php?menu=stockpc&stt=gagal");}
}