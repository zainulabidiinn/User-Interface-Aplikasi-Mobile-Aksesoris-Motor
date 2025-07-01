<?php
session_start();

$csvFile = 'data/datapesanan.csv';
$pesanan = [];
if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    $header = fgetcsv($handle);
    while (($data = fgetcsv($handle)) !== FALSE) {
        $pesanan[] = array_combine($header, $data);
    }
    fclose($handle);
}

$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$filtered_pesanan = $pesanan;
if ($status_filter) {
    $filtered_pesanan = array_filter($pesanan, function ($item) use ($status_filter) {
        return $item['status_pesanan'] === $status_filter;
    });
}

$unique_status = array_unique(array_column($pesanan, 'status_pesanan'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'] ?? '';
    $action = $_POST['action'] ?? '';

    $allOrders = [];
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            $allOrders[] = array_combine($header, $data);
        }
        fclose($handle);
    }

    $found = false;
    foreach ($allOrders as &$item) {
        if ($item['id_pesanan'] === $orderId) {
            if ($action === 'cancel') {
                $item['status_pesanan'] = 'Dibatalkan';
            } elseif ($action === 'accept') {
                $item['status_pesanan'] = 'Selesai';
            }
            $found = true;
            break;
        }
    }
    unset($item);

    if ($found) {
        $handle = fopen($csvFile, 'w');
        fputcsv($handle, $header);
        foreach ($allOrders as $item) {
            fputcsv($handle, $item);
        }
        fclose($handle);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Order ID not found']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f2f2f2;
        }

        .container-pesanan {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            margin: 40px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: -15px;
        }

        .filter {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: -20px;
        }

        .filter label {
            margin-right: 10px;
            font-weight: 600;
            font-size: 18px;
        }

        select {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .order-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: -15px;
        }

        .order-item {
            display: flex;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            flex-direction: column;
            align-items: center;
            background-color: #fafafa;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .order-item img {
            max-width: 120px;
            border-radius: 5px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .order-details {
            text-align: center;
            margin-bottom: 10px;
        }

        .order-details h3 {
            margin: 0 0 8px 0;
            font-size: 20px;
            color: #333;
        }

        .order-details p {
            margin: 4px 0;
            color: #666;
        }

        .order-total {
            font-weight: bold;
            color: #C70000;
            font-size: 18px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .button-group button {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .batalkan {
            background-color: #ff4c4c;
            color: white;
        }

        .batalkan:hover {
            background-color: #e03e3e;
        }

        .bayar {
            background-color: #4CAF50;
            color: white;
        }

        .bayar:hover {
            background-color: #448c40;
        }

        .lacak {
            background-color: #2196F3;
            color: white;
        }

        .lacak:hover {
            background-color: #1976d2;
        }

        .ajukan {
            background-color: #7D0A0A;
            color: white;
        }

        .ajukan:hover {
            background-color: #BF3131;
        }

        .ulasan {
            background-color: #FFA500;
            color: white;
        }

        .ulasan:hover {
            background-color: #e68a00;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 80px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px 40px;
            border: 1px solid #888;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            font-size: 16px;
            position: relative;
            margin-left: 10px;
            margin-right: 10px;
        }

        .close {
            color: #aaa;
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .modal-content button {
            margin-top: 20px;
            padding: 10px 25px;
            font-weight: 700;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include 'headerpesanan.php'; ?>
    <div class="container-pesanan">
        <h2>Daftar Pesanan</h2>

        <div class="filter">
            <form method="GET" id="filterForm">
                <label for="status">Filter berdasarkan status:</label>
                <select name="status" id="status" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua</option>
                    <?php foreach ($unique_status as $status): ?>
                        <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($status_filter == $status) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($status); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="order-list">
            <?php if (count($filtered_pesanan) > 0): ?>
                <?php foreach ($filtered_pesanan as $item): ?>
                    <div class="order-item">
                        <img src="img/<?php echo htmlspecialchars($item['foto_varian']); ?>" alt="Foto Produk" />
                        <div class="order-details">
                            <h3><?php echo htmlspecialchars($item['nama_produk']); ?></h3>
                            <p>Varian Warna: <?php echo htmlspecialchars($item['varian_warna']); ?></p>
                            <p>Ukuran: <?php echo htmlspecialchars($item['varian_ukuran']); ?></p>
                            <p class="order-total">Total Pembayaran: Rp<?php echo htmlspecialchars($item['total_pembayaran']); ?></p>
                            <p>Status: <strong><?php echo htmlspecialchars($item['status_pesanan']); ?></strong></p>
                        </div>

                        <div class="button-group">
                            <?php if ($item['status_pesanan'] === 'Belum Dibayar'): ?>
                                <button class="bayar" onclick="window.location.href='pembayaran.php'">Bayar Sekarang</button>
                                <button class="batalkan" onclick="showCancelModal('<?php echo htmlspecialchars($item['id_pesanan']); ?>')">Batalkan</button>
                            <?php elseif ($item['status_pesanan'] === 'Dikemas'): ?>
                                <button class="batalkan" onclick="showCancelModal('<?php echo htmlspecialchars($item['id_pesanan']); ?>')">Batalkan</button>
                            <?php elseif ($item['status_pesanan'] === 'Dikirim'): ?>
                                <button class="lacak" onclick="window.location.href='lacakpesanan.php'">Lacak Pesanan</button>
                                <button class="bayar" onclick="showAcceptModal('<?php echo htmlspecialchars($item['id_pesanan']); ?>')">Diterima</button>
                                <button class="ajukan" onclick="window.location.href='pengembalian.php'">Ajukan Pengembalian</button>
                            <?php elseif ($item['status_pesanan'] === 'Selesai'): ?>
                                <button class="ulasan" onclick="window.location.href='ulasan.php'">Beri Ulasan</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada pesanan yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Batalkan -->
    <div id="cancelModal" class="modal" tabindex="-1">
        <div class="modal-content">
            <span class="close" onclick="closeModal('cancelModal')">&times;</span>
            <p>Anda yakin ingin membatalkan pesanan ini?</p>
            <button onclick="confirmCancellation()">Ya, Batalkan</button>
        </div>
    </div>

    <!-- Modal Terima -->
    <div id="acceptModal" class="modal" tabindex="-1">
        <div class="modal-content">
            <span class="close" onclick="closeModal('acceptModal')">&times;</span>
            <p>Pesanan sudah diterima?</p>
            <button onclick="confirmAcceptance()">Ya, Sudah Diterima</button>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        function showCancelModal(orderId) {
            currentOrderId = orderId;
            document.getElementById('cancelModal').style.display = 'block';
        }

        function showAcceptModal(orderId) {
            currentOrderId = orderId;
            document.getElementById('acceptModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            currentOrderId = null;
        }

        function confirmCancellation() {
            if (!currentOrderId) return;
            updateOrderStatus(currentOrderId, 'cancel');
        }

        function confirmAcceptance() {
            if (!currentOrderId) return;
            updateOrderStatus(currentOrderId, 'accept');
        }

        function updateOrderStatus(orderId, action) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                closeModal(action === 'cancel' ? 'cancelModal' : 'acceptModal');
                                location.reload();
                            } else {
                                alert('Gagal memperbarui status pesanan: ' + (response.message || ''));
                            }
                        } catch (e) {
                            alert('Response server tidak valid.');
                        }
                    } else {
                        alert('Terjadi kesalahan saat memperbarui status pesanan.');
                    }
                }
            };
            xhr.send('orderId=' + encodeURIComponent(orderId) + '&action=' + encodeURIComponent(action));
        }

        window.onclick = function(event) {
            const cancelModal = document.getElementById('cancelModal');
            const acceptModal = document.getElementById('acceptModal');
            if (event.target === cancelModal) closeModal('cancelModal');
            if (event.target === acceptModal) closeModal('acceptModal');
        };

        window.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                const cancelModal = document.getElementById('cancelModal');
                const acceptModal = document.getElementById('acceptModal');
                if (cancelModal.style.display === 'block') closeModal('cancelModal');
                if (acceptModal.style.display === 'block') closeModal('acceptModal');
            }
        });
    </script>

    <br /><br /><br /><br />
    <?php include 'footerberanda.php'; ?>
</body>

</html>