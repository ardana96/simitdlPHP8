<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css" />
    <style type="text/css" media="print">   
        table thead { display: table-header-group; } 
    </style>
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

    <form action="lap_pengambilan.php" method="POST" id="input_form">
        <table>
            <tr>
                <td colspan="3" align="center" class="judul">PENGAMBILAN BARANG PDF</td>
            </tr>
            <tr>
                <td>Bulan / tahun</td>
                <td> :</td>
                <td>
                    <select name="bln_akhir" size="1">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i < 10) { $i = "0" . $i; }
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>    
                    </select>
                    <select name="thn_akhir" size="1" id="thn_akhir">
                        <?php
                        for ($i = 2013; $i <= date('Y'); $i++) {
                            if ($i < 10) { $i = "0" . $i; }
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>    
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

    <form action="../excel/ambil_excel.php" method="POST" id="input_form">
        <table>
            <tr>
                <td colspan="3" align="center" class="judul">PENGAMBILAN BARANG EXCEL</td>
            </tr>
            <tr>
                <td>Bulan / tahun</td>
                <td> :</td>
                <td>
                    <select name="bln_akhir" size="1">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i < 10) { $i = "0" . $i; }
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>    
                    </select>
                    <select name="thn_akhir" size="1" id="thn_akhir">
                        <?php
                        for ($i = 2013; $i <= date('Y'); $i++) {
                            if ($i < 10) { $i = "0" . $i; }
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>    
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="left">
                    <img src="../img/excel.ico" style="width: 25px; height: 25px;">
                    <input type="submit" name="simpan" value="DOWNLOAD EXCEL">
                </td>
            </tr> 
        </table>
    </form>

</body>
</html>
