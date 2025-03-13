<script type="text/javascript">
function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;
</script>
<?php
include('config.php')
?>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>
<?php
$datee=date('Y-m-d');
 $jam = date("H:i");
$date=date('Y-m-d');
function kdauto($tabel, $inisial) {
    global $conn;
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);
    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $field = null;
    $maxLength = null;
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName'];
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);
    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);
    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);
    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;
    sqlsrv_free_stmt($stmt_max);
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT);
}
$no_faktur=kdauto("tpengambilan",'');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 500px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_service{
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
	<h4 align='center'>UPDATE SPESIFIKASI PC</h4>
	<div id="info_transaksi">
      	<form id="form_penjualan"  method="post" action="aplikasi/rpemakaipc/modal/simpaninputpc.php" enctype="multipart/form-data" name="postform2" >
	  	Nomor
	  	<input  readonly class="form-control"  type="text" name="nomoroke" value="<?php echo kdauto("pcaktif",""); ?>" >
        Divisi                                    
       <select class="form-control" name="divisi" required='required'>
			 <option ></option>
			 <option value="AMBASADOR">AMBASADOR</option>
			 <option value="EFRATA">EFRATA</option>
			 <option value="GARMENT">GARMENT</option>
			 <option value="MAS">MAS</option>
			 <option value="TEXTILE">TEXTILE</option>
			 <option value="KAS">PT. KAS</option>
		</select>	
 		Bagian                                      
        <select class="form-control" name='bagian' required='required'> 
			<option ></option>
        	<?php
			$query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
			$stmt = sqlsrv_query($conn, $query);
			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$id_bag_pemakai = $datas['id_bag_pemakai'];
					$bag_pemakai = $datas['bag_pemakai'];
					?>
					<option value="<?php echo $bag_pemakai; ?>"><?php echo $bag_pemakai; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>
        Sub Bagian                                      
        <select class="form-control" name='subbagian' required='required'> 
        	<option></option>
			<?php
			$query = "SELECT * FROM sub_bagian ORDER BY subbag_nama ASC";
			$stmt = sqlsrv_query($conn, $query);
			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$subbag_id = $datas['subbag_id'];
					$subbag_nama = $datas['subbag_nama'];
					?>
					<option value="<?php echo $subbag_nama; ?>"><?php echo $subbag_nama; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>
        Lokasi
        <select class="form-control" name='lokasi' required='required'> 
        	<option ></option>
			<?php
			$query = "SELECT * FROM lokasi ORDER BY lokasi_nama ASC";
			$stmt = sqlsrv_query($conn, $query);
			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$lokasi_id = $datas['lokasi_id'];
					$lokasi_nama = $datas['lokasi_nama'];
					?>
					<option value="<?php echo $lokasi_nama; ?>"><?php echo $lokasi_nama; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>
		User
		<input  class="form-control"  type="text" name="user">
		ID Komputer
		<input  class="form-control"  type="text" name="idpc" >                                           
		Nama Komputer
		<input  class="form-control"  type="text" name="namapc">                                     
		<br>
    </div>
	<div style="overflow:scroll;width:600px;height:500px;" id="data_barang">
	                           <div class="panel-body">
	   <div class="form-group">
 <b>Operation System</b>         
        <input  class="form-control"  type="text" name="os" >
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input    class="form-control"  type="text" name="ippc"  >
                                        </div>
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input  class="form-control"  type="text" name="harddisk" >
                                        </div>
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input   class="form-control"  type="text" name="ram" >
                                        </div>		
		<div class="form-group">
		<b>Model</b>                                    
		<select class="form-control" name="model" required='required'>
			 <option  ></option>
			 <option value="CPU">CPU</option>
			 <option value="LAPTOP">LAPTOP</option>
		</select>
		</div>
<div class="form-group">
 <b>Monitor</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
      <select class="form-control" name='monitor' >
	  <option > </option>
			<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00009' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>
  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram1' >
	  <option > </option>
	  		<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>
		  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram2' >
	  <option  ></option>
	  		<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>
   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd1' >
	  <option > </option>
	  	<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>
  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd2' >
	  <option  > </option>
	  		<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>										
	   <div class="form-group">
 <b>Motherboard </b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='mobo' >	
	  <option ></option>
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00001' AND stock > 0";
		$result = sqlsrv_query($conn, $query);
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		while ($datas1 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang = $datas1['idbarang'];
			$namabarang = $datas1['namabarang'];
			$stock = $datas1['stock'];
		?>
			<option value="<?php echo $idbarang; ?>"><?php echo $namabarang; ?></option>
		<?php } ?>
        </select> 
                                        </div>
 <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='prosesor'>
	  <option> </option>
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00002' AND stock > 0";
		$result = sqlsrv_query($conn, $query);
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		while ($datas2 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang2 = $datas2['idbarang'];
			$namabarang2 = $datas2['namabarang'];
		?>
			<option value="<?php echo $idbarang2; ?>"><?php echo $namabarang2; ?></option>
		<?php } ?>
        </select> 
                                        </div>
   	<div class="form-group">
 	<b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='powersuply'>
	  <option > </option>
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00003' AND stock > 0";
		$result = sqlsrv_query($conn, $query);
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang3 = $datas3['idbarang'];
			$namabarang3 = $datas3['namabarang'];
		?>
			<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
		<?php } ?>
        </select> 
    </div>
   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='cassing' >
	  <option > </option>
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00004' AND stock > 0";
		$result = sqlsrv_query($conn, $query);
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang3 = $datas3['idbarang'];
			$namabarang3 = $datas3['namabarang'];
		?>
        <option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
    	<?php } ?>
        </select> 
                                        </div>
	<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='dvd' >
	  <option > </option>
	  		<?php
			$query = "SELECT * FROM tbarang WHERE idkategori = '00008' AND stock > 0";
			$result = sqlsrv_query($conn, $query);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
        </select> 
                                        </div>
	<div class="form-group">
 		Bulan Perawatan         
		 <select class="form-control" name="bulan">
			<option ></option>
			<?php
			include('../config.php');
			$query = "SELECT * FROM bulan";
			$stmt = sqlsrv_query($conn, $query);
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$id_bulan = $row['id_bulan'];
					$bulan = $row['bulan'];
					?>
					<option value="<?php echo $id_bulan; ?>"><?php echo $bulan; ?></option>
					<?php
				}
			} else {
				$errors = sqlsrv_errors();
				foreach ($errors as $error) {
					echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
					echo "Code: " . $error['code'] . "<br />";
					echo "Message: " . $error['message'] . "<br />";
				}
			}
			?>
		</select>
                                        </div>	
   <input  class="form-control"  type="hidden" name="nomor" value="<?php echo $nomor; ?>" >
 <button  name="tombol"  class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
			 </td>
                                    </form>
									<br>
                            </div>
</div>
</body>
</html>
<iframe width="174" height="189" name="gToday:normal:/simitdlPHP8/calender/agenda.js" id="gToday:normal:/simitdlPHP8/calender/agenda.js" src="/simitdlPHP8/calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>          