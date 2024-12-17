<?php

include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data IP yang Sama </h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>IPPC</th>
                                            <th>Jumlah Sama</th>
                                          
								
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                $sql = "SELECT ippc, COUNT(*) AS jumlah FROM pcaktif GROUP BY ippc HAVING COUNT(ippc) > 1";
                $stmt = sqlsrv_query($conn, $sql);

                if (sqlsrv_has_rows($stmt)) {
                    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$ippc=$data['ippc'];
				$jumlah=$data['jumlah'];
		
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $ippc ?></td>
                                            <td><? echo $jumlah ?></td>
                                          
                             
									
                                            
                                        </tr>
                <?php }}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           