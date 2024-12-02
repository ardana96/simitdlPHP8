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
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=propinsi>
  $("#propinsi").change(function(){
    var propinsi = $("#propinsi").val();
    $.ajax({
        url: "aplikasi/ambilkota.php",
        data: "propinsi="+propinsi,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=kota>
            $("#kota").html(msg);
        }
    });
  });
  $("#kota").change(function(){
    var kota = $("#kota").val();
    $.ajax({
        url: "aplikasi/ambilkecamatan.php",
        data: "kota="+kota,
        cache: false,
        success: function(msg){
            $("#kec").html(msg);
        }
    });
  });

  $("#kec").change(function(){
    var kec = $("#kec").val();
    $.ajax({
        url: "aplikasi/ambilkelurahan.php",
        data: "kec="+kec,
        cache: false,
        success: function(msg){
            $("#kel").html(msg);
        }
    });
  });

});

</script>

    <div class="inner">
		    <div class="row">
                    <div class="col-lg-12">
                        <h3> Tambah Daftar Booking</h3>
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
                         <a href="pemakai.php?menu=booking"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Daftar Booking</button></a>
                        </div>
                        <div class="panel-body">
						
                            <form action="aplikasi/simpanbooking.php" method="post"  enctype="multipart/form-data" name="postform2">
   									
								

										<div class="form-group">
Tanggal Booking<br>
                                            
                                          <input required='required' type="text" id="from" name="tgl" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                    
			               
				 </div>	

<div class="form-group">
                                           
Nama Barang                                       
        <select class="form-control" name='idbarang' required="required">
             <option ></option>
			<?	$s = mysql_query("SELECT * FROM tbarang where inventory='Y' ");
				if(mysql_num_rows($s) > 0){
			 while($datas = mysql_fetch_array($s)){
				$idbarang=$datas['idbarang'];
				$namabarang=$datas['namabarang'];?>
			 <option value="<? echo $idbarang; ?>"> <? echo $namabarang; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
                                    
                                        </div>	

	
<div class="form-group">
                                    Keperluan       
                                         <textarea cols="45" rows="5" name="keperluan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>                              
      
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