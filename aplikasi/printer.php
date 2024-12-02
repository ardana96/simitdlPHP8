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
function sendRequest(nomor){
if(nomor==""){
alert("Anda belum memilih Printer !");}
else{   
http.open('GET', 'aplikasi/filterprinter.php?nomor=' + encodeURIComponent(nomor) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('nomor').value = string[0];  
document.getElementById('id_perangkat').value = string[1];
document.getElementById('printer').value = string[2]; 
document.getElementById('keterangan').value = string[3];
document.getElementById('status').value = string[4];
document.getElementById('user').value = string[5];
document.getElementById('lokasi').value = string[6];
document.getElementById('tgl_perawatan').value = string[7];
document.getElementById('bulan').value = string[8]; 



}}



</script>
<?
function kdauto($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}?>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Printer</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						
						     <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah Printer 
                            </button>
                       <!-- <a href="user.php?menu=tabarang"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Barang</button></a>
					    -->
						</div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
											  <th>ID Perangkat</th>
											    <th>Nama Perangkat</th>
                                 
                                            <th>Keterangan</th>
											       <th>Status</th>
									
											<th>Edit</th>
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM printer");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$nomor=$data['nomor'];
				$id_perangkat=$data['id_perangkat'];
				$printer=$data['printer'];
				$keterangan=$data['keterangan'];
				$status=$data['status'];
			
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $nomor ?></td>
											   <td><? echo $id_perangkat ?></td>
											      <td><? echo $printer ?></td>
                                  
                                            <td><? echo $keterangan ?></td>
											     <td><? echo $status ?></td>
									
                             
											 <td class="center">
											 <!--<form action="user.php?menu=feditbarang" method="post" >
											<input type="hidden" name="idbarang" value=
											// />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Edit</button>
											</form>-->
											<button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)">
                                Edit 
                            </button>
											
											</td>
											  <td class="center"><form action="aplikasi/deleteprinter.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            
                                        </tr>
                <?}}?>                      
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
                                            <h4 class="modal-title" id="H4"> Tambah Printer</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanprinter.php" method="post"  enctype="multipart/form-data" name="postform2">
                                       <div class="form-group">
                                         
                                            <input class="form-control" type="hidden" name="nomor" value="<? echo kdauto("printer",""); ?>" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         ID Perangkat
                                            <input class="form-control" type="text" name="id_perangkat" placeholder="ID Perangkat"  >
                                    
                                        </div>
											
										<div class="form-group">
											Printer
                                            <input class="form-control" type="text" name="printer" placeholder="Nama Perangkat"  >
                                    
                                        </div>
										
										
										<div class="form-group">
												Nama User                                    
                                            <input  placeholder="Nama User" class="form-control" type="text" name="nama_user" >
                                    
                                        </div>
										
										<div class="form-group">
												Lokasi                                    
                                            <input  placeholder="Lokasi" class="form-control" type="text" name="lokasi" >
                                    
                                        </div>
	
										<div class="form-group">
												 Keterangan                                    
                                            <input  placeholder="Keterangan" class="form-control" type="text" name="keterangan" >
                                    
                                        </div>
										
										<div class="form-group">
												 Tanggal Perawatan                                    
                                            <input  placeholder="hh-mm-yyyy" class="form-control" type="text" name="tgl_perawatan" >
                                    
                                        </div>
										<div class="form-group">
											Bulan Perawatan         
											<select  class="form-control" name='bulan' >	 <option value=<? echo $id_bulan; ?>><? echo $namabulan; ?> </option>
												
												<?	$s2 = mysql_query("SELECT * FROM bulan  ");
													if(mysql_num_rows($s2) > 0){
													while($datas2 = mysql_fetch_array($s2)){
													$id_bulan=$datas2['id_bulan'];
													$bulan=$datas2['bulan'];
													?>
												 <option value="<? echo $id_bulan; ?>"> <? echo $bulan; ?>
												 </option>
												 
												 <?}}?>
												
										
											</select>        
                                    
                                        </div>											
										Status                                       
        <select class="form-control" name='status' required="required">
             <option value="GARMENT" >GARMENT</option>
			 <option value="TEXTILE" >TEXTILE</option>
			
    
        </select>

																			
         
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
                                            <h4 class="modal-title" id="H4"> Edit Printer</h4>
                                        </div>
                                     <div class="modal-body">
                                       <form action="aplikasi/updateprinter.php" method="post"  enctype="multipart/form-data" name="postform2">
                                        <div class="form-group">
                                         
                                            <input class="form-control" type="hidden" name="nomor" id="nomor" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         ID Perangkat
                                            <input class="form-control" type="text" name="id_perangkat" id="id_perangkat"   >
                                    
                                        </div>
											
										<div class="form-group">
											Printer
                                            <input class="form-control" type="text" name="printer" id="printer" placeholder="ID Perangkat"  >
                                    
                                        </div>
										
										<div class="form-group">
											Nama User
                                            <input class="form-control" type="text" name="user" id="user" placeholder="Nama User"  >
                                        </div>
										
										<div class="form-group">
											Lokasi
                                            <input class="form-control" type="text" name="lokasi" id="lokasi" placeholder="Lokasi"  >
                                        </div>
										
										
	
										<div class="form-group">
											Keterangan                                 
                                            <input  placeholder="Keterangan" class="form-control" type="text" name="keterangan" id="keterangan" >
                                    
                                        </div>	
										
										<div class="form-group">
											Tanggal Perawatan
                                            <input class="form-control" type="text" name="tgl_perawatan" id="tgl_perawatan" placeholder="hh-mm-yyyy"  >
                                        </div>
										<div class="form-group">
											Bulan Perawatan                                       
											<select class="form-control" name='bulan' id='bulan' required="required">
												<option value="" ></option>
												<option value="01" >JANUARI</option>
												<option value="02" >FEBRUARI</option>
												<option value="03" >MARET</option>
												<option value="04" >APRIL</option>
												<option value="05" >MEI</option>
												<option value="06" >JUNI</option>
												<option value="07" >JULI</option>
												<option value="08" >AGUSTUS</option>
												<option value="09" >SEPTEMBER</option>
												<option value="10" >OKTOBER</option>
												<option value="11" >NOVEMBER</option>
												<option value="12" >DESEMBER</option>
													
												
										
											</select>
										</div>
										<div class="form-group">
											Status                                       
											<select class="form-control" name='status' id='status' required="required">
												 <option value="GARMENT" >GARMENT</option>
												 <option value="TEXTILE" >TEXTILE</option>
												
										
											</select>
                                       
                                
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