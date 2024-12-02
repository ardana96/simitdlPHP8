
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="print">   
 table thead { display: table-header-group; } 
 </style>
</head>
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
<body style="background-image:url(../img/kertas.png); ">

<form action="lap_perawatanRouter.php"   method="POST" id="input_form" >
<table >
<tr>
<td colspan="3" align="center" class="judul">PERAWATAN ROUTER PDF</td>
</tr>
<tr>
  <td>Tahun :</td>
  <td> :</td>
  <td>
                                        
      <select  name="tahun"  id="tahun" style="width: 90px;">
          <?php
          for ($i = date('Y'); $i >= 2022; $i--) {
          if($i<10){ $i="0".$i; }
          echo"<option value=".$i.">".$i."</option>";}
          ?>    
      </select>
  </td>
</tr>
<tr>
 <td>Bulan :</td>
 <td> :</td>
 <td> <select name="bulan" style="width: 90px;">
 <option selected="selected" ></option>
 <option value="01">Januari </option>
 <option value="02">Februari</option>
 <option value="03">Maret</option>
 <option value="04">April</option>
 <option value="05">Mei</option>
 <option value="06">Juni</option>
 <option value="07">Juli</option>
 <option value="08">Agustus</option>
 <option value="09">September</option>
 <option value="10">Oktober</option>
 <option value="11">November</option>
 <option value="12">Desember</option>
</select>
 </td></tr>
<tr>
 <td>Divisi :</td>
 <td> :</td>
 <td class="isi_combo">
	<select  name="pdivisi" id="devisi" style="width: 90px;">
	 <option selected="selected"></option>
	 <option value="GARMENT">GARMENT</option>
	 <option value="TEXTILE">TEXTILE</option>
	</select>
 </td>
</tr>
<tr><td colspan="3" align="left"><img src="../img/pdf.png" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="PREVIEW PDF" ></tr> 
</table>


</form>
<!--
<form action="../excel/perawatan_excel.php"   method="POST" id="input_form">
<table>
<tr>
<td colspan="3" align="center" class="judul">PERAWATAN HARDWARE EXCEL</td>
</tr>
<tr>
 <td>Bulan :</td>
 <td> :</td>
 <td> <select name="divisi" required="required">
 <option selected="selected" ></option>
 <option value="01">Januari </option>
 <option value="02">Februari</option>
 <option value="03">Maret</option>
 <option value="04">April</option>
 <option value="05">Mei</option>
 <option value="06">Juni</option>
 <option value="07">Juli</option>
 <option value="08">Agustus</option>
 <option value="09">September</option>
 <option value="10">Oktober</option>
 <option value="11">November</option>
 <option value="12">Desember</option>
</select>
 </td></tr>
   </td>
</tr>
<tr>
 <td>Divisi :</td>
 <td> :</td>
 <td class="isi_combo"><select  name="pdivisi" id="devisi" required="required">
 <option selected="selected"></option>
 <option value="GARMENT">GARMENT</option>
 <option value="TEXTILE">TEXTILE</option>
</select>
 </td></tr>
<tr><td colspan="3" align="left"><img src="../img/excel.ico" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="DOWNLOAD EXCEL" ></tr> 
</table>
</form>-->
</div>
</body>
</html>
