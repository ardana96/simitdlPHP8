<?include('config.php');?>  
<?
// function kdauto($tabel, $inisial){
// 	$struktur	= mysql_query("SELECT * FROM $tabel");
// 	$field		= mysql_field_name($struktur,0);
// 	$panjang	= mysql_field_len($struktur,0);

//  	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
//  	$row	= mysql_fetch_array($qry); 
//  	if ($row[0]=="") {
//  		$angka=0;
// 	}
//  	else {
//  		$angka		= substr($row[0], strlen($inisial));
//  	}
	
//  	$angka++;
//  	$angka	=strval($angka); 
//  	$tmp	="";
//  	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
// 		$tmp=$tmp."0";	
// 	}
//  	return $inisial.$tmp.$angka;
// }?>

<script language="javascript">
        // Fungsi untuk membuka modal edit atau tambah
        function openEditModal(id) {
            $('#id').val(id ? id : ''); // Set ID (null saat tambah)
            $('#user').val(''); // Kosongkan form
            $('#password').val(''); // Kosongkan form
            $('#akses').val(''); // Kosongkan form
            
                // Mengambil data dari server jika edit
                $.ajax({
                    url: 'aplikasi/user/get_user.php',
                    type: 'GET',
                    data: { id: id },
                    success: function(response) {
                        const data = JSON.parse(response);
                        $('#id_user').val(data.user.id_user);
                        $('#user').val(data.user.user);
                        $('#password').val(data.user.password);
                        $('#akses').val(data.user.akses);
                       /// document.getElementById('akses').value = string[data.user.akses]; 

                      
                    }
                });
           

            $('#newRegg').modal('show'); // Tampilkan modal
        }
        
        // Fungsi untuk menambah baris item di tabel
        function addRowEdit(itemName = '', id) {
            const row = `
                <tr id="itemRow_${id}"  >
                    <td><input type="text" name="nama_perawatan[]" value="${itemName}" class="form-control" required></td>
                    <td><input type="hidden" name="item_id[]" value="${id}" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger" onclick="hapusItem(${id})">Hapus</button></td>

                </tr>
            `;
            $('#itemTableEdit tbody').append(row);
        }

        // Fungsi untuk menghapus baris item
        function removeRowEdit(button) {
            $(button).closest('tr').remove();
        }

        function hapusItem(id_item) {
            $.ajax({
                url: 'aplikasi/perawatan/hapus_item.php', // URL ke script hapus_item.php
                type: 'POST',
                data: { id_item: id_item },
                success: function(response) {
                    if (response === 'success') {
                        // Hapus baris item dari tabel jika berhasil
                        $('#itemRow_' + id_item).remove();
                    } else {
                        alert('Gagal menghapus item. Silakan coba lagi.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus item.');
                }
            });
        }

        function simpanPerubahan() {
            const id_user = $('#id_user').val();
            const user = $('#user').val();
            const password = $('#password').val();
            const akses = $('#akses').val();

           

             $.ajax({
                url: 'aplikasi/user/edit_user.php',
                type: 'POST',
                data: {
                    id_user: id_user,
                    user: user,
                    password : password,
                    akses:akses
                },
               
              
                success: function(response) {
                    if (response === 'success') {
                        alert('Perubahan berhasil disimpan!');
                        $('#newRegg').modal('hide');
                        refresh();
                        // Lakukan tindakan tambahan jika diperlukan, seperti refresh data
                    } else {
                        alert('Gagal menyimpan perubahan. Silakan coba lagi.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan data.');
                }
            });
        }

        function refresh() {
            location.reload(); // Merefresh halaman
        }


</script>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idkategori){
if(idkategori==""){
alert("Anda belum memilih kode kategori !");}
else{   
http.open('GET', 'aplikasi/filterkategori.php?idkategori=' + encodeURIComponent(idkategori) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('idkategori').value = string[0];  
document.getElementById('kategori').value = string[1];
                                       
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

}}

var mywin; 
function popup(idkategori){
	if(idkategori==""){
alert("Anda kategori");}
else{   
mywin=window.open("manager/lap_jumkat.php?idkategori=" + idkategori ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}



</script>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Master Perawatan</h2>



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
                                            <th>Nama User</th>
											 
											 <th>Akses</th>
                                          
											
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tuser");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$id_user=$data['id_user'];
				$user=$data['user'];
                $akses=$data['akses'];
		
		
				
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $user ?></td>
                                            <td><? echo $akses ?></td>
												
                                           <td class="center">
											
											
										
							

                            <button type="button" class="btn btn-primary" onclick="openEditModal(<?php echo $id_user; ?>)">Edit</button>
												
											</td>
                             
											  <td class="center"><form action="aplikasi/user/deleteuser.php" method="post" >
											<input type="hidden" name="id" value=<?php echo $id_user; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">X</button>
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
                    <h4 class="modal-title" id="H4"> Tambah Master Perawatan</h4>
                </div>
                <div class="modal-body">
                    <form action="aplikasi/user/save_user.php" method="post"  enctype="multipart/form-data" name="postform2">

                            <div class="form-group">
                                <label for="user"> Nama User</label>
                                           
                                <input placeholder="Nama User" class="form-control" type="text" name="user"  >
                                   
                            </div>
                            <div class="form-group">
                                <label for="password"> Password</label>       
                                <input placeholder="Password" class="form-control" type="text" name="password"  >
                                   
                            </div>

                            <div class="form-group">
                                <!-- <label for="akses"> Hak Akses</label>  
                                <input placeholder="Hak Akses" class="form-control" type="text" name="akses"  > -->

                                <label for="akses"> Hak Akses</label>                                   
                                <select class="form-control" name="akses" >
                                    <option value=""></option>
                                    <option value="super admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="iso">Iso</option>
                                </select>	
                                   
                            </div>
                          
                    
            
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="refresh()">Close</button>
                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
					
					
<!-- Tombol untuk membuka Modal Tambah/Edit -->

<!-- Modal Tambah/Edit -->
<div class="col-lg-12">
    <div class="modal fade" id="newRegg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="H4">Tambah/Edit </h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_user" id="id_user">

                        <div class="form-group">
                            <label for="user"> Nama User</label>
                            <input placeholder="Nama User" class="form-control" type="text" name="user" id="user">
                        </div>

                        <div class="form-group">
                            <label for="password"> Password</label>
                            <input placeholder="Password" class="form-control" type="text" name="password" id="password">
                           
                        </div>

                        <div class="form-group">
                            <label for="akses"> Hak Akses</label>


                            <select class="form-control" name="akses" id="akses" >
                                <option value=""></option>
                                <option value="super admin">Super Admin</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                                <option value="iso">iso</option>
                            </select>
                          
                        </div>
                        
                        

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="refresh()">Tutup</button>
                            <button type="button" class="btn btn-danger" name="tombol" onclick="simpanPerubahan()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
					
				


<script>
// Fungsi untuk menambah baris item di tabel
function addRow() {
    var table = document.getElementById("itemTable").getElementsByTagName("tbody")[0];
    var newRow = table.rows[0].cloneNode(true);

    // Hapus nilai dari setiap input dalam baris yang baru
    var inputs = newRow.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = ""; // Setel nilai input menjadi kosong
    }

    table.appendChild(newRow); // Tambahkan baris yang sudah direset ke tabel
    //table.appendChild(newRow);
}


// Fungsi untuk menghapus baris item di tabel
function removeRow(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script>
					
					
					