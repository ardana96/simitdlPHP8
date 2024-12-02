
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

<form action="lap_laptop_pdf_V2.php"   method="POST" id="input_form" >
<table >
<tr>
<td colspan="3" align="center" class="judul">PEMAKAIAN LAPTOP PDF</td>
</tr>
 <tr>
 <td>Pilih Divisi</td>
 <td> :</td>
 <td>  
    <select name="divisi" size="1" id="divisi" required="required">
    <option value="">.:: Silahkan Pilih Divisi ::.</option>
    <option value="garment">Garment</option>
    <option value="textile">Textile</option>
 
    </select>
</td>
</tr>
<tr><td colspan="3" align="left"><img src="../img/pdf.png" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="PREVIEW PDF" ></tr> 
</table>
</form>

<form action="../excel/pemakai_laptop_excel_V2.php"   method="POST" id="input_form">
<table>
<tr>
<td colspan="3" align="center" class="judul">PEMAKAIAN LAPTOP EXCEL</td>
</tr>
<tr>
 <td>Pilih Divisi</td>
 <td> :</td>
 <td> 
    <select name="divisi" size="1" id="divisi" required="required">
    <option value="">.:: Silahkan Pilih Divisi ::.</option>
    <option value="garment">Garment</option>
    <option value="textile">Textile</option>
 
    </select>
 </td>
</tr>
<tr><td colspan="3" align="left"><img src="../img/excel.ico" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="DOWNLOAD EXCEL" ></tr> 
</table>
</form>
</div>
</body>
</html>
