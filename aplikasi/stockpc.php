<?php include('config.php'); ?>  

<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Stock Komputer Rakitan</h2>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="table-responsive" style='overflow: scroll;'>
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>IDPC</th>
                                    <th>Permintaan</th>
                                    <th>No Faktur</th>
                                    <th>Tgl Pembelian</th>
                                    <th>Supplier</th>
                                    <th>Motherboard</th>
                                    <th>Prosesor</th>
                                    <th>Power Supply</th>
                                    <th>Casing</th>
                                    <th>Harddisk I</th>
                                    <th>Harddisk II</th>
                                    <th>Ram I</th>
                                    <th>Ram II</th>
                                    <th>Fan Prosesor</th>
                                    <th>DVD</th>
                                    <th>Keterangan</th>
                                    <th>Edit</th>
                                    <th>PC Baru</th>
                                    <th>PC Update</th>
                                    <th>Hidden</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM tpc WHERE status = 'digudang' AND aktif <> 'nonaktif'";
                                $stmt = sqlsrv_query($conn, $query);
                                if ($stmt && sqlsrv_has_rows($stmt)) {
                                    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $idpc = $data['idpc'];
                                        $mobo = $data['mobo'];
                                        $prosesor = $data['prosesor'];
                                        $ps = $data['ps'];
                                        $tglrakit = $data['tglrakit'];
                                        $casing = $data['casing'];
                                        $hd1 = $data['hd1'];
                                        $namapeminta = $data['permintaan'];
                                        $hd2 = $data['hd2'];
                                        $ram1 = $data['ram1'];
                                        $ram2 = $data['ram2'];
                                        $fan = $data['fan'];
                                        $dvd = $data['dvd'];

                                        $tglrakittt = $tglrakit;
                                        $keterangan = $data['keterangan'];

                                        // Ambil permintaan
                                        $nopeminta = $nmpeminta = $nfak = $supp = '';
                                        $queryRinci = "SELECT nomor FROM rincipermintaan WHERE namabarang = ?";
                                        $stmtRinci = sqlsrv_query($conn, $queryRinci, array($idpc));
                                        if ($stmtRinci = sqlsrv_fetch_array($stmtRinci, SQLSRV_FETCH_ASSOC)) {
                                            $nopeminta = $stmtRinci['nomor'];

                                            $queryPermintaan = "SELECT nama FROM permintaan WHERE nomor = ?";
                                            $stmtPermintaan = sqlsrv_query($conn, $queryPermintaan, array($nopeminta));
                                            if ($stmtPermintaan) {
                                                $rincibb = sqlsrv_fetch_array($stmtPermintaan, SQLSRV_FETCH_ASSOC);
                                                $nmpeminta = $rincibb['nama'];
                                            }
                                        } else {
                                            $nmpeminta = $namapeminta;
                                        }

                                        // Ambil data pembelian
                                        $queryPembelian = "SELECT nofaktur, tglbeli, idsupp FROM tpembelian 
                                                           INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                                                           WHERE trincipembelian.namabarang = ?";
                                        $stmtPembelian = sqlsrv_query($conn, $queryPembelian, array($idpc));
                                        if ($stmtPembelian && sqlsrv_fetch_array($stmtPembelian, SQLSRV_FETCH_ASSOC)) {
                                            $nfak = $stmtPembelian['nofaktur'];
                                            $tglbeli = $stmtPembelian['tglbeli'];
                                            $idsupp = $stmtPembelian['idsupp'];
                                            $tgllll = date("d-m-Y", strtotime($tglbeli));

                                            $querySupplier = "SELECT namasupp FROM tsupplier WHERE idsupp = ?";
                                            $stmtSupplier = sqlsrv_query($conn, $querySupplier, array($idsupp));
                                            if ($stmtSupplier) {
                                                $rincidd = sqlsrv_fetch_array($stmtSupplier, SQLSRV_FETCH_ASSOC);
                                                $supp = $rincidd['namasupp'];
                                            }
                                        }
                                ?>
                                        <tr class="gradeC">
                                            <td><?php echo $idpc; ?></td>
                                            <td><?php echo $nmpeminta; ?></td>
                                            <td><?php echo $nfak; ?></td>
                                            <td><?php echo $tglrakittt->format('d - m- Y'); ?></td>
                                            <td><?php echo $supp; ?></td>
                                            <td><?php echo $mobo; ?></td>
                                            <td><?php echo $prosesor; ?></td>
                                            <td><?php echo $ps; ?></td>
                                            <td><?php echo $casing; ?></td>
                                            <td><?php echo $hd1; ?></td>
                                            <td><?php echo $hd2; ?></td>
                                            <td><?php echo $ram1; ?></td>
                                            <td><?php echo $ram2; ?></td>
                                            <td><?php echo $fan; ?></td>
                                            <td><?php echo $dvd; ?></td>
                                            <td><?php echo $keterangan; ?></td>
                                            <td class="center">
                                                <form action="user.php?menu=editstockpc" method="post">
                                                    <input type="hidden" name="idpc" value="<?php echo $idpc; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">Edit</button>
                                                </form>
                                            </td>
                                            <td class="center">
                                                <form action="user.php?menu=keluarpc" method="post">
                                                    <input type="hidden" name="idpc" value="<?php echo $idpc; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">PC Baru</button>
                                                </form>
                                            </td>
                                            <td class="center">
                                                <form action="user.php?menu=rakitupdate" method="post">
                                                    <input type="hidden" name="idpc" value="<?php echo $idpc; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-danger" type="submit">PC Update</button>
                                                </form>
                                            </td>
                                            <td class="center">
                                                <form action="aplikasi/hiddenstockpc.php" method="post">
                                                    <input type="hidden" name="idpc" value="<?php echo $idpc; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-primary" type="submit" onclick="return confirm('Apakah anda yakin akan menutup data ini?')">Hidden</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
