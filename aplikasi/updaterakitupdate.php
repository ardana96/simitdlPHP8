<?php
include('../config.php');
$datee=date('20y-m-d');
 $jam = date("H:i");
$date=date('ymd');
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
$noservice=kdauto("service",'');




if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$nomorminta=$_POST['nomorminta'];
$user=$_POST['user'];
$divisi=$_POST['divisi'];
$bagian=$_POST['bagian'];
$bagianambil=$_POST['bagianambil'];
$idpc=$_POST['idpc'];
$idpcc=$_POST['idpcc'];
$namapc=$_POST['namapc'];
$ippc=$_POST['ippc'];
$os=$_POST['os'];
$model=$_POST['model'];
$seri=$_POST['seri'];
$prosesor=$_POST['prosesor'];
$mobo=$_POST['mobo'];
$monitor=$_POST['monitor'];
$ram=$_POST['ram'];
$harddisk=$_POST['harddisk'];
$bulan=$_POST['bulan'];
$ram1=$_POST['ram1'];
$ram2=$_POST['ram2'];
$hd1=$_POST['hd1'];
$dvd=$_POST['dvd'];
$hd2=$_POST['hd2'];
$powersuply=$_POST['powersuply'];
$cassing=$_POST['cassing'];
$teknisi=$_POST['teknisi'];
$keterangan=$_POST['keterangan'];


//Update untuk monitor
if(isset($_POST['monitor'])){
$monitor=$_POST['monitor'];
$cek=mysql_query("select * from tbarang where namabarang='".$monitor."'");
	  while($result=mysql_fetch_array($cek)){
	 $idbarang=$result['idbarang'];
	  $namabarang=$result['namabarang'];
	  $stock=$result['stock'];
	  $hasil=$stock-1;
	  
$uk="update tbarang set stock='".$hasil."' where idbarang='".$idbarang."' ";	
$ukk=mysql_query($uk);


$uk1y2="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah) 
values ('".$nofaktur."','".$idbarang."','".$namabarang."','1') ";	
$ukk1y2=mysql_query($uk1y2);

$rumus="UPDATE pcaktif SET monitor='".$monitor."' WHERE nomor='".$nomor."'";	
$eks=mysql_query($rumus);

}}


if(isset($_POST['keyboard'])){
$keyboard=$_POST['keyboard'];
$cek1=mysql_query("select * from tbarang where namabarang='".$keyboard."'");
	  while($result1=mysql_fetch_array($cek1)){
	 $idbarang1=$result1['idbarang'];
	  $namabarang1=$result1['namabarang'];
	  $stock1=$result1['stock'];
	  $hasil1=$stock1-1;
	  
$uk1="update tbarang set stock='".$hasil1."' where idbarang='".$idbarang1."' ";	
$ukk1=mysql_query($uk1);


$uk1y21="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah) 
values ('".$nofaktur."','".$idbarang1."','".$namabarang1."','1') ";	
$ukk1y21=mysql_query($uk1y21);

}}

if(isset($_POST['mouse'])){
$mouse=$_POST['mouse'];
$cek2=mysql_query("select * from tbarang where namabarang='".$mouse."'");
	  while($result2=mysql_fetch_array($cek2)){
	 $idbarang2=$result2['idbarang'];
	  $namabarang2=$result2['namabarang'];
	  $stock2=$result2['stock'];
	  $hasil2=$stock2-1;
	  
$uk2="update tbarang set stock='".$hasil2."' where idbarang='".$idbarang2."' ";	
$ukk2=mysql_query($uk2);


$uk1y22="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah) 
values ('".$nofaktur."','".$idbarang2."','".$namabarang2."','1') ";	
$ukk1y22=mysql_query($uk1y22);

}}

//$cekambil=mysql_query("select * from trincipengambilan where nofaktur='".$nofaktur."'");
	//if(mysql_num_rows($cekambil) > 0){
//$mskpengambilan="insert into tpengambilan(nofaktur,tglambil,jam,nama,bagian,divisi) 
//values ('".$nofaktur."','".$datee."','".$jam."','".$user."','".$bagianambil."','".$divisi."') ";	
//$pmskpengambilan=mysql_query($mskpengambilan);
	//}


$kembang="update tpc set status='update',lokasi='$bagian',penerima='$user' where idpc='$idpcc'";
$perintah=mysql_query($kembang);

$cdservice="insert into service (nomor,perangkat,tgl,jam,nama,bagian,divisi,kasus,penerima,tgl2,jam2,tindakan,teknisi,ippc,status,ket,statup,keterangan)
 values ('".$noservice."','CPU','".$datee."','".$jam."','".$user."','".$bagian."','".$divisi."','Upgrade CPU Lama Ke CPU Baru',
 '".$teknisi."','".$datee."','".$jam."','Menganti CPU Lama dengan yang Baru','".$teknisi."','".$ippc."','selesai','D','upgrade','".$keterangan."')";
$pcdservice=mysql_query($cdservice);

$query_update="UPDATE pcaktif SET seri= '".$seri."',model= '".$model."',user= '".$user."',divisi= '".$divisi."',bagian= '".$bagian."',idpc= '".$idpc."',namapc= '".$namapc."',dvd= '".$dvd."',
ippc= '".$ippc."',os= '".$os."',prosesor= '".$prosesor."',mobo= '".$mobo."',ram= '".$ram."',harddisk= '".$harddisk."', 
bulan= '".$bulan."',ram1= '".$ram1."',ram2= '".$ram2."',hd1= '".$hd1."',hd2= '".$hd2."',powersuply= '".$powersuply."',cassing= '".$cassing."'
WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);


	//tambahan untuk permintaan 
if($nomorminta<>"" ){

	  $perintah="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtykeluar,tanggal) 
VALUES ('".$nomorminta."','".$nofaktur."','".$idpcc."','1','".$datee."')";
	  $perintahh=mysql_query($perintah);


	  $jrinciambil="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah) 
values ('".$nofaktur."','1pc','".$idpcc."','1') ";	
$jrinciambilp=mysql_query($jrinciambil);

$jambil="insert into tpengambilan(nofaktur,tglambil,jam,nama,bagian,divisi) 
values ('".$nofaktur."','".$datee."','".$jam."','".$user."','".$bagianambil."','".$divisi."') ";	
$jambilp=mysql_query($jambil);	  
	  
	  
 $ccstatus=mysql_query("select * from permintaan where nomor='".$nomorminta."' ");
	  while($result=mysql_fetch_array($ccstatus)){
	  $totalpermintaan=$result['qty'];}
	  
	  	  	 $cstatus=mysql_query("select sum(qtymasuk) as totalmasuk,sum(qtykeluar) as totalkeluar from rincipermintaan where nomor='".$nomorminta."' ");
	  while($result=mysql_fetch_array($cstatus)){
	  $totalkeluar=$result['totalkeluar'];}
	  
	  
	  if ($totalpermintaan==$totalkeluar){
		  $upstatus="UPDATE permintaan SET status= 'SELESAI' WHERE nomor='".$nomorminta."'";	
$uppstatus=mysql_query($upstatus);
	  }	  

	  		$ckmasuk = mysql_query("SELECT namabarang,qtymasuk FROM rincipermintaan  where namabarang='$idpcc' and qtymasuk='1'");
				if(mysql_num_rows($ckmasuk) > 0){}else{
					
	$ckpc = mysql_query("SELECT nofaktur FROM trincipembelian where namabarang='$idpcc'");
				while($datackpc = mysql_fetch_array($ckpc)){
				$nofakturbeli=$data['nofaktur'];}
					
						  $insmasuk="insert into rincipermintaan (nomor,nofaktur,namabarang,qtymasuk,tanggal) 
VALUES ('".$nomorminta."','".$nofakturbeli."','".$idpcc."','1','".$datee."')";	
$insmasukp=mysql_query($insmasuk);
				
				
				}
	  
	  
	 }else{
	  $jrinciambil="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah) 
values ('".$nofaktur."','1pc','".$idpcc."','1') ";	
$jrinciambilp=mysql_query($jrinciambil);
	 
$jambil="insert into tpengambilan(nofaktur,tglambil,jam,nama,bagian,divisi) 
values ('".$nofaktur."','".$datee."','".$jam."','".$user."','".$bagianambil."','".$divisi."') ";	
$jambilp=mysql_query($jambil);		 
		 
	 }

if($update){
header("location:../user.php?menu=stockpc&stt= Update Berhasil");}
else{
header("location:../user.php?menu=stockpc&stt=gagal");}}
?>