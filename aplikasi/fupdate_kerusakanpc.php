 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

</script>
<?php
$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="sitdl";
$koneksi=mysql_connect($server_database,$user_database,$password_database);
if(!$koneksi){
die("Tidak bisa terhubung ke server".mysql_error());}
$pilih_database=mysql_select_db($nama_database,$koneksi);
if(!$pilih_database){
die("Database tidak bisa digunakan".mysql_error());}
?>
<?

if(isset($_POST['nomor'])){
$nomor=$_POST['nomor'];
$lihat=mysql_query("select * from pcaktif where nomor='$nomor'");
  while($result=mysql_fetch_array($lihat)){
$nomor=$result['nomor'];
$user=$result['user'];
$divisi=$result['divisi'];
$bagian=$result['bagian'];
$subbagian=$result['subbagian'];
$lokasi = $result['lokasi'];
$id_bulan=$result['id_bulan'];
$id_bagian=$result['id_bagian'];
$idpc=$result['idpc'];
$ippc=$result['ippc'];
$os=$result['os'];
$prosesor=$result['prosesor'];
$mobo=$result['mobo'];
$monitor=$result['monitor'];
$ram=$result['ram'];
$harddisk=$result['harddisk'];
$jumlah=$result['jumlah'];
$tgl_update=$result['tgl_update'];
$bulan=$result['bulan'];
$tgl_masuk=$result['tgl_masuk'];
$ram1=$result['ram1'];
$ram2=$result['ram2'];
$hd1=$result['hd1'];
$hd2=$result['hd2'];
$model=$result['model'];
$namapc=$result['namapc'];
$powersuply=$result['powersuply'];
$cassing=$result['cassing'];
$dvd=$result['dvd'];
$model=$result['model'];
$seri=$result['seri'];
$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namabulan=$dataa['bulan'];}
	}}	  
$tgll=substr($tgl_update,-10,2);
$blnn=substr($tgl_update,-7,2);
$thnn=substr($tgl_update,-4,4);
$tglupdate=$thnn.'-'.$blnn.'-'.$tgll;

?>


<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>

<?
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
$no_faktur=kdauto("tpengambilan",'');
?>

<?php
$query_rinci_jual="SELECT * FROM trincipengambilan WHERE nofaktur='".$no_faktur."'";
$get_hitung_rinci=mysql_query($query_rinci_jual);
$hitung=mysql_num_rows($get_hitung_rinci);
$total_jual=0; $total_item=0;
while($hitung_total=mysql_fetch_array($get_hitung_rinci)){
$jml=$hitung_total['jumlah'];
$sub_total=$hitung_total['sub_total_jual'];
$total_jual=$sub_total+$total_jual;
$total_item=$jml+$total_item;}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 455px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_service{
	height: 455px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_user{
	background-color: #CCC;
	height: 450px; width: 20%; float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt; color: #000;
	font-weight: bold; padding-top: 5px;}

#kalkulator{
	height: 90px; width: 100%; border-bottom-width: 2px;
	border-bottom-color:#933; border-bottom-style:solid;
	padding-left: 10px; padding-top: 10px;}
#scanner{
	height:50px; width: 100%;
	border-bottom-width: 2px; border-bottom-color: #933;
	border-bottom-style: solid;
	padding-top: 10px; padding-left: 10px;}
#button_transaksi{
	height:45px; width: 100%;
	padding-top: 5px; padding-left: 10px;}
#data_barang{
	background-color: white; height: 450px; width:50%;
	float: left; overflow: scroll; padding-top: 5px;}
.td_total{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #03F;
	text-decoration: none;}
.td_cash{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #FF0;
	text-decoration: none;}
.td_kembali{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold;
	color: #F00; text-decoration: none;}
.tr_header_footer{
	background-color: #09F;
	font-size: 14px; color: #FFF; font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;}
.tr_isi{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; color: #000;
	background-color: #FFF;}
</style>

<script language="javascript">
function onEnter(e){
var key=e.keyCode || e.which;
var kd_barang=document.getElementById('kd_barang').value;
var no_faktur=document.getElementById('no_faktur').value;
if(key==13){
document.location.href="aplikasi/simpanrincipengeluaran.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
	<h4 align='center'>UPDATE SPESIFIKASI PC</h4>
	<div id="info_transaksi">
    	<form id="form_penjualan"  method="post" action="aplikasi/updatekerusakanpc.php" enctype="multipart/form-data" name="postform2" >
		
		<div class="form-group">
			Tanggal Service <br>
			<input required='required' value=<? echo $tglupdate; ?> type="text" id="from" name="tgl_update" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  		<img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
        </div>		
		
		Divisi                                    
        <select class="form-control" name="divisi" required='required'>
			 <option value=<? echo $divisi; ?> ><? echo $divisi; ?></option>
			 <option value="AMBASADOR">AMBASADOR</option>
			 <option value="EFRATA">EFRATA</option>
			 <option value="GARMENT">GARMENT</option>
			 <option value="MAS">MAS</option>
			 <option value="TEXTILE">TEXTILE</option>
		</select>											
 		Bagian                                      
        <select class="form-control" name='bagian' required='required'> 
        	<option value=<? echo $bagian; ?> ><? echo $bagian; ?></option>
            
			<?	$s = mysql_query("SELECT * FROM bagian_pemakai order by bag_pemakai asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$id_bag_pemakai=$datas['id_bag_pemakai'];
				$bag_pemakai=$datas['bag_pemakai'];?>
	
			<option value="<? echo $bag_pemakai; ?>"> <? echo $bag_pemakai; ?>
			 </option>
			 
			 <?}}?>
        </select>

        Sub Bagian                                      
        <select class="form-control" name='subbagian' required='required'> 
        	<option value="<? echo $subbagian; ?>" ><? echo $subbagian; ?></option>
            
			<?	$s = mysql_query("SELECT * FROM sub_bagian order by subbag_nama asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$subbag_id=$datas['subbag_id'];
				$subbag_nama=$datas['subbag_nama'];?>
	
			<option value="<? echo $subbag_nama; ?>"> <? echo $subbag_nama; ?>
			 </option>
			 
			 <?}}?>
        </select>

       Lokasi                                      
        <select class="form-control" name='lokasi' required='required'> 
        	<option value="<? echo $lokasi; ?>" ><? echo $lokasi; ?></option>
            
			<?	$s = mysql_query("SELECT * FROM lokasi order by lokasi_nama asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$lokasi_id=$datas['lokasi_id'];
				$lokasi_nama=$datas['lokasi_nama'];?>
	
			<option value="<? echo $lokasi_nama; ?>"> <? echo $lokasi_nama; ?>
			 </option>
			 
			 <?}}?>
        </select>

		User
		<input  class="form-control"  type="text" name="user" value="<? echo $user; ?>">                         
 		ID Komputer
		<input  class="form-control"  type="text" name="idpc" value="<? echo $idpc; ?>" >                                  
		Nama Komputer
		<input  class="form-control"  type="text" name="namapc" value="<? echo $namapc; ?>">   
        <br>
    </div>

	<div style="overflow:scroll;width:600px;height:1200px;" id="data_barang">
       
	                           <div class="panel-body">
						
	
										

   							

	   <div class="form-group">
 <b>Operation System</b>         
        <input  class="form-control"  type="text" name="os" value="<? echo $os; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input    class="form-control"  type="text" name="ippc"  value="<? echo $ippc; ?>">
                                        
                                    
                                        </div>
						
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input  class="form-control"  type="text" name="harddisk" value="<? echo $harddisk; ?>">
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input   class="form-control"  type="text" name="ram" value="<? echo $ram; ?>">
                                        
                                    
                                        </div>		
<!--Titit Mulai untuk Case -->
<? if($model=="CPU"){?>
<div class="form-group">
 <b>Monitor</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
      <select class="form-control" name='monitor' >
	  <option value="<? echo $monitor; ?>"> <? echo $monitor; ?></option>
            
			<?	$smonitor = mysql_query("SELECT * FROM tbarang where idkategori='00009' ");
				if(mysql_num_rows($smonitor) > 0){
			 while($datamonitor = mysql_fetch_array($smonitor)){
				$idbarangmonitor=$datamonitor['idbarang'];
				$namabarangmonitor=$datamonitor['namabarang'];?>
			 <option value="<? echo $namabarangmonitor; ?>"> <? echo $namabarangmonitor; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
											
<b>Model</b>                                    
       <select class="form-control" name="model" required='required'>
 <option value=<? echo $model; ?> ><? echo $model; ?></option>
 <option value="cpu">CPU</option>
 <option value="laptop">LAPTOP</option>
</select>

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram1' >
	  <option value="<? echo $ram1; ?>"> <? echo $ram1; ?></option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

		  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram2' >
	  <option value="<? echo $ram2; ?>" ><? echo $ram2; ?> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd1' >
	  <option value="<? echo $hd1; ?>"><? echo $hd1; ?> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' ");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $namabarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd2' >
	  <option value="<? echo $hd2; ?>" ><? echo $hd2; ?> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' ");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $namabarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>										
	
	   <div class="form-group">
 <b>Motherboard </b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='mobo' >	
	  <option value="<? echo $mobo; ?>"><? echo $mobo; ?> </option>
            
			<?	$s1 = mysql_query("SELECT * FROM tbarang where idkategori='00001'  ");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$idbarang=$datas1['idbarang'];
				$namabarang=$datas1['namabarang'];
				$stock=$datas1['stock'];?>
			 <option value="<? echo $namabarang; ?>"> <? echo $namabarang; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

 <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='prosesor'>
	  <option value="<? echo $prosesor; ?>"><? echo $prosesor; ?> </option>
            
			<?	$s2 = mysql_query("SELECT * FROM tbarang where idkategori='00002' ");
				if(mysql_num_rows($s2) > 0){
			 while($datas2 = mysql_fetch_array($s2)){
				$idbarang2=$datas2['idbarang'];
				$namabarang2=$datas2['namabarang'];?>
			 <option value="<? echo $namabarang2; ?>"> <? echo $namabarang2; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
 
   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='powersuply'>
	  <option value="<? echo $powersuply; ?>"><? echo $powersuply; ?> </option>
            
			<?	$s3 = mysql_query("SELECT * FROM tbarang where idkategori='00003' ");
				if(mysql_num_rows($s3) > 0){
			 while($datas3 = mysql_fetch_array($s3)){
				$idbarang3=$datas3['idbarang'];
				$namabarang3=$datas3['namabarang'];?>
			 <option value="<? echo $namabarang3; ?>"> <? echo $namabarang3; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='cassing' >
	  <option value="<? echo $cassing; ?>"><? echo $cassing; ?> </option>
            
			<?	$s4 = mysql_query("SELECT * FROM tbarang where idkategori='00004'  ");
				if(mysql_num_rows($s4) > 0){
			 while($datas4 = mysql_fetch_array($s4)){
				$idbarang4=$datas4['idbarang'];
				$namabarang4=$datas4['namabarang'];?>
			 <option value="<? echo $namabarang4; ?>"> <? echo $namabarang4; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>

	<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='dvd' >
	  <option value="<? echo $dvd; ?>" ><? echo $dvd; ?> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00008' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
<?}else{?>


<div class="form-group">
 <b>Seri</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
         <input  class="form-control"  type="text" name="seri" value="<? echo $seri; ?>">
                                        
                                    
                                        </div>




<div class="form-group">
 <b>Monitor</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
         <input  class="form-control"  type="text" name="monitor" value="<? echo $monitor; ?>">
                                        
                                    
                                        </div>
											
<b>Model</b>                                    
       <select class="form-control" name="model" required='required'>
 <option value=<? echo $model; ?> ><? echo $model; ?></option>
 <option value="cpu">CPU</option>
 <option value="laptop">LAPTOP</option>
</select>

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
        <input  class="form-control"  type="text" name="ram1" value="<? echo $ram1; ?>">
                                        
                                    
                                        </div>

		  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
         <input  class="form-control"  type="text" name="ram2" value="<? echo $ram2; ?>">
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="hd1" value="<? echo $hd1; ?>">
                                        
                                    
                                        </div>

  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
        <input  class="form-control"  type="text" name="hd2" value="<? echo $hd2; ?>">
                                        
                                    
                                        </div>										
	
	   <div class="form-group">
 <b>Motherboard </b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
       <input  class="form-control"  type="text" name="mobo" value="<? echo $mobo; ?>">
                                        
                                    
                                        </div>

 <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="prosesor" value="<? echo $prosesor; ?>">
                                        
                                    
                                        </div>
 
   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
        <input  class="form-control"  type="text" name="powersuply" value="<? echo $powersuply; ?>">
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="cassing" value="<? echo $cassing; ?>">
                                        
                                    
                                        </div>

	<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
         <input  class="form-control"  type="text" name="dvd" value="<? echo $dvd; ?>"> 
                                        
                                    
                                        </div>
										
<? }?>
<!-- Titik Akhir untuk Case -->
<!--										 <div class="form-group">
 Bulan Perawatan         
      <input readonly class="form-control"  type="text" name="bulan" value="<? echo $namabulan; ?>" >    


                                        
                                    
                                        </div> -->
	<div  class="form-group">
		Bulan Perawatan                                      
        <select class="form-control" name='bulan' required='required'> 
        	<option value=<? echo $bulan; ?> ><? echo $namabulan; ?></option>
            
			<?	$s = mysql_query("SELECT * FROM bulan order by id_bulan asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$id_bulan=$datas['id_bulan'];
				$bulan=$datas['bulan'];?>
	
			<option value="<? echo $id_bulan; ?>"> <? echo $bulan; ?>
			 </option>
			 
			 <?}}?>
        </select>
	
	
	</div>
	
										
   <input  class="form-control"  type="hidden" name="nomor" value="<? echo $nomor; ?>" >
 <button  name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>

	   
</div>
  


  
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
           
		    