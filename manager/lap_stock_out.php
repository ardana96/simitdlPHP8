<?
include('../config.php');
?>
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
document.getElementById('www').value = string[0];
document.getElementById('www2').value = string[0];                                  
}}
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="print">   
 table thead { display: table-header-group; } 
 </style>


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
<script language="JavaScript" type="text/javascript" src="../suggestkartu.js"></script>
<style>
#input_form{
  background:#DCDCDC;
  border:1px solid #ccc;
  margin:auto;
  width:300px;
  padding:6px;
  border-radius:3px;
  border-bottom:4px solid #444;
}
.texbox{
height:30px;
border:1px solid #ccc;
}
.judul{
font-size:18px bold;
}
</style>

  <form id="input_form">
    <div id="suggestSearch">
      <table>
        <td> Nama Barang</td>
        <td>:</td>
        <td>
          <input name="barang" type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();"   autocomplete="off"/>
      <div  id="layer1" onclick="new sendRequest(this.value)"  class="isi_tabelll" ></div>

        </td>

      </table>
      
      
    </div>

  </form>
<body style="background-image:url(../img/kertas.png); ">

<form action="lap_stock_out_data.php"   method="POST" id="input_form" >
<table >
<tr>
<td colspan="3" align="center" class="judul">PENGELUARAN BARANG PDF</td>
</tr>

 <tr>
  <input type="hidden" name="kd_barang" id="www" readonly />
 <td>Bulan / tahun</td>
 <td> :</td>
 <td> <select name="bln_akhir" size="1" >
<?php
for($i=1;$i<=12;$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>    
    </select>
    <select name="thn_akhir" size="1" id="thn_akhir">
<?php
for($i=2013;$i<=date('Y');$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>    
    </select></td>
</tr>
<tr><td colspan="3" align="left"><img src="../img/pdf.png" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="PREVIEW PDF" ></tr> 
</table>
</form>

<form action="../excel/stock_out_excel.php"   method="POST" id="input_form">
<table>
<tr>
<td colspan="3" align="center" class="judul">PENGELUARAN BARANG EXCEL <br></td>
</tr>
 
<tr>
  <input type="hidden"  value="<?echo $kd_barang;?>" name="kd_barang" id="www2" readonly />
 <td>Bulan / tahun</td>
 <td> :</td>
 <td> <select name="bln_akhir" size="1" >
<?php
for($i=0;$i<=12;$i++){

if($i<10){ $i="0".$i; }

echo"<option value=".$i.">".$i."</option>";}
?>    
    </select>
    <select name="thn_akhir" size="1" id="thn_akhir">
<?php
for($i=2013;$i<=date('Y');$i++){
if($i<10){ $i="0".$i; }
echo"<option value=".$i.">".$i."</option>";}
?>    
    </select></td>
</tr>
<tr><td colspan="3" align="left"><img src="../img/excel.ico" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="DOWNLOAD EXCEL" ></tr> 
</table>
</form>
</div>
</body>
</html>
