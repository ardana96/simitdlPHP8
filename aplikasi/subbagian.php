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
function sendRequest(subbag_id){
if(subbag_id==""){
alert("Anda belum memilih kode Bagian !");}
else{   
http.open('GET', 'aplikasi/filter_subbag.php?subbag_id=' + encodeURIComponent(subbag_id) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('subbag_id').value = string[0];  
document.getElementById('subbag_nama').value = string[1];

                                       
// document.getElementById('jumlah').value="";
// document.getElementById('jumlah').focus();

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
            <h2> Data Sub Bagian </h2>
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
                                    <th>ID Sub Bagian</th>
                                    <th>Sub Bagian</th>
									<th>Edit</th>
									<th>Hapus</th>
									
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $sql = mysql_query("SELECT * FROM sub_bagian");
								if(mysql_num_rows($sql) > 0){
								while($data = mysql_fetch_array($sql)){
								$subbag_id=$data['subbag_id'];
								$subbag_nama=$data['subbag_nama'];
								?>

	                            <tr class="gradeC">
	                                <td><? echo $subbag_id ?></td>
	                                <td><? echo $subbag_nama ?></td>
									 <td class="center">
									 <button class="btn btn-primary" value='<?php echo $subbag_id; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)"> Edit </button>
									</td>
									<td class="center">
										<form action="aplikasi/deletesubbagian.php" method="post" >
											<input type="hidden" name="subbag_id" value=<?php echo $subbag_id; ?> />
								
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
										</form> 
									</td>
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
                        <h4 class="modal-title" id="H4"> Tambah Sub Bagian </h4>
                    </div>
                    
                    <div class="modal-body">
                       <form action="aplikasi/simpansubbagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
							<div class="form-group">         
                            	<input class="form-control" type="text" name="subbag_id" value="<? echo kdauto("sub_bagian","SB"); ?>" readonly>  
                            </div>
											
							<div class="form-group">             
                                <input placeholder="Nama Sub. Bagian" class="form-control" type="text" name="subbag_nama"  >       
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
                        <h4 class="modal-title" id="H4"> Edit Sub Bagian </h4>
                    </div>
                    
                    <div class="modal-body">
                       <form action="aplikasi/updatesubbagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
   						<div class="form-group">
                           <input class="form-control" type="text" name="subbag_id" id="subbag_id"  readonly>           
                        </div>
											
						<div class="form-group">               
                            <input placeholder="Nama Bagian" class="form-control" type="text" name="subbag_nama" id="subbag_nama"  >
                        </div>        
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
</div>                   