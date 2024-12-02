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
function sendRequest(idsupp){
if(idsupp==""){
alert("Anda belum memilih kode Supplier !");}
else{   
http.open('GET', 'aplikasi/filtersupplier.php?idsupp=' + encodeURIComponent(idsupp) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('namasupp').value = string[0];  
document.getElementById('alamatsupp').value = string[1];
document.getElementById('telpsupp').value = string[2]; 
document.getElementById('kodesupp').value = string[3];                                        
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

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


                        <h2> Data Catridge</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                       <!--<a href="user.php?menu=tasupplier"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Supplier</button></a>
                       -->

                            <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button>
                             
                    


					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Nomor Barang</th>
                                            <th>Status</th>
											<th>Edit</th>
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tbarang a, tvalidasi b where  (a.idbarang = b.IdBarang)");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$IdBarang=$data['IdBarang'];
				$NamaBarang=$data['namabarang'];
				$NomorBarang=$data['NomorBarang'];
                $IsBack = $data['IsBack'];
                $Id=$data['Id'];
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $IdBarang ?></td>
                                            <td><? echo $NamaBarang ?></td>
                                            <td><? echo $NomorBarang ?></td>
                                            <td><? 
                                                if($IsBack == 0){ ?>
                                                    <button  name="tombol" class="btn text-muted text-center btn-danger">Tidak Ada</button>
                                                    <!-- echo "Tidak Ada"; -->
                                              <?  }else{ ?>
                                                    <button  name="tombol" class="btn text-muted text-center btn-success">Ada</button>
                                                    <!-- echo "Ada"; -->
                                               <? } ?></td>
                                            
											 <td class="center">
											
											
										
										<!-- 	 <button type="submit" class="btn btn-primary" value='<?php echo $idsupp; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
 -->

                             <button type="submit" class="btn btn-primary" value='<?php echo $idsupp; ?>' data-toggle="modal"  data-target="#newReggg<?php echo $Id; ?>" name='tomboledit'  >
                                Edit
                            </button>
												
											</td>
											  <td class="center"><form action="aplikasi/deletecatridge.php" method="post" >
											<input type="hidden" name="Id" value=<?php echo $Id; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            
                                        </tr>

                          
                            <div class="modal fade" id="newReggg<?php echo $Id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                        
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Edit Catridge  </h4>
                                        </div>
                                        <div class="modal-body">
                                           <form action="aplikasi/updatecatridge.php" method="post"  enctype="multipart/form-data" name="postform2">
                                             
                                                <?php
                                                $id = $data['id']; 
                                                $query_edit = mysql_query("SELECT * FROM tvalidasi WHERE Id='$Id'");
                                                //$result = mysqli_query($conn, $query);
                                                while ($row = mysql_fetch_array($query_edit)) {  
                                                ?>
                                                 <div class="form-group">
                                                 
                                                    <input class="form-control" type="text" name="Id" id="Id"  readonly value="<?php echo $row['Id']; ?>">
                                            
                                                </div>
                                              <div class="form-group">
                                                   Id Barang
                                                    <input placeholder="Id Barang" class="form-control" type="text" name="IdBarang" id="IdBarang"
                                                    value="<?php echo $row['IdBarang']; ?>"  >
                                            
                                                </div>  
            
                                                <div class="form-group">
                                                    Nomor Barang                                           
                                                    <input  placeholder="Nomor Barang" class="form-control" type="text" name="NomorBarang" id="NomorBarang" value="<?php echo $row['NomorBarang']; ?>">
                                            
                                                </div>  

                                                <?if($row['IsBack'] == 1) {?>

                                                <input type="radio" id="html" name="IsBack" value="1" checked="checked">
                                                <label for="html">Ada</label>
                                                <input type="radio" id="css" name="IsBack" value="0">
                                                <label for="css">Tidak ada </label>

                                                <?}else {?>

                                                <input type="radio" id="html" name="IsBack" value="1" >
                                                <label for="html">Ada</label>
                                                <input type="radio" id="css" name="IsBack" value="0" checked="checked">
                                                <label for="css">Tidak ada </label>
                                                <?}?>

                                               <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="Submit" class="btn btn-danger" name='tombol'>Update</button>
                                                </div>

                                            <?php 
                                            }
                                            ?>
                                        
                                        </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
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
                                            <h4 class="modal-title" id="H4"> Tambah Catridge</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpancatridge.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         
									   <div class="form-group">
                                           Id Barang
                                            <input placeholder="IdBarang" class="form-control" type="text" name="IdBarang"  >
                                    
                                        </div>	
	
                                        <div class="form-group">
                                            Nomor Barang                                            
                                            <input  placeholder="Alamat" class="form-control" type="text" name="NomorBarang" >
                                    
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


  
                       
					                               
                        
              				