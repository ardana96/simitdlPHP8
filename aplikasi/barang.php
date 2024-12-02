<?include('config.php');?>  
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idbarang){
if(idbarang==""){
alert("Anda belum memilih kode Barang !");}
else{   
http.open('GET', 'aplikasi/filterbarang.php?idbarang=' + encodeURIComponent(idbarang) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('idbarang').value = string[0];  
document.getElementById('idkategori').value = string[1];
document.getElementById('namabarang').value = string[2]; 
document.getElementById('barcode').value = string[3];
document.getElementById('stock').value = string[4]; 
document.getElementById('inventory').value = string[5];
document.getElementById('refil').value = string[6]; 
document.getElementById('ket').value = string[7]; 
document.getElementById('stockawal').value = string[8];  
                         
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

}}



</script>
<?php
function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
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
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
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

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength;
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}

?>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Barang</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						     <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah Barang 
                            </button>
                       <!--<a href="user.php?menu=tabarang"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Barang</button></a>-->
					     <!-- <a href="#" onclick="popup_print(8)"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Cetak Barcode</button></a> -->
                          
						  <button class="btn btn-primary" data-toggle="modal"  data-target="#newkat">
                                Tambah Kategori 
                            </button>
						</div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
											  <th>Barcode</th>
                                            <th>Kategori</th>
                                            <th>Nama Barang</th>
											<th>Awal</th>
											<th>Stock</th>
													<th>Stat</th>
													<th>Rutin</th>
													<th>Report</th>
											<th>Edit</th>
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                //                     
                $query = "SELECT tbarang.idbarang, tbarang.idkategori, tbarang.namabarang, tkategori.kategori, 
                                tbarang.stock, tbarang.stockawal, tbarang.barcode,
                                tbarang.cek, tbarang.rutin, tbarang.report
                                FROM tbarang
                                JOIN tkategori ON tbarang.idkategori = tkategori.idkategori
                                ORDER BY tbarang.namabarang";

                        $stmt = sqlsrv_query($conn, $query);

                       

                        // Periksa apakah ada hasil
                        if (sqlsrv_has_rows($stmt)) {
                            while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $idbarang = $data['idbarang'];
                                $idkategori = $data['idkategori'];
                                $namabarang = $data['namabarang'];
                                $kategori = $data['kategori'];
                                $stock = $data['stock'];
                                $stockawal = $data['stockawal'];
                                $barcode = $data['barcode'];
                                $cek = $data['cek'];
                                $rutin = $data['rutin'];
                                $report = $data['report'];

				
                
                ?>
				
                                        <tr class="gradeC">
                                            <td><?php echo $idbarang ?></td>
											   <td><?php echo $barcode ?></td>
                                            <td><?php echo $kategori ?></td>
                                            <td><?php echo $namabarang ?></td>
											<td><?php echo $stockawal ?></td>
												<td><?php echo $stock ?></td>
                             			 <td class="center">
											
											
										
<form name="testing" method="POST" action="aplikasi/updatecek.php">
<?php


echo "<table><tr>";
    if ($cek == 'admin')
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."'/>
<input type='checkbox' name='cek' value='' id='".$data['idbarang']."' checked='checked' onclick='this.form.submit();' />";
}
else
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."' />
<input type='checkbox' name='cek' value='admin' id='".$data['idbarang']."' onclick='this.form.submit();' />";
}
echo "</tr></table>";


?>
</form>	
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											</td>
												 <td class="center">
											
											
										
<form name="testing" method="POST" action="aplikasi/updaterutin.php">
<?php


echo "<table><tr>";
    if ($rutin== 'rutin')
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."'/>
<input type='checkbox' name='rutin' value='' id='".$data['idbarang']."' checked='checked' onclick='this.form.submit();' />";
}
else
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."' />
<input type='checkbox' name='rutin' value='rutin' id='".$data['idbarang']."' onclick='this.form.submit();' />";
}
echo "</tr></table>";


?>
</form>	
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											</td>
											 <td class="center">
											
											
										
<form name="testingg" method="POST" action="aplikasi/updatereportb.php">
<?php


echo "<table><tr>";
    if ($report == 'y')
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."'/>
<input type='checkbox' name='report' value='' id='".$data['idbarang']."' checked='checked' onclick='this.form.submit();' />";
}
else
{ 

echo "<td><input type='hidden' name='idbarang' value='".$data['idbarang']."' id='".$data['idbarang']."' />
<input type='checkbox' name='report' value='y' id='".$data['idbarang']."' onclick='this.form.submit();' />";
}
echo "</tr></table>";


?>
</form>	
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											</td>
											 <td class="center">
											
											<button class="btn btn-primary" value='<?php echo $idbarang; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)">
                                Edit 
                            </button>
											
											</td>
											  <td class="center"><form action="aplikasi/deletebarang.php" method="post" >
											<input type="hidden" name="idbarang" value=<?php echo $idbarang; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            
                                        </tr>
                <?php }}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
     
	 
	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbarang.php" method="post"  enctype="multipart/form-data" name="postform2">
                                       <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" value="<?php echo kdauto("tbarang",""); ?>" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         Barcode Barang
                                            <input class="form-control" type="text" name="barcode" placeholder="Barcode Barang"  >
                                    
                                        </div>
											
<div class="form-group">
                                           
Kategori                                         
        <select class="form-control" name='idkategori' required="required">
             <option ></option>
			<?php	

                $query = "SELECT * FROM tkategori";
                $stmt = sqlsrv_query($conn, $query);
                if (sqlsrv_has_rows($stmt)) {
                while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $idkategori = $datas['idkategori'];
                    $kategori = $datas['kategori'];
                ?>
			 <option value="<?php echo $idkategori; ?>"> <?php echo $kategori; ?>
			 </option>
			 
			 <?php }}?>
			
    
        </select>
                                    
                                        </div>	
	
<div class="form-group">
         Nama Barang                                   
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="namabarang" >
                                    
                                        </div>	
										<div class="form-group">
    Inventaris ( Barang bisa dipinjam )
                                         
        <select class="form-control" name='inventory' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	

																				<div class="form-group">
    Refil
                                         
        <select class="form-control" name='refil' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	
          Keterangan / Spesifikasi 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>                              
                                
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
					
					
					
					
					
	 <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Edit Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatebarang.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" id="idbarang" readonly >
                                    
                                        </div>
											<div class="form-group">
                                            Barcode Barang
                                            <input   class="form-control" type="text" name="barcode" id="barcode" >
                                    
                                        </div>

											<div class="form-group">
                                           
Kategori                                         
        <select class="form-control" name='idkategori' id='idkategori' required="required">
            
            <?php	

                $query = "SELECT * FROM tkategori";
                $stmt = sqlsrv_query($conn, $query);
                if (sqlsrv_has_rows($stmt)) {
                while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $idkategori = $datas['idkategori'];
                $kategori = $datas['kategori'];
            ?>
            <option value="<?php echo $idkategori; ?>"> <?php echo $kategori; ?>
            </option>

            <?php }}?>
    
        </select>
                                    
                                        </div>	
	
<div class="form-group">
         Nama Barang                                   
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="namabarang" id="namabarang" >
                                    
                                        </div>
											<div class="form-group">
    Inventory
                                         
        <select class="form-control" name='inventory' id='inventory' required="required">
			
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	

																				<div class="form-group">
    Refil
                                         
        <select class="form-control" name='refil' id='refil' required="required">
			 
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	
<div class="form-group">
         Stock Awal                                  
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="stockawal" id="stockawal" >
                                    
                                        </div>	
<div class="form-group">
         Stock                                   
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="stock" id="stock" >
                                    
                                        </div>											

             Keterangan / Spesifikasi 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder="" ></textarea>                                    
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Update</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					
					   <div class="col-lg-12">
                        <div class="modal fade" id="newkat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Kategori</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpankategori2.php" method="post"  enctype="multipart/form-data" name="postform2">
                                 
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idkategori" value="<?php echo kdauto("tkategori",""); ?>" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Kategori" class="form-control" type="text" name="kategori"  >
                                    
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