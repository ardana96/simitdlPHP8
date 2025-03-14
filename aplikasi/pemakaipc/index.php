<?php include('config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemakai Komputer V2</title>
    <link rel="stylesheet" href="aplikasi/pemakaipc/style/style_pmakaipc.css">
    <!-- Jika ada Bootstrap atau CSS lain, pastikan tetap disertakan -->
</head>
<body>
<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Daftar Pemakai Komputer </h2>
        </div>
    </div>
    <hr />

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="user.php?menu=inputpcnew100">
                        <button class="btn btn-primary">Tambah PC</button>
                    </a>
                    <!-- Dropdown akan dibuat di JavaScript -->
                    <button id="toggleFilter" class="btn btn-warning" style="margin-left: 10px;">Filter</button>
                </div>
                <div class="panel-body">
                    <div id="filterContainer" style="display: none; margin-top: 20px;">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="divisi">Divisi</label>
                                <select id="divisi" name="divisi" class="form-control">
                                    <option value="">Pilih Divisi</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="bagian">Bagian</label>
                                <select id="bagian" name="bagian" class="form-control">
                                    <option value="">Pilih Bagian</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="subBagian">Sub Bagian</label>
                                <select id="subBagian" name="subBagian" class="form-control">
                                    <option value="">Pilih Sub Bagian</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="lokasi">Lokasi</label>
                                <select id="lokasi" name="lokasi" class="form-control">
                                    <option value="">Pilih Lokasi</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="bulan">Bulan</label>
                                <select id="bulan" name="bulan" class="form-control">
                                    <option value="">Pilih Bulan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="pcLaptop">PC dan Laptop</label>
                                <select id="pcLaptop" name="pcLaptop" class="form-control">
                                    <option value="">Pilih Model</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12 text-right">
                            <button type="button" id="exportExcelBtn" class="btn btn-success" >Export Excel</button>
                                <button type="button" id="exportPdfBtn" class="btn btn-pdf" style="background-color: #ff4040; color: white;">Export PDF</button>
                                <button type="button" id="searchBtn" class="btn btn-primary">Cari</button>
                                <button type="button" id="resetBtn" class="btn btn-secondary" >Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <div id="recordsPerPageContainer"></div>
                    <div class="table-responsive" style='overflow: scroll;'>
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
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
                            <tbody id="dataBody">
                                <!-- Data akan dimasukkan lewat AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Tambahkan tempat pagination -->
                    <div id="pagination" style="margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('scripts/script_pemakaipc.php'); ?>
</body>
</html>