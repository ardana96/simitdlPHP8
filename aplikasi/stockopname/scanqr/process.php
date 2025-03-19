<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["qrcode"])) {
        $qrCodeData = $_POST["qrcode"];

        // Simpan ke database (Opsional)
        // Koneksi ke database
        // $conn = new mysqli("localhost", "root", "", "db_qrscanner");
        // $stmt = $conn->prepare("INSERT INTO qr_codes (code, scanned_at) VALUES (?, NOW())");
        // $stmt->bind_param("s", $qrCodeData);
        // $stmt->execute();

        echo "<h2>QR Code Data:</h2>";
        echo "<p>$qrCodeData</p>";
        echo "<a href='index.php'>Kembali</a>";
    } else {
        echo "QR Code tidak ditemukan!";
    }
} else {
    echo "Invalid Request!";
}
?>
