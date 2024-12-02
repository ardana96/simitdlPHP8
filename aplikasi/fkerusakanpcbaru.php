 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

</script>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="suggest2.js"></script>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(barang){
if(barang==""){
alert("Anda belum memilih  barang");}
else{   
http.open('GET','koneksi/ajax.php?barang=' + encodeURIComponent(barang) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');       
document.getElementById('asfa').value = string[2]; 
document.getElementById('www').value = string[0];                                 
}}


function sendRequest2(barang2){
if(barang2==""){
alert("Anda belum memilih  barang");}
else{   
http.open('GET','koneksi/ajax.php?barang=' + encodeURIComponent(barang2) , true);
http.onreadystatechange = handleResponse2;
http.send(null);}}

function handleResponse2(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');       
document.getElementById('asfa2').value = string[2]; 
document.getElementById('www2').value = string[0];                                 
}}


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
	if(isset($_GET['nomor'])){
$nomor=$_GET['nomor'];
$tdk=$_GET['tindakan'];
$teknisi=$_GET['teknisi'];

$lihat=mysql_query("select * from service where nomor='$nomor'");
  while($result=mysql_fetch_array($lihat)){
	  $nomorkasus=$result['nomor'];
	  $tglkasus=$result['tgl'];
	  $jamkasus=$result['jam'];
	  $nama=$result['nama'];
	  $bagian=$result['bagian'];
	  $divisi=$result['divisi'];
	  $perangkat=$result['perangkat'];
	  $kasus=$result['kasus'];
	  $ippckasus=$result['ippc'];

$sqlll = mysql_query("SELECT * FROM pcaktif where  pcaktif.ippc='$ippckasus' OR pcaktif.idpc LIKE '%".$ippckasus."%' ");
		while($dataa = mysql_fetch_array($sqlll)){
			$nomorpc=$dataa['nomor'];
			$userpc=$dataa['user'];
			$divisipc=$dataa['divisi'];
			$bagianpc=$dataa['bagian'];
			$idpc=$dataa['idpc'];
			$namapc=$dataa['namapc'];
			$ospc=$dataa['os'];
			$bulanpc=$dataa['bulan'];
			$prosesorpc=$dataa['prosesor'];
			$mobopc=$dataa['mobo'];
			$monitorpc=$dataa['monitor'];
			$rampc=$dataa['ram'];
			$harddiskpc=$dataa['harddisk'];
			$jumlahpc=$dataa['jumlah'];
			$ram1pc=$dataa['ram1'];
			$ram2pc=$dataa['ram2'];
			$hd1pc=$dataa['hd1'];
			$hd2pc=$dataa['hd2'];
			$ippcpc=$dataa['ippc'];
			$userpc=$dataa['user'];
			$powersuplypc=$dataa['powersuply'];
			$cassingpc=$dataa['cassing'];
			$tglmasukc=$dataa['tglmasuk'];
			$dvdpc=$dataa['dvd'];
			$model=$dataa['model'];
	$sbulan = mysql_query("SELECT * FROM bulan where  id_bulan='$bulanpc' ");
		while($databulan = mysql_fetch_array($sbulan)){
		$bulannama=$databulan['bulan'];
		}
			}
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
$nofakturbeli=kdauto("tpembelian",'');
$dd=mysql_query("select * from trincipengambilan where nofaktur='$no_faktur' and sesi='USR' ");
if(mysql_num_rows($dd) > 0){
$keadaan='aktif';
}
?>

<?php
$query_rinci_jual="SELECT *,sum(jumlah) as jum FROM trincipengambilan WHERE nofaktur='".$no_faktur."' group by idbarang";
$get_hitung_rinci=mysql_query($query_rinci_jual);
$hitung=mysql_num_rows($get_hitung_rinci);
$total_jual=0; $total_item=0;
while($hitung_total=mysql_fetch_array($get_hitung_rinci)){
$jml=$hitung_total['jumlah'];
$sub_total=$hitung_total['sub_total_jual'];
$total_jual=$sub_total+$total_jual;
$total_item=$jml+$total_item;}
?>


<?php
$query_rinci_beli="SELECT *,sum(jumlah) as jum FROM trincipembelian WHERE nofaktur='".$no_faktur."' group by idbarang";
$get_hitung_beli=mysql_query($query_rinci_beli);
$hitungbeli=mysql_num_rows($get_hitung_beli);
$total_beli=0; $total_beli=0;
while($hitung_beli=mysql_fetch_array($get_hitung_beli)){
$jmlbeli=$hitung_beli['jumlah'];
$sub_totalbeli=$hitung_beli['sub_total_beli'];
$total_beli=$sub_totalbeli+$total_beli;
$total_item=$jmlbeli+$total_item;}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 455px; width: 20%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#data_barang{
	background-color: white; height: 450px; width:20%;
	float: left; overflow: scroll; padding-top: 5px;}
	#data_barang2{
	background-color: white; height: 450px; width:45%;
	float: left; overflow: scroll; padding-top: 5px;}
	

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
<?if($keadaan<>'aktif'){?>
<h4 align='center'>UPDATE KERUSAKAN PC</h4>

<form action="aplikasi/simpanrincikeluarservice.php" method="post" >

<!-- DAFTAR PERMINTAAN SERVICE -->

<div id="info_transaksi">
<font color='blue'>PERMINTAAN SERVICE </font><br>
 Tanggal &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jam
	<br>	                                    
   <input   type="text" size='10' name="TglKasus" value="<? echo $tglkasus; ?>" readonly> 
   <input   type="text" size='10' name="JamKasus" value="<? echo $jamkasus; ?>" readonly><br>
     
Nama / Bagian / Divisi
<input type="text" name="namakasus" id="nama" class="form-control" value="<? echo $nama.'/'.$bagian.'/'.$divisi; ?>"  readonly  >
Permasalahan
<input type="text" name="kasuskasus" id="kasus" class="form-control" value="<? echo $kasus; ?>"  readonly  > 
IP PC
<input type="text" name="ippckasus" id="ippckasus" class="form-control" value="<? echo $ippckasus; ?>"  readonly  >     

    
    </div>
</div>

  

  
  <!-- DAFTAR PENGAMBILAN BARANG SERVICE -->
  <div style="overflow:scroll;height:450px;" id="data_barang2">
        <div class="panel-bod">
                            <div class="table-responsiv">
<font color='blue'>PENGAMBILAN BARANG SAAT SERVICE </font> 
							
							
<input class="form-control" name="nofaktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
<input class="form-control" name="nomorkasus" type="hidden" id="nomorkasus" value="<?php echo $nomorkasus; ?>" size="16" readonly="readonly" />							
							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>+</th>
										
										
                                        </tr>
										
  <tr class="tr_isi">
  <td><div id="suggestSearch">
<input name="barang" type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();"  onchange="new sendRequest(this.value)"  autocomplete="off"/>
<div  id="layer1" onclick="new sendRequest(this.value)"  class="isi_tabelll" ></div></div></td>
  <td ><label>
        <input type="text" name="idbarang" id="www" readonly />
		<input  class="form-contro" type="hidden"  id="asfa" name="kategori" readonly >
      </label>
 </td>
 <td><input  class="form-contro" type="text"  name="jumlah"  ></td>

	 <td>
										

									
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">+</button>
											</td>
  </tr>


                                    </thead>
                    
                                </table>
							
							</form>
							
							
							
							
							
							
							
							
                                <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                       
											<th>Nama Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>Hapus</th>
										
										
                                        </tr>
										  <?php
$rinci_jual=mysql_query($query_rinci_jual);
while( $data_rinci=mysql_fetch_array($rinci_jual)){
$idbarang=$data_rinci['idbarang'];
$namabarang=$data_rinci['namabarang'];
$jumlah=$data_rinci['jumlah'];
$jum=$data_rinci['jum'];
 
  ?>
  <tr class="tr_isi">
    <td><?php echo $idbarang; ?>&nbsp;</td>
    <td><?php echo $namabarang; ?>&nbsp;</td>
    <td><?php echo $jum; ?>&nbsp;</td>

	 <td><form action="aplikasi/deleterincikeluarservice.php" method="post" >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />	

<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >



									
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form></td>
  </tr>
<?php } ?>
  <tr class="header_tabel">
    <td>&nbsp;</td>

    <td>Total</td>
    <td><?php echo $total_item; ?>Items</td>

	  <td></td>
  </tr>
                                    </thead>
                    
                                </table>
                            </div>
                           
						   
						   
		<!-- DAFTAR PEMASUKAN BARANG SERVICE -->				   
						                      <div class="table-responsiv">
				<font color="blue">PEMASUKAN BARANG SAAT SERVICE </font>
							<form action="aplikasi/simpanrincimasukservice.php" method="post" >
			<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >

							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>+</th>
										
										
                                        </tr>
										
  <tr class="tr_isi">
  <td><div id="suggestSearch2">
<input name="barang2" type="text" id="dbTxt2" alt="Search Criteria" onKeyUp="searchSuggest2();"  onchange="new sendRequest2(this.value)"  autocomplete="off"/>
<div  id="layer2" onclick="new sendRequest2(this.value)"  class="isi_tabelll" ></div></div></td>
  <td ><label>
        <input type="text" name="idbarangbeli" id="www2" readonly />
		<input  class="form-contro" type="hidden"  id="asfa2" name="kategori" readonly >
      </label>
 </td>
 <td><input  class="form-contro" type="text"  name="jumlahbeli"  ></td>

	 <td>
										
<input type="hidden" name="nofakturbeli" value=<?php echo $nofakturbeli; ?> />										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">+</button>
											</td>
  </tr>


                                    </thead>
                    
                                </table>
							
							</form>
							
							
							
							
							
							
							
							
                                <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                       
											<th>Nama Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>Hapus</th>
										
										
                                        </tr>
										  <?php
$rinci_beli=mysql_query("SELECT *,sum(jumlah) as jum FROM trincipembelian WHERE nofaktur='".$nofakturbeli."' group by idbarang");
while( $data_beli=mysql_fetch_array($rinci_beli)){
$idbarangbeli=$data_beli['idbarang'];
$namabarangbeli=$data_beli['namabarang'];
$jumlahbeli=$data_beli['jumlah'];
$jumbeli=$data_beli['jum'];
$total_itembeli=$total_itembeli+$jumbeli;
 
  ?>
  <tr class="tr_isi">
    <td><?php echo $idbarangbeli; ?>&nbsp;</td>
    <td><?php echo $namabarangbeli; ?>&nbsp;</td>
    <td><?php echo $jumbeli; ?>&nbsp;</td>

	 <td><form action="aplikasi/deleterincimasukservice.php" method="post" >
				<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarangbeli; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $nofakturbeli; ?> />										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form></td>
  </tr>
<?php } ?>
  <tr class="header_tabel">
    <td>&nbsp;</td>

    <td>Total</td>
    <td><?php echo $total_itembeli; ?>Items</td>

	  <td></td>
  </tr>
                                    </thead>
                    
                                </table>
                            </div>
						   
						   
                        </div>
</div>


<!-- UPDATE TOTAL SERVICE  -->
<div style="overflow:scroll;height:450px;" id="data_barang">
       
	                           <div class="panel-body">
		<form action="aplikasi/simpantotalservice.php" method="post" >				
	
	
	<font color='blue'>PERMINTAAN PERBAIKAN</font> <br>

  Tanggal &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jam
	<br>	                                    
   <input   type="text" size='10' name="TglPerbaikan" value="<? echo date('d-m-20y'); ?>" > 
   <input   type="text" size='10' name="JamPerbaikan" value="<? echo date("H:i"); ?>" >
   <br>
Status Service / Update                                    
       <select class="form-control" name="statup" required='required'>
 <option  ></option>
 <option value="service">SERVICE</option>
 <option value="update">UPDATE</option>
</select>

Kategori                                  
       <select class="form-control" name="svc_kat" required='required'>
 <option  ></option>
 <option value="NON_SP">NON SPAREPART</option>
 <option value="SP">SPAREPART</option>
</select>		
	Permintaan Dari                                     
        <select class="form-control" name='noper' >
             <option selected="selected" ></option>
			
			<?	$sss = mysql_query("SELECT * FROM permintaan where status<>'selesai' order by nama ");
				if(mysql_num_rows($sss) > 0){
			 while($datasss = mysql_fetch_array($sss)){
				$nomor=$datasss['nomor'];
				$bagian=$datasss['bagian'];
				$nama=$datasss['nama'];
				$namabarang=$datasss['namabarang'];
				$divisi=$datasss['divisi'];?>
			 <option value="<? echo $nomor; ?>"> <? echo $nama.'    /    '.$bagian.'    /    '.$divisi.'    /    '.$namabarang; ?>
			 </option> 
			 
			 <?}}?>
			
    
        </select>
Teknisi 
<input type="text" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>" class="form-control" size="25px" placeholder="" required="required"  >
 Tindakan

  <textarea cols="45" rows="7" name="TindakanPerbaikan" class="form-control" id="tindakan" size="15px" placeholder="" required="required"><? echo $tdk; ?></textarea> 
<input class="form-control" name="nofaktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
	<input class="form-control" name="bagian" type="hidden" id="bagian" value="<?php echo $bagian; ?>" size="16" readonly="readonly" />
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >
Keterangan  
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>                              
                  
					<font color='blue'>UPDATE SPESIFIKASI KOMPUTER </font><br>
 Bagian Pengambilan Barang                                     
        <select class="form-control" name='bagianambil' required='required'>
         <option></option>   
			<?	$s = mysql_query("SELECT * FROM bagian order by bagian asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$id_bagianambil=$datas['id_bagian'];
				$bagianambil=$datas['bagian'];?>
	
	<option value="<? echo $id_bagianambil; ?>"> <? echo $bagianambil; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
								
         

   		Divisi                                    
       <select class="form-control" name="divisiup" required='required'>
 <option value=<? echo $divisipc; ?> ><? echo $divisipc; ?></option>
 <option value="AMBASADOR">AMBASADOR</option>
 <option value="EFRATA">EFRATA</option>
 <option value="GARMENT">GARMENT</option>
 <option value="MAS">MAS</option>
 <option value="TEXTILE">TEXTILE</option>
</select>											
 Bagian Pemakai                                     
        <select class="form-control" name='bagianup' required='required'>
		<option value=<? echo $bagianpc; ?> ><? echo $bagianpc; ?></option>
            
			<?	$s = mysql_query("SELECT * FROM bagian_pemakai order by bag_pemakai asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$id_bag_pemakai=$datas['id_bag_pemakai'];
				$bag_pemakai=$datas['bag_pemakai'];?>
	
	<option value="<? echo $bag_pemakai; ?>"> <? echo $bag_pemakai; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
		User
		
                                            
                                            <input  class="form-control"  type="text" name="userup" value="<? echo $userpc; ?>">
                                    
 ID Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="idpcup" value="<? echo $idpc; ?>" >
                                           
Nama Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="namapcup" value="<? echo $namapc; ?>">   
                                    
	
	   <div class="form-group">
 <b>Monitor </b>      
           <input  class="form-control"  type="text" name="monitorup" value="<? echo $monitorpc; ?>" >
                                        
                                    
                                        </div>
										<b>Model</b>                                   
       <select class="form-control" name="model" required='required'>
 <option  value="<? echo $model; ?>" ><? echo $model; ?></option>
 <option value="CPU">CPU</option>
 <option value="LAPTOP">LAPTOP</option>
</select>
	   <div class="form-group">
 <b>Operation System</b>         
        <input  class="form-control"  type="text" name="osup" value="<? echo $ospc; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input    class="form-control"  type="text" name="ippcup"  value="<? echo $ippcpc; ?>">
                                        
                                    
                                        </div>
						
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input  class="form-control"  type="text" name="harddiskup" value="<? echo $harddiskpc; ?>">
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input   class="form-control"  type="text" name="ramup" value="<? echo $rampc; ?>">
                                        
                                    
                                        </div>		

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak mengurangi Stock</font>          
      <select class="form-control" name='ram1up' >
	  <option value="<? echo $ram1pc; ?>"> <? echo $ram1pc; ?></option>
            
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
 <b>RAM Slot 2</b><font color=red>Tidak mengurangi Stock</font>          
      <select class="form-control" name='ram2up' >
	  <option value="<? echo $ram2pc; ?>" ><? echo $ram2pc; ?> </option>
            
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
 <b>Harddisk Slot 1</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='hd1up' >
	  <option value="<? echo $hd1pc; ?>"><? echo $hd1pc; ?> </option>
            
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
 <b>Harddisk Slot 2</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='hd2up' >
	  <option value="<? echo $hd2pc; ?>" ><? echo $hd2pc; ?> </option>
            
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
 <b>Motherboard </b><font color=red>Tidak mengurangi Stock</font>         
      <select class="form-control" name='moboup' >	
	  <option value="<? echo $mobopc; ?>"><? echo $mobopc; ?> </option>
            
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
 <b>Prosesor</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='prosesorup'>
	  <option value="<? echo $prosesorpc; ?>"><? echo $prosesorpc; ?> </option>
            
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
 <b>Power Supply</b><font color=red>Tidak mengurangi Stock</font>          
      <select class="form-control" name='powersuplyup'>
	  <option value="<? echo $powersuplypc; ?>"><? echo $powersuplypc; ?> </option>
            
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
 <b>Cassing</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='cassingup' >
	  <option value="<? echo $cassingpc; ?>"><? echo $cassingpc; ?> </option>
            
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
 <b>DVD Internal</b> <font color=red>Tidak mengurangi Stock</font>         
      <select class="form-control" name='dvdup' >
	  <option value="<? echo $dvdpc; ?>" ><? echo $dvdpc; ?> </option>
            
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
										 <div class="form-group">
 Bulan Perawatan         
      <input readonly class="form-control"  type="text" name="bulanup" value="<? echo $bulannama; ?>" >    
                                        
                                    
                                        </div>	
   <input  class="form-control"  type="hidden" name="nomorup" value="<? echo $nomorpc; ?>" >
   
   <input type="hidden" name="nofakturbeli" value=<?php echo $nofakturbeli; ?> />	
   
   
   
   
   
 <button  name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>

	   
</div>
  
  
  <?}else{?>


  <div class="col-lg-12">
    <ul class="pricing-table" >

	<li class="active danger col-lg-4">
	<h4>MOHON MAAF</h4>
		<h4>Silahkan tunggu sebentar </h4>
	<h4>halaman masih digunakan user</h4>
	<h4>halaman akan automatis REFRESH</h4>
	<h4>klik menu pengambilan kembali </h4>
	<h4>Setelah REFRESH</h4>
		
		
		<div class="footer">
			<font color='black'>TERIMA KASIH ATAS WAKTU YANG TELAH DIBERIKAN</font>
		</div>
	</li>

        	
</ul>

  </div>
</div>
 <br /><br />    <br />                                   
<meta http-equiv=refresh content=60;url='pemakai.php?menu=home'>
<?}?>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
           
		   