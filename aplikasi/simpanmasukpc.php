<?php
session_start();
include('../config.php');


if(isset($_POST['tombol'])){
$nofaktur=$_POST['nofaktur'];
$tglbeli=$_POST['tglbeli'];
$jam=$_POST['jam'];
$pl=$_POST['pl'];
$seri=$_POST['seri'];
$nomor=$_POST['nomor'];
$idsupp=$_POST['idsupp'];
$idpc=$_POST['idpc'];
$mobo=$_POST['mobo'];
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
$keterangan=$_POST['keterangan'];
$namapeminta=$_POST['namapeminta'];


$moboo=$_POST['moboo'];
$prosesorr=$_POST['prosesorr'];
$pss=$_POST['pss'];
$casingg=$_POST['casingg'];
$hd11=$_POST['hd11'];
$hd22=$_POST['hd22'];
$ram11=$_POST['ram11'];
$ram22=$_POST['ram22'];
$fann=$_POST['fann'];
$dvdd=$_POST['dvdd'];

if($pl=='CPU'){
$ww="INSERT INTO tpc (idpc,mobo,prosesor,ps,casing,hd1,hd2,ram1,ram2,tglrakit,status,fan,dvd,keterangan,model,seri,permintaan) 
VALUES ('".$idpc."','".$mobo."','".$prosesor."','".$ps."','".$casing."','".$hd1."','".$hd2."'
,'".$ram1."','".$ram2."','".$tglbeli."','digudang','".$fan."','".$dvd."','".$keterangan."','".$pl."','".$seri."','".$namapeminta."')";
$www=mysql_query($ww);
}else{
$ww="INSERT INTO tpc (idpc,mobo,prosesor,ps,casing,hd1,hd2,ram1,ram2,tglrakit,status,fan,dvd,keterangan,model,seri,permintaan) 
VALUES ('".$idpc."','".$moboo."','".$prosesorr."','".$pss."','".$casingg."','".$hd11."','".$hd22."'
,'".$ram11."','".$ram22."','".$tglbeli."','digudang','".$fann."','".$dvdd."','".$keterangan."','".$pl."','".$seri."','".$namapeminta."')";
$www=mysql_query($ww);		
}


$qq="INSERT INTO trincipembelian (nofaktur,idbarang,namabarang,jumlah) 
VALUES ('".$nofaktur."','1pc','".$idpc."','1')";
$qqq=mysql_query($qq);

$query="INSERT INTO tpembelian (nofaktur,idsupp,tglbeli) 
VALUES ('".$nofaktur."','".$idsupp."','".$tglbeli."')";
$insert=mysql_query($query);
	
//tambahan untuk permintaan 
if($noper<>"" ){


	  $cmdper="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtymasuk,tanggal) 
VALUES ('".$noper."','".$nofaktur."','".$idpc."','1','".$tglbeli."')";
	  $cmdperr=mysql_query($cmdper);
	
	 
}			
	
	
				
if($insert){
header('location:../user.php?menu=masukpc');}
else{echo "transaksi gagal";}}
else{
header('location:../user.php?menu=masukpc');
}
?>