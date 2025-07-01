<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php");
    exit;
}

// Data dummy untuk pelacakan
$trackingInfo = [
    'order_id' => 'RC000123456326266',
    'status' => 'Dalam Perjalanan',
    'estimated_delivery' => '10 Juni 2025',
    'shipping_service' => 'J&T Express',
    'location_awal' => 'Pasuruan, Indonesia',
    'location_akhir' => 'Jakarta, Indonesia',
    'history' => [
        ['date' => '2025-05-20', 'event' => 'Pesanan Dikemas'],
        ['date' => '2025-05-21', 'event' => 'Pesanan Dikirim'],
        ['date' => '2025-05-21', 'event' => 'Diterima Gudang'],
        ['date' => '2025-05-24', 'event' => 'Dalam Pengiriman'],
        ['date' => '2025-05-25', 'event' => 'Dalam Perjalanan ke Lokasi'],
    ],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            margin-left: 10px;
            margin-right: 10px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            margin-top: -30px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .status h2 {
            font-size: 1.5rem;
            color: #007BFF;
        }
        .status p {
            color: #666;
        }
        .history {
            margin-top: 20px;
        }
        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .history-item:last-child {
            border-bottom: none;
        }
        .history-item p {
            margin: 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'headerlacakpesanan.php'; ?>
    <div class="container">
        <h1>Lacak Pesanan</h1>
        <div class="status">
            <div>
                <h2>Status: <?php echo htmlspecialchars($trackingInfo['status']); ?></h2>
                <p>ID Pesanan: <?php echo htmlspecialchars($trackingInfo['order_id']); ?></p>
                <p>Jasa Pengiriman: <?php echo htmlspecialchars($trackingInfo['shipping_service']); ?></p>
                <p>Lokasi Pengirim: <?php echo htmlspecialchars($trackingInfo['location_awal']); ?></p>
                <p>Lokasi Penerima: <?php echo htmlspecialchars($trackingInfo['location_akhir']); ?></p><br>
                <p>Estimasi Sampai: <?php echo htmlspecialchars($trackingInfo['estimated_delivery']); ?></p>
            </div>
        </div>

        <div class="history">
            <h3>Riwayat Pengiriman</h3>
            <?php foreach ($trackingInfo['history'] as $event): ?>
                <div class="history-item">
                    <p><?php echo htmlspecialchars($event['date']); ?></p>
                    <p><?php echo htmlspecialchars($event['event']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="footer">
            <p>&copy; 2025 Racing Claash. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>