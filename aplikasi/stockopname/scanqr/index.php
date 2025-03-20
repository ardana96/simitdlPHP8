<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

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
            width: 300px;
            height: 300px;
            border: 3px solid blue;
            object-fit: cover;
        }
        canvas {
            display: none;
        }

        /* ✅ Kotak Siku Panduan */
        .scan-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            transform: translate(-50%, -50%);
            border: 2px dashed white;
        }
        .corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 4px solid green;
        }
        .corner.top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
        .corner.top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
        .corner.bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
        .corner.bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

    </style>
</head>
<body>

    <h2>Scan QR Code</h2>

    <div class="scanner-container">
        <video id="preview" autoplay playsinline></video>
        <canvas id="canvas"></canvas>

        <!-- ✅ Kotak Siku Panduan -->
        <div class="scan-box">
            <div class="corner top-left"></div>
            <div class="corner top-right"></div>
            <div class="corner bottom-left"></div>
            <div class="corner bottom-right"></div>
        </div>
    </div>

    <br><br>

    <div class="scanner-container">
        <form action="user.php?menu=updatestockopscan" method="POST">
            <input type="text" name="nomor" id="nomor" readonly required>
            <button type="submit" class="btn btn-primary">Submit QR Code</button>
        </form>
    </div>

    <audio id="scanSound">
        <source src="assets/beep.mp3" type="audio/mp3">
    </audio>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            startScanner();
        });

        async function startScanner() {
            try {
                const video = document.getElementById('preview');
                const canvasElement = document.getElementById('canvas');
                const canvas = canvasElement.getContext("2d");

                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                video.srcObject = stream;

                function scanQRCode() {
                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        canvasElement.width = video.videoWidth;
                        canvasElement.height = video.videoHeight;
                        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                        
                        const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: "dontInvert",
                        });

                        if (code) {
                            if (document.getElementById('nomor').value !== code.data) {
                                document.getElementById('nomor').value = code.data;
                                document.getElementById("scanSound").play();
                            }
                        }
                    }
                    requestAnimationFrame(scanQRCode);
                }

                requestAnimationFrame(scanQRCode);
            } catch (error) {
                alert("Gagal mengakses kamera: " + error.message);
                console.error(error);
            }
        }
    </script>

</body>
</html>
