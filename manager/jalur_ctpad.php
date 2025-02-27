<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ceklis CTPAT</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #2c3e50, #4ca1af);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            width: 380px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        
        .form-container h2 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .input-container {
            display: flex;
            flex-direction: column;
            gap: 5px; /* Spasi kecil antara label dan select */
            align-items: center;
            width: 100%;
        }

        /* Menambahkan spasi antara Pilih Bulan dan Pilih Divisi */
        .input-container + .input-container {
            margin-top: 20px; /* Jarak vertikal antara kedua input-container */
        }
        
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            background: #ecf0f1;
            color: #333;
        }
        
        .button-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin-top: 20px; /* Sesuaikan jarak dari input ke tombol */
        }
        
        .button-container input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            background: #27ae60;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .button-container input:hover {
            background: #2ecc71;
        }
        
        .button-container img {
            width: 30px;
            height: 30px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Form PDF -->
    <form action="lap_ctpad.php" method="POST" class="form-container">
        <h2>Laporan Ceklis CTPAT - PDF</h2>
        <div class="input-container">
            <label for="bulan">Pilih Bulan</label>
            <select name="bulan" id="bulan" required>
                <option value="">.:: Silahkan Pilih Bulan ::.</option>
                <option value="01">Januari</option>
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
        </div>
        
        <div class="input-container">
            <label for="divisi">Pilih Divisi</label>
            <select name="pdivisi" id="divisi" required>
                <option value="">.:: Silahkan Pilih Divisi ::.</option>
                <option value="GARMENT">Garment</option>
                <option value="TEXTILE">Textile</option>
            </select>
        </div>

        <div class="button-container">
            <input type="submit" name="simpan" value="PREVIEW PDF">
            <img src="../img/pdf.png" alt="PDF Icon">
        </div>
    </form>
</div>

</body>
</html>
<!-- 
#region Jalur CTPAT
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

<form action="lap_ctpad.php"   method="POST" id="input_form" >
<table >
<tr>
<td colspan="3" align="center" class="judul">Laporan Ceklis CTPAT</td>
</tr>
<tr>
 <td>Bulan :</td>
 <td> :</td>
 <td> <select name="bulan" >
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
 <td class="isi_combo"><select  name="pdivisi" id="devisi" required="required">
 <option selected="selected"></option>
 <option value="GARMENT">GARMENT</option>
 <option value="TEXTILE">TEXTILE</option>
</select>
 </td></tr>
<tr><td colspan="3" align="left"><img src="../img/pdf.png" style="width: 25px; height: 25px;"><input type="submit" name="simpan" value="PREVIEW PDF" ></tr> 
</table>


</form>
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
</form>
</div>
</body>
</html>
#endregion -->