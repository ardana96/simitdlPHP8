<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Retur Pengambilan</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                      
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
										 <th>No Faktur</th>
										       <th>Tgl </th>
                                            <th>Jam</th>
                                            <th>Nama</th>
                                            
											<th>Bagian</th>
											<th>Divisi</th>
										
											<th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php
                    $date=date('20y-m');
                    $datee=$date.'%';
                    $query = "SELECT * FROM tpengambilan 
                                INNER JOIN bagian ON tpengambilan.bagian = bagian.id_bagian";
          
                    // Eksekusi query
                    $sql = sqlsrv_query($conn, $query);
                    
                    // Periksa apakah query berhasil
                    if ($sql === false) {
                        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
                    }
                    
                    // Loop untuk mengambil dan memproses data
                    while ($data = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                        $nofaktur = $data['nofaktur'];
                        $tglambil = $data['tglambil'];
                        $jam = $data['jam'];
                        $nama = $data['nama'];
                        $bagian = $data['bagian'];
                        $divisi = $data['divisi'];
		
			
				?>
				
                                        <tr class="gradeC">
												<td><?php echo $nofaktur ?></td>
										<td><?php echo $tglambil->format('d F Y') ?></td>
                                            <td><?php echo $jam ?></td>
                                            <td><?php echo $nama?></td>
											<td><?php echo $bagian ?></td>
											<td><?php echo $divisi ?></td>
										
                             
										
											  <td class="center">
									<form action="user.php?menu=freturpengambilanadmin" method="post" >
									
											<input type="hidden" name="nofaktur" value=<?php echo $nofaktur; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Retur</button>
											</form> 
											</td>
                                            
                                        </tr>
                <?php }?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
			<meta http-equiv=refresh content=180;url='user.php?menu=homeadmin'>
           