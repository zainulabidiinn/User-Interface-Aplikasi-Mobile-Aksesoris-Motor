<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Ambil data pengguna dari session
$currentUser = $_SESSION['id_pengguna'];

// Data pembayaran (contoh)
$qris = "img/kodeqr.png"; // Ganti dengan URL QRIS yang sesuai
$kode_virtual_account = "3995005123456789"; // Ganti dengan kode virtual account yang sesuai
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: -30px;
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 8px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .button {
            display: block;
            text-align: center;
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        .button:hover {
            background-color: #BF3131;
        }
    </style>
</head>
<body>
    <?php include 'headerpembayaran.php'; ?>
    <div class="container">
        <h2>Informasi Pembayaran</h2>
        <div class="info">
            <strong>QRIS:</strong>
            <div class="qr-code">
                <img src="<?php echo htmlspecialchars($qris); ?>" alt="QRIS">
            </div>
            <p><strong>Kode Virtual Account Pembayaran:</strong> <?php echo htmlspecialchars($kode_virtual_account); ?></p>
            <p><strong>Cara Pembayaran:</strong></p>
            <p>1. Buka aplikasi e-wallet Anda.</p>
            <p>2. Pilih opsi 'Scan QR'.</p>
            <p>3. Arahkan kamera ke QRIS di atas.</p>
            <p>4. Ikuti instruksi untuk menyelesaikan pembayaran.</p>
        </div>
    </div>
    <br><br><br><br>
    <?php include 'footerpembayaran.php'; ?>
</body>
</html>