<?php
include('../config.php');
$datee=date('20y-m-d');
 $jam = date("H:i");
if(isset($_POST['tombol'])){

	if(isset($_POST['idpc'])){
$idpc=$_POST['idpc'];
$mobo=$_POST['mobo'];
$prosesor=$_POST['prosesor'];
$casing=$_POST['casing'];
$ps=$_POST['ps'];
$nofaktur=$_POST['nofaktur'];
$hd1=$_POST['hd1'];
$hd2=$_POST['hd2'];
$ram1=$_POST['ram1'];
$ram2=$_POST['ram2'];
$tglrakit=$_POST['tglrakit'];

$query="insert into tpc (idpc,tglrakit,status) values ('".$idpc."','".$tglrakit."','digudang')";	
	$insert=mysql_query($query);
// Update untuk mothrboard	
if(isset($_POST['mobo'])){
$mobo=$_POST['mobo'];
$cek=mysql_query("select * from tbarang where idbarang='".$mobo."'");
	  while($result=mysql_fetch_array($cek)){
	  $idbarang=$result['idbarang'];
	  $namabarang=$result['namabarang'];
	  $stock=$result['stock'];
	  $hasil=$stock-1;
	  
$up1="update tpc set mobo='".$namabarang."' where idpc='".$idpc."' ";	
$upp1=mysql_query($up1);
$uk1="update tbarang set stock='".$hasil."' where idbarang='".$idbarang."' ";	
$ukk1=mysql_query($uk1);

$uk1y="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang."','".$namabarang."','1','perakitan') ";	
$ukk1y=mysql_query($uk1y);

}}
//Update untuk prossor
if(isset($_POST['prosesor'])){
$prosesor=$_POST['prosesor'];
$cek2=mysql_query("select * from tbarang where idbarang='".$prosesor."'");
	  while($result=mysql_fetch_array($cek2)){
	  $idbarang2=$result['idbarang'];
	  $namabarang2=$result['namabarang'];
	  $stock2=$result['stock'];
	  $hasil2=$stock2-1;
	  
$up2="update tpc set prosesor='".$namabarang2."' where idpc='".$idpc."' ";	
$upp2=mysql_query($up2);
$uk2="update tbarang set stock='".$hasil2."' where idbarang='".$idbarang2."' ";	
$ukk2=mysql_query($uk2);

$uk1y1="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang2."','".$namabarang2."','1','perakitan') ";	
$ukk1y1=mysql_query($uk1y1);

}}	

//Update untuk power supply
if(isset($_POST['ps'])){
$ps=$_POST['ps'];
$cek3=mysql_query("select * from tbarang where idbarang='".$ps."'");
	  while($result=mysql_fetch_array($cek3)){
	  $idbarang3=$result['idbarang'];
	  $namabarang3=$result['namabarang'];
	  $stock3=$result['stock'];
	  $hasil3=$stock3-1;
	  
$up3="update tpc set ps='".$namabarang3."' where idpc='".$idpc."' ";	
$upp3=mysql_query($up3);
$uk3="update tbarang set stock='".$hasil3."' where idbarang='".$idbarang3."' ";	
$ukk3=mysql_query($uk3);

$uk1y2="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang3."','".$namabarang3."','1','perakitan') ";	
$ukk1y2=mysql_query($uk1y2);

}}		

//Update untuk Casing
if(isset($_POST['casing'])){
$casing=$_POST['casing'];
$cek8=mysql_query("select * from tbarang where idbarang='".$casing."'");
	  while($result=mysql_fetch_array($cek8)){
	  $idbarang8=$result['idbarang'];
	  $namabarang8=$result['namabarang'];
	  $stock8=$result['stock'];
	  $hasil8=$stock8-1;
	  
$up8="update tpc set casing='".$namabarang8."' where idpc='".$idpc."' ";	
$upp8=mysql_query($up8);
$uk8="update tbarang set stock='".$hasil8."' where idbarang='".$idbarang8."' ";	
$ukk8=mysql_query($uk8);

$uk1y7="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang8."','".$namabarang8."','1','perakitan') ";	
$ukk1y7=mysql_query($uk1y7);

}}	

//Update untuk Harddisk Satu
if(isset($_POST['hd1'])){
$hd1=$_POST['hd1'];
$cek4=mysql_query("select * from tbarang where idbarang='".$hd1."'");
	  while($result=mysql_fetch_array($cek4)){
	  $idbarang4=$result['idbarang'];
	  $namabarang4=$result['namabarang'];
	  $stock4=$result['stock'];
	  if($stock4<>0){
	  $hasil4=$stock4-1;
$up4="update tpc set hd1='".$namabarang4."' where idpc='".$idpc."' ";	
$upp4=mysql_query($up4);
$uk4="update tbarang set stock='".$hasil4."' where idbarang='".$idbarang4."' ";	
$ukk4=mysql_query($uk4);

$uk1y3="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang4."','".$namabarang4."','1','perakitan') ";	
$ukk1y3=mysql_query($uk1y3);
	  }
}}	

//Update untuk Harddisk Dua
if(isset($_POST['hd2'])){
$hd2=$_POST['hd2'];
$cek5=mysql_query("select * from tbarang where idbarang='".$hd2."'");
	  while($result=mysql_fetch_array($cek5)){
	  $idbarang5=$result['idbarang'];
	  $namabarang5=$result['namabarang'];
	  $stock5=$result['stock'];
	   if($stock5<>0){
	  $hasil5=$stock5-1;
$up5="update tpc set hd2='".$namabarang5."' where idpc='".$idpc."' ";	
$upp5=mysql_query($up5);
$uk5="update tbarang set stock='".$hasil5."' where idbarang='".$idbarang5."' ";	
$ukk5=mysql_query($uk5);

$uk1y4="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang5."','".$namabarang5."','1','perakitan') ";	
$ukk1y4=mysql_query($uk1y4);
	   }
}}


//Update untuk Ram Satu
if(isset($_POST['ram1'])){
$ram1=$_POST['ram1'];
$cek6=mysql_query("select * from tbarang where idbarang='".$ram1."'");
	  while($result=mysql_fetch_array($cek6)){
	  $idbarang6=$result['idbarang'];
	  $namabarang6=$result['namabarang'];
	  $stock6=$result['stock'];
	   if($stock6<>0){
	  $hasil6=$stock6-1;	  
$up6="update tpc set ram1='".$namabarang6."' where idpc='".$idpc."' ";	
$upp6=mysql_query($up6);
$uk6="update tbarang set stock='".$hasil6."' where idbarang='".$idbarang6."' ";	
$ukk6=mysql_query($uk6);

$uk1y5="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang6."','".$namabarang6."','1','perakitan') ";	
$ukk1y5=mysql_query($uk1y5);
	   }
}}

//Update untuk Ram Dua
if(isset($_POST['ram2'])){
$ram2=$_POST['ram2'];
$cek7=mysql_query("select * from tbarang where idbarang='".$ram2."'");
	  while($result=mysql_fetch_array($cek7)){
	  $idbarang7=$result['idbarang'];
	  $namabarang7=$result['namabarang'];
	  $stock7=$result['stock'];
	   if($stock7<>0){
	  $hasil7=$stock7-1;	  
$up7="update tpc set ram2='".$namabarang7."' where idpc='".$idpc."' ";	
$upp7=mysql_query($up7);
$uk7="update tbarang set stock='".$hasil7."' where idbarang='".$idbarang7."' ";	
$ukk7=mysql_query($uk7);

$uk1y6="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang7."','".$namabarang7."','1','perakitan') ";	
$ukk1y6=mysql_query($uk1y6);
	   }
}}

//Update Fan Prosesor
if(isset($_POST['fan'])){
$fan=$_POST['fan'];
$cek9=mysql_query("select * from tbarang where idbarang='".$fan."'");
	  while($result=mysql_fetch_array($cek9)){
	  $idbarang9=$result['idbarang'];
	  $namabarang9=$result['namabarang'];
	  $stock9=$result['stock'];
	   if($stock9<>0){
	  $hasil9=$stock9-1;	  
$up9="update tpc set fan='".$namabarang9."' where idpc='".$idpc."' ";	
$upp9=mysql_query($up9);
$uk9="update tbarang set stock='".$hasil9."' where idbarang='".$idbarang9."' ";	
$ukk9=mysql_query($uk9);

$uk1y8="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang9."','".$namabarang9."','1','perakitan') ";	
$ukk1y8=mysql_query($uk1y8);
	   }
}}

//Update Fan Prosesor
if(isset($_POST['dvd'])){
$dvd=$_POST['dvd'];
$cek10=mysql_query("select * from tbarang where idbarang='".$dvd."'");
	  while($result=mysql_fetch_array($cek10)){
	  $idbarang10=$result['idbarang'];
	  $namabarang10=$result['namabarang'];
	  $stock10=$result['stock'];
	   if($stock10<>0){
	  $hasil10=$stock10-1;	  
$up10="update tpc set dvd='".$namabarang10."' where idpc='".$idpc."' ";	
$upp10=mysql_query($up10);
$uk10="update tbarang set stock='".$hasil10."' where idbarang='".$idbarang10."' ";	
$ukk10=mysql_query($uk10);

$uk1y9="insert into trincipengambilan(nofaktur,idbarang,namabarang,jumlah,status) 
values ('".$nofaktur."','".$idbarang10."','".$namabarang10."','1','perakitan') ";	
$ukk1y9=mysql_query($uk1y9);
	   }
}}



//input untuk tabel pengambilan
$queryyy="insert into tpengambilan (nofaktur,tglambil,jam,nama,bagian,divisi) 
values ('".$nofaktur."','".$tglrakit."','".$jam."','IT','B034','GARMENT')";	
	$inserttt=mysql_query($queryyy);

	
	}


if($insert){
header("location:../user.php?menu=taperakitan&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=taperakitan&stt=gagal");}}
?>