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
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>
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

function permintaan(isi){
if(isi==""){
document.getElementById('tglup').value="";
document.getElementById('tglup2').value="";
document.getElementById('tglup3').value="";
document.getElementById('tglup4').value="";
document.getElementById('tglup5').value="";
document.getElementById('tglup6').value="";
document.getElementById('tglup7').value="";
document.getElementById('tglup8').value="";
document.getElementById('tglup9').value="";
document.getElementById('tglup10').value="";
document.getElementById('tglup11').value="";
document.getElementById('tglup12').value="";
document.getElementById('tglup13').value="";
document.getElementById('tglup14').value="";
document.getElementById('tglup15').value="";}
else{
document.getElementById('tglup').value=(isi);
document.getElementById('tglup2').value=(isi);
document.getElementById('tglup3').value=(isi);
document.getElementById('tglup4').value=(isi);
document.getElementById('tglup5').value=(isi);
document.getElementById('tglup6').value=(isi);
document.getElementById('tglup7').value=(isi);
document.getElementById('tglup8').value=(isi);
document.getElementById('tglup9').value=(isi);
document.getElementById('tglup10').value=(isi);
document.getElementById('tglup11').value=(isi);
document.getElementById('tglup12').value=(isi);
document.getElementById('tglup13').value=(isi);
document.getElementById('tglup14').value=(isi);
document.getElementById('tglup15').value=(isi);
}}

 function permintaan2(isi2){
if(isi2==""){
document.getElementById('supup').value="";
document.getElementById('supup2').value="";
document.getElementById('supup3').value="";
document.getElementById('supup4').value="";
document.getElementById('supup5').value="";
document.getElementById('supup6').value="";
document.getElementById('supup7').value="";
document.getElementById('supup8').value="";
document.getElementById('supup9').value="";
document.getElementById('supup10').value="";
document.getElementById('supup11').value="";
document.getElementById('supup12').value="";
document.getElementById('supup13').value="";
document.getElementById('supup14').value="";
document.getElementById('supup15').value="";}
else{
document.getElementById('supup').value=(isi2);
document.getElementById('supup2').value=(isi2);
document.getElementById('supup3').value=(isi2);
document.getElementById('supup4').value=(isi2);
document.getElementById('supup5').value=(isi2);
document.getElementById('supup6').value=(isi2);
document.getElementById('supup7').value=(isi2);
document.getElementById('supup8').value=(isi2);
document.getElementById('supup9').value=(isi2);
document.getElementById('supup10').value=(isi2);
document.getElementById('supup11').value=(isi2);
document.getElementById('supup12').value=(isi2);
document.getElementById('supup13').value=(isi2);
document.getElementById('supup14').value=(isi2);
document.getElementById('supup15').value=(isi2);
}}


 function permintaan3(isi3){
if(isi3==""){
document.getElementById('ketup').value="";
document.getElementById('ketup2').value="";
document.getElementById('ketup3').value="";
document.getElementById('ketup4').value="";
document.getElementById('ketup5').value="";
document.getElementById('ketup6').value="";
document.getElementById('ketup7').value="";
document.getElementById('ketup8').value="";
document.getElementById('ketup9').value="";
document.getElementById('ketup10').value="";
document.getElementById('ketup11').value="";
document.getElementById('ketup12').value="";
document.getElementById('ketup13').value="";
document.getElementById('ketup14').value="";
document.getElementById('ketup15').value="";}
else{
document.getElementById('ketup').value=(isi3);
document.getElementById('ketup2').value=(isi3);
document.getElementById('ketup3').value=(isi3);
document.getElementById('ketup4').value=(isi3);
document.getElementById('ketup5').value=(isi3);
document.getElementById('ketup6').value=(isi3);
document.getElementById('ketup7').value=(isi3);
document.getElementById('ketup8').value=(isi3);
document.getElementById('ketup9').value=(isi3);
document.getElementById('ketup10').value=(isi3);
document.getElementById('ketup11').value=(isi3);
document.getElementById('ketup12').value=(isi3);
document.getElementById('ketup13').value=(isi3);
document.getElementById('ketup14').value=(isi3);
document.getElementById('ketup15').value=(isi3);
}}

 function noper(noper){
if(noper==""){
document.getElementById('noper').value="";
}
else{
document.getElementById('noper').value=(noper);
}}

</script>
<?
$datee=date('20y-m-d');
 $jam = date("H:i");
$date=date('d-m-20y');
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
$no_faktur=kdauto("tpembelian",'');
	
	
	if(isset($_POST['nofaktur'])){
$no_faktur=$_POST['nofaktur'];
$lihatpembelian=mysql_query("select * from tpembelian where nofaktur='$no_faktur'");
  while($hpembelian=mysql_fetch_array($lihatpembelian)){
	  $no_faktur=$hpembelian['nofaktur'];
$idsupp=$hpembelian['idsupp'];
$tglawal=$hpembelian['tglbeli'];
$tahunawal=substr($tglawal,0,4);
$bulanawal=substr($tglawal,-5,2);
$tanggalawal=substr($tglawal,-2,2);
$tglbeli=$tanggalawal.'-'.$bulanawal.'-'.$tahunawal;
	$keterangan=$hpembelian['keterangan'];
	
$sss = mysql_query("SELECT * FROM tsupplier where idsupp='$idsupp'");
			 while($datasss = mysql_fetch_array($sss)){
$idsupp=$datasss['idsupp'];
$namasupp=$datasss['namasupp'];
	}}
	
	$kk = mysql_query("SELECT * FROM rincipermintaan where nofaktur='$no_faktur'");
			 while($datakk = mysql_fetch_array($kk)){
$noper=$datakk['nomor'];
	}	
	
	$kkk = mysql_query("SELECT * FROM permintaan where nomor='$noper'");
			 while($datakkk = mysql_fetch_array($kkk)){
$nmpeminta=$datakkk['nama'];
	}
	
	}
	
	if(isset($_GET['tglbeli'])){
$tglbeli=$_GET['tglbeli'];
$namasupp=$_GET['namasupp'];
$keterangan=$_GET['keterangan'];
	}

?>

<?php
$query_rinci_jual="SELECT *,sum(jumlah) as jum FROM trincipembelian WHERE nofaktur='".$no_faktur."' group by idbarang";
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
document.location.href="aplikasi/simpanrincipemasukan.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
<h4 >PEMASUKAN BARANG </h4>


<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
        <div class="panel-bod">
                            <div class="table-responsiv">
							
							<form action="aplikasi/simpanrincireturmasuk.php" method="post" >
							
							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>Tambah</th>
										
										
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
										
<input type="hidden" name="nofaktur" value=<?php echo $no_faktur; ?> />		
<input  class="form-control"  type="hidden" id="tglup"  name="tglbeli" value="<?php echo $tglbeli; ?>"   >	  
 <input  class="form-control"  type="hidden" id="supup"  name="namasupp"  value="<?php echo $namasupp; ?>" >	 
 <input  class="form-control"  type="hidden" id="ketup"  name="keterangan" value="<?php echo $keterangan; ?>"  >
 
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

	 <td><form action="aplikasi/deleterincireturmasuk.php" method="post" >
		  <input  class="form-control"  type="hidden" id="tglup<?php echo $angka++; ?>"  name="tglbeli" value="<?php echo $tglbeli; ?>"   >	  
 <input  class="form-control"  type="hidden" id="supup<?php echo $angka2++; ?>"  name="namasupp"  value="<?php echo $namasupp; ?>" >	 
 <input  class="form-control"  type="hidden" id="ketup<?php echo $angka3++; ?>"  name="keterangan" value="<?php echo $keterangan; ?>"  >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />	
<input type="hidden" name="noper" id="noper" value="<? echo $noper;?>"   />										
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
                           
                        </div>
</div>

<div id="info_transaksi">

<!--							
  <div id="scanner">Barcode: 
      <input  type="text" name="kd_barang" id="kd_barang" onkeypress="onEnter(event)" />
  </div>
-->

 

      <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/updatereturmasuk.php" >

        <input class="form-control" name="no_faktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
		<input class="form-control" name="id_user" type="hidden" id="id_user" value="<?php echo $id_user; ?>" size="16" readonly="readonly" />
     

		
		
                              Tanggal
                                            <input  class="form-control" value="<?php echo $tglbeli; ?>" type="text" name="tglbeli" onchange="new permintaan(this.value)" >
	
		
                                            
                                            <input  class="form-control" value="<?php echo $jam; ?>" type="hidden" name="jam" readonly >											

	
                                    
 
                                       
    Nama Supplier                                    
        <select class="form-control" name='idsupp' required='required' onchange="new permintaan2(this.value)">
             <option selected="selected" value="<? echo $idsupp; ?>"><? echo $namasupp; ?></option>
			<?	$s = mysql_query("SELECT * FROM tsupplier ");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idsupp=$datas['idsupp'];
				$namasupp=$datas['namasupp'];?>
			 <option value="<? echo $idsupp; ?>"> <? echo $namasupp; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
		
               Permintaan Dari                                     
         <select class="form-control" name='nomor' >
             <option selected="selected" ></option>
			
			<?	$sss = mysql_query("SELECT * FROM permintaan where status<>'selesai' and aktif<>'nonaktif' order by nama");
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
             Keterangan Pembelian
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder="" onchange="new permintaan3(this.value)"><? echo $keterangan;?></textarea>                                    
                                

                                   
<br>
     
    <?	$sss = mysql_query("SELECT * FROM trincipembelian where nofaktur='$no_faktur'");
				if(mysql_num_rows($sss) > 0){?>
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	
 <button  name="button_selesai" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
				<?}?>
	  </form>
    </div> 
</body>
</html>



	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbarangmasuk.php" method="post"  enctype="multipart/form-data" name="postform2">
                                       <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" value="<? echo kdauto("tbarang",""); ?>" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         Barcode Barang
                                            <input class="form-control" type="text" name="barcode" placeholder="Barcode Barang"  >
                                    
                                        </div>
											
<div class="form-group">
                                           
Kategori                                         
        <select class="form-control" name='idkategori' required="required">
             <option ></option>
			<?	$s = mysql_query("SELECT * FROM tkategori ");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idkategori=$datas['idkategori'];
				$kategori=$datas['kategori'];?>
			 <option value="<? echo $idkategori; ?>"> <? echo $kategori; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
                                    
                                        </div>	
	
<div class="form-group">
         Nama Barang                                   
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="namabarang" >
                                    
                                        </div>	
										<div class="form-group">
    Inventaris ( Barang bisa dipinjam )
                                         
        <select class="form-control" name='inventory' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	

																				<div class="form-group">
    Refil
                                         
        <select class="form-control" name='refil' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	
                                    Keterangan / Spesifikasi 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder="" ></textarea>                                    
                    
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					  <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Supplier</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpansuppliermasuk.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idsupp" value="<? echo kdauto("tsupplier",""); ?>" readonly>
                                    
                                        </div>
									  <div class="form-group">
                                           Nama Supplier
                                            <input placeholder="Nama Supplier" class="form-control" type="text" name="namasupp"  >
                                    
                                        </div>	
	
<div class="form-group">
Alamat Supplier                                            
                                            <input  placeholder="Alamat" class="form-control" type="text" name="alamatsupp" >
                                    
                                        </div>	
<div class="form-group">
                Telp Supplier                         
                                            <input  placeholder="Telp" class="form-control" type="text" name="telpsupp" >
                                    
                                        </div>	
                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>