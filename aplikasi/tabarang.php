<?php
include('config.php');

?>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

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
                        <h1> PENAMBAHAN BARANG</h1>
						<hr>
                    </div>
                </div>
			   <div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-danger">
			   <?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?}
?> 
                        <div class="panel-heading">
                      <a href="user.php?menu=takategori"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Kategori</button></a> <a href="user.php?menu=kategori"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Hapus Kategori</button></a>  <a href="user.php?menu=barang"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Daftar Barang</button></a>
                        </div>
                        <div class="panel-body">
						
                            <form action="aplikasi/simpanbarang.php" method="post"  enctype="multipart/form-data" name="postform2">
   
									
	
										
	
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" placeholder="Barcode Barang"  >
                                    
                                        </div>
											
<div class="form-group">
                                           
                                         
        <select class="form-control" name='idkategori' required="required">
            
			<?	$s = mysql_query("SELECT * FROM tkategori ");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idkategori=$datas['idkategori'];
				$kategori=$datas['kategori'];?>
			 <option value="<? echo $idkategori; ?>"> <? echo $kategori; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
                                    
                                        </div>	
	
<div class="form-group">
                                            
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="namabarang" >
                                    
                                        </div>	


									
                                    <button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
            <button  name="button_tambah" class="btn text-muted text-center btn-primary" type="reset">Reset</button>
			 </td>

                                    </form>
									<br>
									
                            </div>
                        </div>
                            </div>
                </div>
				</div>
				<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>