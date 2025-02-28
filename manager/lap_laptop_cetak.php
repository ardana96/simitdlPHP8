
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemakaian Laptop</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #2c3e50, #4ca1af); /* Ubah arah gradasi */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            display: flex;
            gap: 20px;
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
            gap: 10px;
            align-items: center;
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
            margin-top: 10px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
    <form action="lap_laptop_pdf.php" method="POST" class="form-container">
        <h2>Pemakaian Laptop - PDF</h2>
        <div class="input-container">
            <label for="divisi_pdf">Pilih Divisi</label>
            <select name="divisi" id="divisi_pdf" required>
                <option value="">.:: Silahkan Pilih Divisi ::.</option>
                <option value="garment">Garment</option>
                <option value="textile">Textile</option>
            </select>
        </div>
        <div class="button-container">
            <input type="submit" name="simpan" value="PREVIEW PDF">
            <img src="../img/pdf.png">
        </div>
    </form>

    <!-- Form Excel -->
    <form action="../excel/pemakai_laptop_excel.php" method="POST" class="form-container">
        <h2>Pemakaian Laptop - Excel</h2>
        <div class="input-container">
            <label for="divisi_excel">Pilih Divisi</label>
            <select name="divisi" id="divisi_excel" required>
                <option value="">.:: Silahkan Pilih Divisi ::.</option>
                <option value="garment">Garment</option>
                <option value="textile">Textile</option>
            </select>
        </div>
        <div class="button-container">
            <input type="submit" name="simpan" value="DOWNLOAD EXCEL">
            <img src="../img/excel.ico">
        </div>
    </form>
</div>

</body>
</html>


<!-- // #region old code
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

<form action="lap_laptop_pdf.php"   method="POST" id="input_form" >
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

<form action="../excel/pemakai_laptop_excel.php"   method="POST" id="input_form">
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


// #endregion -->
