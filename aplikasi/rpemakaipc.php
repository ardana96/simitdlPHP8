<?php include('config.php');
	// if(isset($_POST['idpc'])){
	// $idpcc=$_POST['idpc'];
	// }
?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Daftar Pemakai Komputer <?php //echo $idpcc; ?></h2>



                    </div>
                </div>

                <hr />


                <div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    <a href="user.php?menu=inputpc"> <button class="btn btn-primary" >
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
                                       <?php 
									   $query = "SELECT * FROM pcaktif ORDER BY ippc DESC";
									   $stmt = sqlsrv_query($conn, $query);
									   
									   if ($stmt === false) {
										   

										   echo "Query gagal dijalankan.<br>";
										   if (($errors = sqlsrv_errors()) != null) {
											   foreach ($errors as $error) {
												   echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
												   echo "Code: " . $error['code'] . "<br>";
												   echo "Message: " . $error['message'] . "<br>";
											   }
										   }
									   } else {
											while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
											
									   
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
				$tgl_perawatan=$data['tgl_perawatan']? $data['tgl_perawatan']->format('Y-m-d') : '';
				$tgl_update=$data['tgl_update'] ? $data['tgl_update']->format('Y-m-d') : '';

				$query = "SELECT * FROM bulan WHERE id_bulan = '$bulan'";
				$params = [$bulan];
				$stmtbulan = sqlsrv_query($conn, $query, $params);
				while ($dataa = sqlsrv_fetch_array($stmtbulan, SQLSRV_FETCH_ASSOC)) {
					$namabulan = $dataa['bulan'];
				}
			
				?>
				
                                <tr class="gradeC">		
									<td><?php echo $nomor ?></td>
									<td><?php echo $ippc ?></td>
									<td><?php echo $idpc ?></td>
                                    <td><?php echo $user ?></td>
                                    <td><?php echo $namapc?></td>
                                    <td><?php echo $bagian ?></td>
                                    <td><?php echo $subbagian?></td>
                                    <td><?php echo $lokasi?></td>
									<td><?php echo $prosesor ?></td>
									<td><?php echo $mobo ?></td>
									<td><?php echo $ram ?></td>
									<td><?php echo $harddisk ?></td>
									<td><?php echo $namabulan ?></td>
									<td><?php echo $tgl_perawatan ?></td>
									<td class="center">
										<form action="user.php?menu=fupdate_pemakaipc" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Perawatan</button>
										</form> 
									</td>
									<td class="center">
										<form action="user.php?menu=fupdate_kerusakanpc" method="post" >
									
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Update</button>
										</form> 
									</td>
									<td class="center">
										<form action="aplikasi/deletepemakaipc.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
										</form> 
									</td>
								</tr>
                				<?php }}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           