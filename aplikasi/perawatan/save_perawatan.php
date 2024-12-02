<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "dlris30g";
$dbname = "sitdl";

// Membuat koneksi
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

// Memilih database
mysql_select_db($dbname, $conn);

// Ambil data header dari form
$nama_perangkat = $_POST['nama_perangkat'];
// Mulai transaksi
mysql_query("START TRANSACTION", $conn);

// Insert data ke tabel headers
$insertHeaderQuery = sprintf(
    "INSERT INTO tipe_perawatan (nama_perangkat) VALUES ('%s')",
    mysql_real_escape_string($nama_perangkat)
);

$result = mysql_query($insertHeaderQuery, $conn);
if (!$result) {
    mysql_query("ROLLBACK", $conn);
    die("Error inserting header: " . mysql_error());
}

// Ambil ID header yang baru saja disimpan
$header_id = mysql_insert_id();

// Insert data items yang terkait dengan header_id
for ($i = 0; $i < count($_POST['nama_perawatan']); $i++) {
    $nama_perawatan = $_POST['nama_perawatan'][$i];
    

    $insertItemQuery = sprintf(
        "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan ) VALUES (%d, '%s')",
        $header_id,
        mysql_real_escape_string($nama_perawatan)
       
    );

    $result = mysql_query($insertItemQuery, $conn);
    if (!$result) {
        mysql_query("ROLLBACK", $conn);
        die("Error inserting item: " . mysql_error());
        echo mysql_error();
    }
}

if($result){
    header('location:../../user.php?menu=perawatan&stt= Simpan Berhasil');}
else{
    echo "transaksi gagal";
}
// Commit transaksi jika semua insert berhasil
mysql_query("COMMIT", $conn);
echo "Order saved successfully!";



// Tutup koneksi
mysql_close($conn);
?>
