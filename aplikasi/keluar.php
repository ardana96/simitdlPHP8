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



</script>

<script language="JavaScript" type="text/JavaScript">

   function show()
   {
   if (document.form_penjualan.jenisprinter.value =="scanner")
    {
     
    document.form_penjualan.id_perangkat.style.display = "block";
	      document.form_penjualan.printer.style.display = "block";
		    document.form_penjualan.ketlokasi.style.display = "block";
			
    }
  else if (document.form_penjualan.jenisprinter.value == "printer")
    {
     
  document.form_penjualan.id_perangkat.style.display = "block";
	      document.form_penjualan.printer.style.display = "block";
		    document.form_penjualan.ketlokasi.style.display = "block";
	
    }
   else
    {
     document.form_penjualan.id_perangkat.style.display = "none";
	      document.form_penjualan.printer.style.display = "none";
		    document.form_penjualan.ketlokasi.style.display = "none";
		
    }
   }
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
$no_faktur=kdauto("tpengambilan",'');
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
<?if($keadaan<>'aktif'){?>
<h4 >PENGELUARAN BARANG </h4>


<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
        <div class="panel-bod">
                            <div class="table-responsiv">
							
							<form action="aplikasi/simpanrincikeluar.php" method="post" >
							
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
										
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />										
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

	 <td><form action="aplikasi/deleterincikeluar.php" method="post" >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />										
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
 

<div id="info_transaksi" style="overflow:scroll;height:450px;">
<button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah Bagian
                            </button>
							
<!--							
  <div id="scanner">Barcode: 
      <input  type="text" name="kd_barang" id="kd_barang" onkeypress="onEnter(event)" />
  </div>-->


 

      <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/simpankeluar.php" >
       
        <input class="form-control" name="no_faktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
		<input class="form-control" name="id_user" type="hidden" id="id_user" value="<?php echo $id_user; ?>" size="16" readonly="readonly" />
     


		
                                           Tanggal 
                                            <input  class="form-control" value="<?php echo $date; ?>" type="text" name="tglambil" >
		
		
                                            
                                            <input  class="form-control" value="<?php echo $jam; ?>" type="hidden" name="jam" readonly >											

		Nama
		
                                            
                                            <input  class="form-control"  type="text" name="nama" >
                                    
 
                                           
    Bagian                                      
        <select class="form-control" name='bagian' required='required'>
             <option selected="selected" ></option>
			<?	$s = mysql_query("SELECT * FROM bagian order by bagian asc");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idbagian=$datas['id_bagian'];
				$bagian=$datas['bagian'];?>
			 <option value="<? echo $idbagian; ?>"> <? echo $bagian; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
                                    

                                           
    Divisi                                    
       <select class="form-control" name="divisi" required='required'>
 <option selected="selected" ></option>
 <option value="AMBASADOR">AMBASADOR</option>
 <option value="EFRATA">EFRATA</option>
 <option value="GARMENT">GARMENT</option>
 <option value="MAS">MAS</option>
 <option value="TEXTILE">TEXTILE</option>
 <option value="KAS">PT. KAS</option>
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
			 <option value="<? echo $nomor; ?>" ><? echo $nama.'/'.$bagian.'/'.$divisi.'/'.$namabarang.'/'.$keterangan.'/'.$tglllll.'/JUMLAH:'.$qty; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
		
		Jenis Printer / Scanner   
        <select class="form-control" name="jenisprinter" id='jenisprinter'  onChange='show()' >
 <option selected="selected" ></option>
 <option value="printer">PRINTER</option>
 <option value="scanner">SCANNER</option>

</select>
   
 <input   placeholder="ID Perangkat" class="form-control"  type="text" name="id_perangkat" id="id_perangkat" style="display:none;"  >
  <input   placeholder="Nama Perangkat" class="form-control"  type="text" name="printer" id="printer" style="display:none;"  >
    <input   placeholder="Lokasi Printer" class="form-control"  type="text" name="ketlokasi" id="ketlokasi" style="display:none;" >
Keterangan Pengeluaran
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder=""></textarea>                                    
                   
<br>
     
     <?	$sss = mysql_query("SELECT * FROM trincipengambilan where nofaktur='$no_faktur'");
				if(mysql_num_rows($sss) > 0){?>
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	
 <button  name="button_selesai" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
				<?}?>
	</form>
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



		   	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Bagian </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbagiankeluar.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
										
	
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="id_bagian" value="<? echo kdauto("bagian","B"); ?>" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Nama Bagian" class="form-control" type="text" name="bagian"  >
                                    
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
