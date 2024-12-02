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
	if(isset($_POST['idpcc'])){
$idpcc=$_POST['idpcc'];
$lihat=mysql_query("select * from tpc where idpc='$idpcc'");
  while($result=mysql_fetch_array($lihat)){
	  $idpc=$result['idpc'];
	 $mobopc=$result['mobo'];
	 $prosesorpc=$result['prosesor'];
$ps=$result['ps'];
$casing=$result['casing'];
$hd1pc=$result['hd1'];
$ram1pc=$result['ram1'];
$ram2pc=$result['ram2'];
$hd2pc=$result['hd2'];
$fan=$result['fan'];
$dvd=$result['dvd'];
$model=$result['model'];
$seri=$result['seri'];
	}}	  


?>
<?
	if(isset($_POST['nomor'])){
$nomor=$_POST['nomor'];
$aktif=mysql_query("select * from pcaktif where nomor='$nomor'");
  while($result2=mysql_fetch_array($aktif)){
	  $nomor=$result2['nomor'];
$user=$result2['user'];
$divisi=$result2['divisi'];
$bagian=$result2['bagian'];
$idpc=$result2['idpc'];
$namapc=$result2['namapc'];
$ippc=$result2['ippc'];
$os=$result2['os'];
$prosesor=$result2['prosesor'];
$mobo=$result2['mobo'];
$monitor=$result2['monitor'];
$ram=$result2['ram'];
$harddisk=$result2['harddisk'];
$bulan=$result2['bulan'];
$tgl_masuk=$result2['tgl_masuk'];
$ram1=$result2['ram1'];
$ram2=$result2['ram2'];
$hd1=$result2['hd1'];
$hd2=$result2['hd2'];
$powersuply=$result2['powersuply'];
$cassing=$result2['cassing'];

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
<h4 align='center'>PENGELUARAN KOMPUTER UPDATE </h4>
<div id="info_transaksi">



      <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/updaterakitupdate.php" >
Nomor
		
                                            
                                            <input  readonly class="form-control"  type="text" name="nomor" value="<? echo $nomor; ?>" >
                                         		
			Divisi                                    
          <input  readonly class="form-control"  type="text" name="divisi" value="<? echo $divisi; ?>" >
 Bagian                                      
           <input  readonly class="form-control"  type="text" name="bagian" value="<? echo $bagian; ?>" >
		   
		   Permintaan Dari                                     
        <select class="form-control" name='nomorminta' >
             <option selected="selected" ></option>
			
			<?	$sss = mysql_query("SELECT * FROM permintaan where status<>'selesai'  order by nama");
				if(mysql_num_rows($sss) > 0){
			 while($datasss = mysql_fetch_array($sss)){
				$nomor=$datasss['nomor'];
				$keterangan=$datasss['keterangan'];
				$tgllll=$datasss['tgl'];
				$t=substr($tgllll,0,4);
				$b=substr($tgllll,-5,2);
				$h=substr($tgllll,-2,2);
				$tglllll=$h.'-'.$b.'-'.$t;
				$bagian=$datasss['bagian'];
				$nama=$datasss['nama'];
				$qty=$datasss['qty'];$sisa=$datasss['sisa'];
				$namabarang=$datasss['namabarang'];
				$divisi=$datasss['divisi'];?>
			 <option value="<? echo $nomor; ?>" ><? echo $nama.'/'.$bagian.'/'.$divisi.'/'.$namabarang.'/'.$keterangan.'/'.$tglllll.'/JUM:'.$qty.'/SISA:'.$sisa ; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>	   
		User
		
                                            
                <input class="form-control"  type="text" name="user" value="<? echo $user; ?>" >
                                    
 ID Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="idpc" value="<? echo $idpc; ?>" >
                                           
Nama Komputer
		
                                            
              <input   class="form-control"  type="text" name="namapc" value="<? echo $namapc; ?>" >
                                    

                                           
   
                                   
<br>
     

    
    </div>
</div>
<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
       
	                           <div class="panel-body">
						
	
										
	
  
   							
	   <div class="form-group">
 <b>Monitor </b><font color=red>'00009'</font>          
      <select class="form-control" name='monitor' >	 <option> </option>
            
			<?	$s1 = mysql_query("SELECT * FROM tbarang where idkategori='00009'  ");
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
 <b>Keyboard </b><font color=red>'00018'</font>          
      <select class="form-control" name='keyboard' >	 <option> </option>
            
			<?	$s2 = mysql_query("SELECT * FROM tbarang where idkategori='00018' ");
				if(mysql_num_rows($s2) > 0){
			 while($datas2 = mysql_fetch_array($s2)){
				$idbarang2=$datas2['idbarang'];
				$namabarang2=$datas2['namabarang'];
				$stock2=$datas2['stock'];?>
			 <option value="<? echo $namabarang2; ?>"> <? echo $namabarang2; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
										
 <div class="form-group">
 <b>Mouse </b><font color=red>'00019'</font>          
      <select class="form-control" name='mouse' >	 <option> </option>
            
			<?	$s3 = mysql_query("SELECT * FROM tbarang where idkategori='00019'  ");
				if(mysql_num_rows($s3) > 0){
			 while($datas3 = mysql_fetch_array($s3)){
				$idbarang3=$datas3['idbarang'];
				$namabarang3=$datas3['namabarang'];
				$stock3=$datas3['stock'];?>
			 <option value="<? echo $namabarang3; ?>"> <? echo $namabarang3; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>										
<b>			 Bagian Pengambilan</b>                                      
        <select class="form-control" name='bagianambil' required='required'> <option selected="selected" ></option>
            
			<?	$s = mysql_query("SELECT * FROM bagian order by bagian asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idbagian=$datas['id_bagian'];
				$bagian=$datas['bagian'];?>
	
	<option value="<? echo $idbagian; ?>"> <? echo $bagian; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>	<br>	

            <b> Keterangan</b> 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px"  ></textarea>                                    
        <div class="form-group">
 <b>Teknisi</b>         
            <input   class="form-control"  type="text" name="teknisi"  >
                                        
                                    
                                        </div>                           		
	   <div class="form-group">
 <b>Operation System</b>         
            <input   class="form-control"  type="text" name="os" value="<? echo $os; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
             <input   class="form-control"  type="text" name="ippc" value="<? echo $ippc; ?>" >
                                        
                                    
                                        </div>

	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
     
			  <input   class="form-control"  type="text" name="harddisk" value="<? echo $harddisk; ?>" >
                                        
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
  
		   <input   class="form-control"  type="text" name="ram" value="<? echo $ram; ?>" >
                                        
                                    
                                        </div>	
										<div class="form-group">
 <b>Model</b>         
             <input  readonly class="form-control"  type="text" name="model" value="<? echo $model; ?>" >
                               
                                        
                                    
                                        </div>
		<div class="form-group">
 <b>Seri</b>         
             <input  readonly class="form-control"  type="text" name="seri" value="<? echo $seri; ?>" >
                               
                                        
                                    
                                        </div>											
											   <div class="form-group">
 <b>Bulan Perawatan</b>         
             <input  readonly class="form-control"  type="text" name="bulan" value="<? echo $bulan; ?>" >
                               
                                        
                                    
                                        </div>													
  <div class="form-group">
 <b>RAM Slot 1</b>         
         <input  readonly class="form-control"  type="text" name="ram1" value="<? echo $ram1pc; ?>" >
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>RAM Slot 2</b>         
          <input readonly class="form-control"  type="text" name="ram2" value="<? echo $ram2pc; ?>" >
                                        
                                    
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 1</b>         
        <input readonly class="form-control"  type="text" name="hd1"  value="<? echo $hd1pc; ?>" >
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>Harddisk Slot 2</b>         
         <input readonly class="form-control"  type="text" name="hd2" value="<? echo $hd2pc; ?>" >
                                        
                                    
                                        </div>										
	 <div class="form-group">
 <b>Motherboard</b>         
         <input readonly class="form-control"  type="text" name="mobo"  value="<? echo $mobopc; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Prosesor</b>         
         <input readonly class="form-control"  type="text" name="prosesor"  value="<? echo $prosesorpc; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Power Supply</b>         
          <input readonly class="form-control"  type="text" name="powersuply" value="<? echo $ps; ?>" >
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Cassing</b>         
          <input readonly class="form-control"  type="text" name="cassing" value="<? echo $casing; ?>" >
                                        
                                    
                                        </div>
										   <div class="form-group">
 <b>DVD Internal</b>         
          <input readonly class="form-control"  type="text" name="dvd" value="<? echo $dvd; ?>" >
                                        
                                    
                                        </div>
   <input readonly class="form-control"  type="hidden" name="idpcc" value="<? echo $idpcc; ?>" >
 <button  name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>
	   
	   
	   
</div>
           
</body>
</html>
