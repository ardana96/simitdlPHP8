<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Form Perawatan Printer</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
<style>
#input_form {
  background: #DCDCDC;
  border: 1px solid #ccc;
  margin: auto;
  width: 300px;
  padding: 6px;
  border-radius: 3px;
  border-bottom: 4px solid #444;
}
.texbox {
  height: 30px;
  border: 1px solid #ccc;
}
.judul {
  font-size: 18px bold;
}
</style>
</head>
<body style="background-image:url(../img/kertas.png);">
<form action="lap_perawatanPrinter.php" method="POST" id="input_form">
<table>
<tr>
<td colspan="3" align="center" class="judul">PERAWATAN PRINTER PDF</td>
</tr>
<tr>
  <td>Tahun:</td>
  <td>:</td>
  <td>
      <select name="tahun" id="tahun" style="width: 90px;">
          <?php
          for ($i = date('Y'); $i >= 2022; $i--) {
              echo "<option value='$i'>$i</option>";
          }
          ?>    
      </select>
  </td>
</tr>
<tr>
 <td>Bulan:</td>
 <td>:</td>
 <td>
    <select name="bulan" style="width: 90px;">
      <option value="" selected>Pilih Bulan</option>
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
 </td>
</tr>
<tr>
 <td>Divisi:</td>
 <td>:</td>
 <td>
    <select name="pdivisi" id="pdivisi" style="width: 90px;">
      <option value="" selected>Pilih Divisi</option>
      <option value="GARMENT">GARMENT</option>
      <option value="TEXTILE">TEXTILE</option>
    </select>
 </td>
</tr>
<tr>
<td colspan="3" align="left">
    <img src="../img/pdf.png" style="width: 25px; height: 25px;">
    <input type="submit" name="simpan" value="PREVIEW PDF">
</td>
</tr>
</table>
</form>
</body>
</html>
