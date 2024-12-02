<?include('config.php');
	if(isset($_POST['idpc'])){
$idpcc=$_POST['idpc'];
	}
?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Daftar Pemakai Komputer V2 <? echo $idpcc; ?></h2>



                    </div>
                </div>

                <hr />


                <div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    <a href="user.php?menu=inputpcV2"> <button class="btn btn-primary" >
                                Tambah PC
                            </button></a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
										
										 <th>Nomor</th>
										 <th>IP PC</th>
										 <th>ID PC</th>
                                            <th>User</th>
                                            <th>Nama PC</th>
                                            <th>Bagian</th>
                                            <th>Sub Bagian</th>
                                            <th>Lokasi</th>
											<th>Prosesor</th>
											<th>Motherboard</th>
											<th>Ram</th>
											<th>Harddisk</th>
											<th>Bulan</th>
											<th>Cek Perawatan</th>
											
										
											<th>Perawatan</th>
											<th>Spesifikasi</th>
										
												
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM pcaktif2 order by ippc desc ");
				if(mysql_num_rows($sql) > 0){
				$no = 1;	
				while($data = mysql_fetch_array($sql)){
				
				$user=$data['user'];
				$nomor=$data['nomor'];
				$bagian=$data['bagian'];
				$subbagian=$data['subbagian'];
				$lokasi=$data['lokasi'];
				$namapc=$data['namapc'];
				$ippc=$data['ippc'];
				$ram=$data['ram'];
				$harddisk=$data['harddisk'];
				$idpc=$data['idpc'];
				$bulan=$data['bulan'];
				$prosesor=$data['prosesor'];
				$mobo=$data['mobo'];
				$tgl_perawatan=$data['tgl_perawatan'];
				$tgl_update=$data['tgl_update'];
				$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namabulan=$dataa['bulan'];}
				?>
				
                                <tr class="gradeC">		
									<td><? echo $no++ ?></td>
									<td><? echo $ippc ?></td>
									<td><? echo $idpc ?></td>
                                    <td><? echo $user ?></td>
                                    <td><? echo $namapc?></td>
                                    <td><? echo $bagian ?></td>
                                    <td><? echo $subbagian?></td>
                                    <td><? echo $lokasi?></td>
									<td><? echo $prosesor ?></td>
									<td><? echo $mobo ?></td>
									<td><? echo $ram ?></td>
									<td><? echo $harddisk ?></td>
									<td><? echo $namabulan ?></td>
									<td><? echo $tgl_perawatan ?></td>
									<td class="center">
										<form action="user.php?menu=fupdate_pemakaipc2" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Perawatan</button>
										</form> 
									</td>
									<td class="center">
										<form action="user.php?menu=fupdate_kerusakanpc2" method="post" >
									
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Update</button>
										</form> 
									</td>
									<td class="center">
										<form action="aplikasi/deletepemakaipc2.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
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
           