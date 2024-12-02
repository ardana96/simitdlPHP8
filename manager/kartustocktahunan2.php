<?php
session_start();
include('../config.php');
if(isset($_POST['tombol'])){
	
$tanggalanyar=$_POST['tglbro'];
}
?>

<head>
     <meta charset="UTF-8" />
    <title>Inventory IT</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
	<script src="../js/pop_up.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="../assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- END PAGE LEVEL  STYLES -->
       <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<script language="JavaScript" type="text/javascript" src="../suggestkartu3.js"></script>

<style>
#pilih_laporan {
	background-color: #666; height: 30px; width: 100%;
	font-weight: bold; color: #FFF;
	text-transform: capitalize;}
#tampil_laporan{
	height: auto;width: 100%; overflow: auto;
	text-transform: capitalize;}
.judul_laporan{
	font-size: 14pt; font-weight: bold;
	color: #000; text-align: center;}
.header_footer{
	background-color: #999;
	text-align: center; font-weight: bold;}
.isi_laporan{
	font-size: 10pt; color: #000;
	background-color: #FFF;}
.resume_laporan{
	background-color: #333;
	font-weight: bold; color: #FFF;}
@media print {  
#pilih_laporan{display: none;} } 
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
http.open('GET','../koneksi/ajax.php?barang=' + encodeURIComponent(barang) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');       
document.getElementById('asfa').value = string[2]; 
document.getElementById('www').value = string[0];                                 
}}


var mywin; 
function popup(tanggal){
	if(tanggal==""){
alert("Anda belum memilih tanggal");}
else{   
mywin=window.open("lap_pembeliandetail.php?tanggal=" + tanggal ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}

function popup2(tanggal){
	if(tanggal==""){
alert("Anda belum memilih tanggal");}
else{   
mywin=window.open("lap_pengambilandetail.php?tanggal=" + tanggal ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}

</script>
<?php
if(isset($_POST['button_filter'])){
$tgl_awal=$_POST['tgl_awal'];
$kd_barang=$_POST['kd_barang'];
$bln_awal=$_POST['bln_awal'];
$thn_awal=$_POST['thn_awal'];
$tanggal_awal=$thn_awal.$bln_awal.$tgl_awal;
$tanggal_awal_format=$tgl_awal."-".$bln_awal."-".$thn_awal;
$tgl_akhir=$_POST['tgl_akhir'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;
$tanggal=true;
$tanggaal=$thn_akhir.'-'.$bln_akhir.'-'.$tgll;
//$kd_toko=$_POST['kd_toko'];
$kb= mysql_query("SELECT namabarang FROM tbarang  where idbarang='$kd_barang' ");
				while($datakb = mysql_fetch_array($kb)){
				$namabarangcuy=$datakb['namabarang'];}
}
else{
$tanggal=false;
$bln_akhir=date('m');
$thn_akhir=date('20y');
//$kd_toko=$_SESSION['kd_toko'];
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan"><table width="95%" border="0" align="center">
  <tr>

   <td><form id="form_filter" name="form_filter" method="post" action="<?php $_SERVER['PHP_SELF']; ?>"><div id="suggestSearch"><font color='white'>   Nama Barang :</font>
<input name="barang" value="<?echo $namabarangcuy;?>" type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();"  onchange="new sendRequest(this.value)"  autocomplete="off"/>
<div  id="layer1" onclick="new sendRequest(this.value)"  class="isi_tabelll" ></div></div>
  <input type="hidden"  value="<?echo $kd_barang;?>" name="kd_barang" id="www" readonly />
		<input  class="form-contro" type="hidden"  id="asfa" name="kategori" ></td>
<td><font color='white'>   Bulan / Tahun  :</font>
    <select name="bln_akhir" size="1" id="bln_akhir">
<option value="<?echo $bln_akhir;?>" checked><?echo $bln_akhir;?></option>
<?php
for($i=1;$i<=12;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>    
    </select>
    <select name="thn_akhir" size="1" id="thn_akhir">
	<option value="<?echo $thn_akhir;?>"><?echo $thn_akhir;?></option>
<?php

for($i=2013;$i<=date('Y');$i++){
if($i<10){ $i="0".$i; }

echo"<option value=".$i.">".$i."</option>";}
?>    
    </select>
   
    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
</td>
	</form>


	
  </tr>
</table>
</div>
<div id="tampil_laporan"><table width="95%" border="1" align="center">
  <tr>
    <td colspan="8" align="center" class="judul_laporan"><p>KARTU PERSEDIAN BARANG</p>
	  <?$bb = mysql_query("SELECT * FROM bulan where id_bulan='$bln_akhir'");
	if(mysql_num_rows($bb) > 0){
	while($databb = mysql_fetch_array($bb)){
	$namabulan=$databb['bulan'];}}
		?>
      <p>Bulan : <?php if($tanggal==true){echo $namabulan.'-'.$thn_akhir; } ?></p></td>
    </tr>
<tr>
  <?$aa = mysql_query("SELECT * FROM tbarang where idbarang='$kd_barang'");
	if(mysql_num_rows($aa) > 0){
	while($dataaa = mysql_fetch_array($aa)){
	$namabarang=$dataaa['namabarang'];}}
		?>
    <td colspan=8 >Nama Barang : <?php echo $namabarang; ?></td>
   

 
  
  </tr>

  <tr>
    <td colspan=8>Kode Barang : <?php echo $kd_barang; ?></td>

		  

  </tr>
  <tr class="header_footer">
    <td width=20%>Tanggal</td>

    <td width=20%>Awal</td>
	<td width=20%>Masuk</td>
	<td >&nbsp </td>
	<td width=20%>Keluar</td>
	<td >&nbsp </td>
	<td width=10%>Sisa</td>
	

  </tr>
<?php
$tanggall=$thn_akhir.'-'.$bln_akhir.'-01';
$tanggalll=$thn_akhir.'-01-01';
$sq=mysql_query("select stockawal from tbarang where idbarang='".$kd_barang."'  ");
$dat=mysql_fetch_array($sq);
$stockawal=$dat['stockawal'];

$a=mysql_query("select sum(jumlah)as jumta from tpembelian,trincipembelian where tpembelian.nofaktur=trincipembelian.nofaktur
and  idbarang='".$kd_barang."'  and DATE_FORMAT(tpembelian.tglbeli,'%Y-%m-%d')<='".$tanggaal."'");
while($dataa = mysql_fetch_array($a)){
$jumm=$dataa['jumta'];
}

$b=mysql_query("select sum(jumlah)as jumta from tpengambilan,trincipengambilan where tpengambilan.nofaktur=trincipengambilan.nofaktur
and  idbarang='".$kd_barang."'  and DATE_FORMAT(tpengambilan.tglambil,'%Y-%m-%d')<='".$tanggaal."'");
while($datab = mysql_fetch_array($b)){
$jummb=$datab['jumta'];
}

$stockk=$stockawal+$jumm-$jummb;





//mengeluarkan tanggal 
$sl=mysql_query("select * from ttgl order by tglll asc ");
while($datarinci = mysql_fetch_array($sl)){
$tgll=$datarinci['tglll'];

$tanggal=$thn_akhir.'-'.$bln_akhir.'-'.$tgll;

//mengeluarkan data pemebelian berdasarkan tanggal
$jumtambah=0;
$sqlll=mysql_query("select * from tpembelian where tglbeli='".$tanggal."' ");
if(mysql_num_rows($sqlll) > 0){
while($datarinciii = mysql_fetch_array($sqlll)){
$nofaktur=$datarinciii['nofaktur'];


$sqllll=mysql_query("select sum(jumlah) as jumta from trincipembelian where nofaktur='".$nofaktur."' and idbarang='".$kd_barang."'");
while($datarinciiii = mysql_fetch_array($sqllll)){
$jumta=$datarinciiii['jumta'];
$jumtambah=$jumtambah+$jumta;

}}}
else{
$nofaktur='';
$jumta=0;	
}
//mengeluarkan jumlah pengambilan 
$jumkurang=0;
$sss=mysql_query("select * from tpengambilan where tglambil='".$tanggal."' ");
if(mysql_num_rows($sss) > 0){
while($datarin = mysql_fetch_array($sss)){
$nofakturr=$datarin['nofaktur'];


$ssss=mysql_query("select sum(jumlah) as jumtaa from trincipengambilan where nofaktur='".$nofakturr."' and idbarang='".$kd_barang."'");
while($datarinc = mysql_fetch_array($ssss)){
$jumtaa=$datarinc['jumtaa'];
$jumkurang=$jumkurang+$jumtaa;

}}}
else{
$nofakturr='';
$jumtaa=0;	
}

$stockk=$stockk+$jumtambah-$jumkurang;
$awal=$stockk-$jumtambah+$jumkurang;
 ?>

<? if($jumtambah==0 and $jumkurang==0){?>

<?}else{?>
	<tr class="isi_laporan">
    <td align="center"><?php echo $tgll; ?>&nbsp;</td>
	   
		    <td align="center"><?php echo $awal; ?>&nbsp;</td>
			    <td align="center"><?php echo $jumtambah; ?>&nbsp;</td>
				<td align="center">
				<button class="btn btn-primary" value="<?php echo $tanggal.'&idbarang='.$kd_barang; ?>" onclick="popup(this.value)" name='tombol'>
                                Detail(+)
                            </button>
		</td>
    <td align="center"><?php echo $jumkurang; ?>&nbsp;</td>
	<td align="center"> 
	
	<button class="btn btn-primary" value="<?php echo $tanggal.'&idbarang='.$kd_barang; ?>" onclick="popup2(this.value)" name='tombol'>
                                Detail(-)
                            </button>

							</td>
    <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $stockk; ?>&nbsp;</td>
	
	

  </tr>
	
<?}?>

 

<?php }?>
  <tr >
    <td colspan='7'>Rincian Total </td>

  </tr>
<tr class="isi_laporan">
    <td align="center"><?php echo '1 s/d 31'; ?>&nbsp;</td>
	   
		    <td align="center"><?php echo $stockawal; ?>&nbsp;</td>
			    <td align="center"><?php echo $jumtambah; ?>&nbsp;</td>
				<td align="center">
			
		</td>
    <td align="center"><?php echo $jumkurang; ?>&nbsp;</td>
	<td align="center"> 
	


							</td>
    <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $stockk; ?>&nbsp;</td>
	
	

  </tr>

 <tr class="header_footer">
    <td colspan=7>&nbsp </td>

			

  </tr>
</table>
</div>
</body>
</html>
  <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS -->
    <script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable();
         });
    </script>
  	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Bagian untuk pengambilan Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
										
 <?$oo = mysql_query("SELECT * FROM tpembelian where tglbeli='$tanggalanyar'");
				if(mysql_num_rows($oo) > 0){
				while($dataoo = mysql_fetch_array($oo)){
				$nofaktur=$dataoo['nofaktur'];
				$idsupp=$dataoo['idsupp'];
				echo $nofaktur;
				}}?>
											
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