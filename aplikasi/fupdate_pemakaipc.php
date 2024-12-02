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
$lokasi=$result['lokasi'];
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
$namapc=$result['namapc'];
$powersuply=$result['powersuply'];
$cassing=$result['cassing'];
$dvd=$result['dvd'];
$model=$result['model'];
$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namabulan=$dataa['bulan'];}
	}}	  


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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 550px; width: 25%; float: left;
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
<h4 align='center'>UPDATE PERAWATAN PC</h4>
<div id="info_transaksi">



      <form id="form_penjualan"  method="post" action="aplikasi/updateperawatanpc.php" enctype="multipart/form-data" name="postform2" >
	   <div class="form-group">
Tanggal Perawatan <br>
                                            
                                          <input required='required'  type="text" id="from" name="tgl_perawatan" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                     

							
				 </div>	
								   <div class="form-group">
 Bulan Perawatan         
      <select  class="form-control" name='bulan' required='required' >	 <option value=<? echo $id_bulan; ?>><? echo $namabulan; ?> </option>
            
			<?	$s2 = mysql_query("SELECT * FROM bulan  ");
				if(mysql_num_rows($s2) > 0){
			 while($datas2 = mysql_fetch_array($s2)){
				$id_bulan=$datas2['id_bulan'];
				$bulan=$datas2['bulan'];
				?>
			 <option value="<? echo $id_bulan; ?>"> <? echo $bulan; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                               
                                        
                                    
                                        </div>	
							
 Bagian                                      
        <select class="form-control" name='bagian' required='required'> <option value=<? echo $bagian; ?> ><? echo $bagian; ?></option>
            
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
        	<option value=<? echo $subbagian; ?> ><? echo $subbagian; ?></option>
            
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
        	<option value=<? echo $lokasi; ?> ><? echo $lokasi; ?></option>
            
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
</div>
<div style="overflow:scroll;width:600px;height:550px;" id="data_barang">
       
	                           <div class="panel-body">
						
	
										

 <b> Divisi </b>                                    
   <input  readonly class="form-control"  type="text" name="divisi" value="<? echo $divisi; ?>">	
   							
	   <div class="form-group">
 <b>Monitor </b>      
           <input  readonly class="form-control"  type="text" name="monitor" value="<? echo $monitor; ?>" >
                                        
                                    
                                        </div>
											   <div class="form-group">
 <b>Model</b>      
           <input  readonly class="form-control"  type="text" name="model" value="<? echo $model; ?>" >
                                        
                                    
                                        </div>
	   <div class="form-group">
 <b>Operation System</b>         
        <input   readonly class="form-control"  type="text" name="os" value="<? echo $os; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input  readonly  class="form-control"  type="text" name="ippc"  value="<? echo $ippc; ?>">
                                        
                                    
                                        </div>
						
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input readonly class="form-control"  type="text" name="harddisk" value="<? echo $harddisk; ?>">
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input  readonly class="form-control"  type="text" name="ram" value="<? echo $ram; ?>">
                                        
                                    
                                        </div>		
  <div class="form-group">
 <b>RAM Slot 1</b>         
         <input  readonly class="form-control"  type="text" name="ram1" value="<? echo $ram1; ?>" >
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>RAM Slot 2</b>         
          <input readonly class="form-control"  type="text" name="ram2" value="<? echo $ram2; ?>" >
                                        
                                    
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 1</b>         
        <input readonly class="form-control"  type="text" name="hd1"  value="<? echo $hd1; ?>" >
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>Harddisk Slot 2</b>         
         <input readonly class="form-control"  type="text" name="hd2" value="<? echo $hd2; ?>" >
                                        
                                    
                                        </div>										
	 <div class="form-group">
 <b>Motherboard</b>         
         <input readonly class="form-control"  type="text" name="mobo"  value="<? echo $mobo; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Prosesor</b>         
         <input readonly class="form-control"  type="text" name="prosesor"  value="<? echo $prosesor; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Power Supply</b>         
          <input readonly class="form-control"  type="text" name="powersuply" value="<? echo $powersuply; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Cassing</b>         
          <input readonly class="form-control"  type="text" name="cassing" value="<? echo $cassing; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>DVD Internal</b>         
          <input readonly class="form-control"  type="text" name="dvd" value="<? echo $dvd; ?>" >
                                        
                                    
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
           