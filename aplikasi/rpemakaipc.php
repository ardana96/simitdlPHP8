<?php
include('config.php');

$idpcc = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null);

// Pastikan koneksi ke database berhasil
if (!$conn) {
    die(json_encode(array("error" => "Koneksi database gagal: " . print_r(sqlsrv_errors(), true))));
}

// Query utama
$sql = sqlsrv_query($conn, "SELECT * FROM pcaktif ORDER BY ippc DESC");

// **Periksa apakah query berhasil**
if ($sql === false) {
    die(json_encode(array("error" => "Query gagal: " . print_r(sqlsrv_errors(), true))));
}

// Query untuk mendapatkan nilai unik untuk dropdown
$divisiQuery = sqlsrv_query($conn, "SELECT DISTINCT divisi FROM pcaktif ORDER BY divisi ASC");
$bagianQuery = sqlsrv_query($conn, "SELECT DISTINCT bagian FROM pcaktif ORDER BY bagian ASC");
$subbagianQuery = sqlsrv_query($conn, "SELECT DISTINCT subbagian FROM pcaktif ORDER BY subbagian ASC");
$lokasiQuery = sqlsrv_query($conn, "SELECT DISTINCT lokasi FROM pcaktif ORDER BY lokasi ASC");
$bulanQuery = sqlsrv_query($conn, "SELECT id_bulan, bulan FROM bulan ORDER BY id_bulan ASC");

// Fungsi untuk mengambil hasil query
function fetchResults($query)
{
    if ($query === false) {
        die(json_encode(array("error" => "Query gagal: " . print_r(sqlsrv_errors(), true))));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}

// Ambil hasil query untuk dropdown
$divisiData = fetchResults($divisiQuery);
$bagianData = fetchResults($bagianQuery);
$subbagianData = fetchResults($subbagianQuery);
$lokasiData = fetchResults($lokasiQuery);
$bulanData = fetchResults($bulanQuery);
?>

<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Daftar Pemakai Komputer <?php echo $idpcc; ?></h2>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="user.php?menu=inputpc">
                        <button class="btn btn-primary">Tambah PC</button>
                    </a>
                    <button class="btn btn-warning" id="toggleFilter">Filter</button>
                </div>

                <div class="panel-body">
                    <div class="filter-container" id="filterContainer" style="margin-bottom: 20px; display: none;">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="divisi">Divisi</label>
                                    <select id="divisi" name="divisi" class="form-control">
                                        <option value="">Pilih Divisi</option>
                                        <?php foreach ($divisiData as $row) {
                                            echo "<option value='" . $row['divisi'] . "'>" . $row['divisi'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="bagian">Bagian</label>
                                    <select id="bagian" name="bagian" class="form-control">
                                        <option value="">Pilih Bagian</option>
                                        <?php foreach ($bagianData as $row) {
                                            echo "<option value='" . $row['bagian'] . "'>" . $row['bagian'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="subbagian">Sub Bagian</label>
                                    <select id="subbagian" name="subbagian" class="form-control">
                                        <option value="">Pilih Sub Bagian</option>
                                        <?php foreach ($subbagianData as $row) {
                                            echo "<option value='" . $row['subbagian'] . "'>" . $row['subbagian'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="lokasi">Lokasi</label>
                                    <select id="lokasi" name="lokasi" class="form-control">
                                        <option value="">Pilih Lokasi</option>
                                        <?php foreach ($lokasiData as $row) {
                                            echo "<option value='" . $row['lokasi'] . "'>" . $row['lokasi'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="bulan">Bulan</label>
                                    <select id="bulan" name="bulan" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                        <?php foreach ($bulanData as $row) {
                                            echo "<option value='" . $row['id_bulan'] . "'>" . $row['bulan'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="model">PC dan Laptop</label>
                                    <select id="model" name="model" class="form-control">
                                        <option value="">Pilih Model</option>
                                        <option value="CPU">PC</option>
                                        <option value="Laptop">Laptop</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <button type="button" id="clearFilter" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>

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
                                // Periksa apakah ada data
                                if (sqlsrv_has_rows($sql)) {
                                    while ($data = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                                        $user = $data['user'];
                                        $nomor = $data['nomor'];
                                        $bagian = $data['bagian'];
                                        $subbagian = $data['subbagian'];
                                        $lokasi = $data['lokasi'];
                                        $namapc = $data['namapc'];
                                        $ippc = $data['ippc'];
                                        $ram = $data['ram'];
                                        $harddisk = $data['harddisk'];
                                        $idpc = $data['idpc'];
                                        $bulan = $data['bulan'];
                                        $prosesor = $data['prosesor'];
                                        $mobo = $data['mobo'];
                                        $tgl_perawatan = isset($data['tgl_perawatan']) && $data['tgl_perawatan'] instanceof DateTime
                                            ? $data['tgl_perawatan']->format('Y-m-d')
                                            : $data['tgl_perawatan'];
                                        $tgl_update = isset($data['tgl_update']) && $data['tgl_update'] instanceof DateTime
                                            ? $data['tgl_update']->format('Y-m-d')
                                            : $data['tgl_update'];

                                        // Query untuk mendapatkan nama bulan berdasarkan id_bulan
                                        $sqlll = sqlsrv_query($conn, "SELECT bulan FROM bulan WHERE id_bulan = ?", array($bulan));

                                        // Pastikan query bulan berhasil
                                        if ($sqlll && $bulanData = sqlsrv_fetch_array($sqlll, SQLSRV_FETCH_ASSOC)) {
                                            $namabulan = $bulanData['bulan'];
                                        } else {
                                            $namabulan = "Tidak Diketahui";
                                        }
                                ?>
                                        <tr class="gradeC">
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $ippc; ?></td>
                                            <td><?php echo $idpc; ?></td>
                                            <td><?php echo $user; ?></td>
                                            <td><?php echo $namapc; ?></td>
                                            <td><?php echo $bagian; ?></td>
                                            <td><?php echo $subbagian; ?></td>
                                            <td><?php echo $lokasi; ?></td>
                                            <td><?php echo $prosesor; ?></td>
                                            <td><?php echo $mobo; ?></td>
                                            <td><?php echo $ram; ?></td>
                                            <td><?php echo $harddisk; ?></td>
                                            <td><?php echo $namabulan; ?></td>
                                            <td><?php echo $tgl_perawatan; ?></td>
                                            <td class="center">
                                                <form action="user.php?menu=fupdate_pemakaipc" method="post">
                                                    <input type="hidden" name="nomor" value="<?php echo $nomor; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">Perawatan</button>
                                                </form>
                                            </td>
                                            <td class="center">
                                                <form action="user.php?menu=fupdate_kerusakanpc" method="post">
                                                    <input type="hidden" name="nomor" value="<?php echo $nomor; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">Update</button>
                                                </form>
                                            </td>
                                            <td class="center">
                                                <form action="aplikasi/deletepemakaipc.php" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-danger" type="submit"
                                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')">X
                                                    </button>
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

<script>
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterContainer = document.getElementById('filterContainer');
        if (filterContainer.style.display === 'none') {
            filterContainer.style.display = 'block';
            this.textContent = 'Sembunyikan Filter';
        } else {
            filterContainer.style.display = 'none';
            this.textContent = 'Filter';
        }
    });

    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Ambil semua elemen input di dalam form
        const form = this;
        const inputs = form.querySelectorAll('select');
        let isValid = false;

        // Periksa apakah ada salah satu input yang diisi
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                isValid = true;
            }
        });

        // Jika tidak ada input yang diisi, tampilkan peringatan dan hentikan proses submit
        if (!isValid) {
            alert('Form Filter harus diisi salah satunya'); // Peringatan untuk input kosong
            return;
        }

        const formData = new FormData(this);
        const filterData = {};
        formData.forEach((value, key) => {
            filterData[key] = value;
        });

        // Mapping bulan ID ke nama bulan
        const bulanMapping = {
            "01": "Januari",
            "02": "Februari",
            "03": "Maret",
            "04": "April",
            "05": "Mei",
            "06": "Juni",
            "07": "Juli",
            "08": "Agustus",
            "09": "September",
            "10": "Oktober",
            "11": "November",
            "12": "Desember"
        };

        fetch('aplikasi/filter_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(filterData)
            })
            .then(response => response.json())
            .then(data => {
                var table = $('#dataTables-example').DataTable(); // Ambil instance DataTables

                table.clear().draw(); // Hapus semua data tanpa kehilangan pagination

                data.forEach((item, index) => {
                    // Konversi ID bulan menjadi nama bulan
                    const namaBulan = bulanMapping[item.bulan] || "Tidak diketahui";

                    table.row.add([
                        item.nomor,
                        item.ippc,
                        item.idpc,
                        item.user,
                        item.namapc,
                        item.bagian,
                        item.subbagian,
                        item.lokasi,
                        item.prosesor,
                        item.mobo,
                        item.ram,
                        item.harddisk,
                        namaBulan, // Gunakan nama bulan yang sudah dikonversi
                        item.tgl_perawatan,
                        `<form action="user.php?menu=fupdate_pemakaipc" method="post">
                        <input type="hidden" name="nomor" value="${item.nomor}" />
                        <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">Perawatan</button>
                    </form>`,
                        `<form action="user.php?menu=fupdate_kerusakanpc" method="post">
                        <input type="hidden" name="nomor" value="${item.nomor}" />
                        <button name="tombol" class="btn text-muted text-center btn-primary" type="submit">Update</button>
                    </form>`,
                        `<form action="aplikasi/deletepemakaipc.php" method="post">
                        <input type="hidden" name="nomor" value="${item.nomor}" />
                        <button name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
                    </form>`
                    ]).draw(false); // Tambahkan tanpa mereset tabel
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.getElementById('clearFilter').addEventListener('click', function() {
        // Refresh page
        window.location.reload();
    });
</script>