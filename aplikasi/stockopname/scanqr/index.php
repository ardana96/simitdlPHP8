<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <style>
         body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .scanner-container {
            position: relative;
            display: inline-block;
        }
        video {
            width: 300px;  /* 🔹 Ubah ke persegi */
            height: 300px; /* 🔹 Ubah ke persegi */
            border: 3px solid blue;
            object-fit: cover; /* 🔹 Pastikan proporsi tetap */
        }


        .scan-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            transform: translate(-50%, -50%);
            
            display: none;
            justify-content: center;
            align-items: center;
        }
        /* Pastikan scanBox muncul dengan transisi */
        .scan-box.active {
            display: flex;
        }

        /* Sudut Siku */
        .scan-box .corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 5px solid green;
        }

        /* Sudut Kiri Atas */
        .scan-box .corner.top-left {
            top: -3px;
            left: -3px;
            border-right: none;
            border-bottom: none;
        }

        /* Sudut Kanan Atas */
        .scan-box .corner.top-right {
            top: -3px;
            right: -3px;
            border-left: none;
            border-bottom: none;
        }

        /* Sudut Kiri Bawah */
        .scan-box .corner.bottom-left {
            bottom: -3px;
            left: -3px;
            border-right: none;
            border-top: none;
        }

        /* Sudut Kanan Bawah */
        .scan-box .corner.bottom-right {
            bottom: -3px;
            right: -3px;
            border-left: none;
            border-top: none;
        }

    </style>
</head>
<body>

    <h2>Scan QR Code</h2>

    <div class="scanner-container">
        <video id="preview"></video>
        <div class="scan-box" id="scanBox">
            <div class="corner top-left"></div>
            <div class="corner top-right"></div>
            <div class="corner bottom-left"></div>
            <div class="corner bottom-right"></div>

        </div> 
        <!-- <br>
        <button class="btn btn-primary" onclick="startScanner()">Mulai Scan</button>
        <br> -->
    
    </div>

        <br>
        <br>
        <br>
    <div class="scanner-container">
        <form action="user.php?menu=updatestockopscan" method="POST">
            <input type="text" name="nomor" id="nomor" readonly required>
            <button type="submit" class="btn btn-primary" >Submit QR Code</button>
        </form>
    </div>

    <audio id="scanSound">
        <source src="assets/beep.mp3" type="audio/mp3">
    </audio>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            startScanner(); // 🚀 Otomatis aktifkan kamera saat halaman terbuka
        });

        let scanner;

        async function startScanner() {
            try {
                let videoElement = document.getElementById('preview');
                let scanBox = document.getElementById("scanBox");

                // **🔹 1. Minta akses kamera**
                let stream = await navigator.mediaDevices.getUserMedia({ video: true });

                // **🔹 2. Tampilkan scanBox jika kamera berhasil diakses**
                scanBox.classList.add("active");

                scanner = new Instascan.Scanner({ video: videoElement });

                scanner.addListener('scan', function(content) {
                    document.getElementById('nomor').value = content;
                    let sound = document.getElementById("scanSound");
                    sound.play();
                });

                // **🔹 3. Pilih Kamera & Perbaiki Mirroring**
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 1) {
                        scanner.start(cameras[1]);
                        videoElement.style.transform = "none"; // 🚀 Hilangkan mirroring untuk kamera belakang
                    } else if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                        videoElement.style.transform = "scaleX(-1)"; // 🔄 Mirror untuk kamera depan
                    } else {
                        alert("Tidak ada kamera yang ditemukan!");
                        scanBox.classList.remove("active"); // 🚨 Sembunyikan scanBox jika tidak ada kamera
                    }
                }).catch(function (e) {
                    console.error("Gagal mengakses kamera:", e);
                    scanBox.classList.remove("active"); // 🚨 Sembunyikan scanBox jika gagal
                });

            } catch (error) {
                alert("Gagal mengakses kamera: " + error.message);
                console.error(error);
                document.getElementById("scanBox").classList.remove("active"); // 🚨 Sembunyikan scanBox jika error
            }
        }
    </script>


</body>
</html>
