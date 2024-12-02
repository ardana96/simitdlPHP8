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
function sendRequest(id_bagian){
if(id_bagian==""){
alert("Anda belum memilih kode Bagian !");}
else{   
http.open('GET', 'aplikasi/filterbagian.php?id_bagian=' + encodeURIComponent(id_bagian) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('id_bagian').value = string[0];  
document.getElementById('bagian').value = string[1];

                                       
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


                        <h2> Data Bagian untuk Pengambilan Barang</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
          
  <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button>                       
					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Bagian</th>
                                            <th>Bagian</th>
											<th>Edit</th>
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM bagian");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$id_bagian=$data['id_bagian'];
				$bagian=$data['bagian'];
				
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $id_bagian ?></td>
                                            <td><? echo $bagian ?></td>
                                     
											 <td class="center"><button class="btn btn-primary" value='<?php echo $id_bagian; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)">
                                Edit 
                            </button></td>
											  <td class="center"><form action="aplikasi/deletebagian.php" method="post" >
											<input type="hidden" name="id_bagian" value=<?php echo $id_bagian; ?> />
										
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
                                            <h4 class="modal-title" id="H4"> Tambah Bagian untuk pengambilan Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
										
	
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="id_bagian" value="<? echo kdauto("bagian","B"); ?>" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Nama Bagian" class="form-control" type="text" name="bagian"  >
                                    
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
					
					
					
   <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Edit Bagian untuk pengambilan Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatebagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
										
	
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="id_bagian" id="id_bagian"  readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Nama Bagian" class="form-control" type="text" name="bagian" id="bagian"  >
                                    
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
					
					