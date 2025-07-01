<?php
session_start();

// Function to read data from CSV
function readCSV($filename)
{
    $data = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        fgetcsv($handle); // Read header
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = $row; // Store each row as an array
        }
        fclose($handle);
    }
    return $data;
}

// Check if user is logged in
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit;
}

// Get user data
$users = readCSV('data/datapengguna.csv');
$currentUser = null;

foreach ($users as $user) {
    if ($user[0] == $_SESSION['id_pengguna']['id_pengguna']) {
        $currentUser = $user;
        break;
    }
}

// Get user address
$alamat = $currentUser ? $currentUser[6] : 'Alamat tidak ditemukan';

// Get parameters from URL
$id_produk = isset($_GET['id_produk']) ? $_GET['id_produk'] : null;
$varian_warna = isset($_GET['warna']) ? $_GET['warna'] : null;
$varian_ukuran = isset($_GET['ukuran']) ? $_GET['ukuran'] : null;

// Get product data from CSV
$produk = readCSV('data/dataproduk.csv');
$selectedProduct = null;

foreach ($produk as $item) {
    if ($item[0] == $id_produk && $item[3] == $varian_warna && $item[5] == $varian_ukuran) {
        $selectedProduct = $item;
        break;
    }
}

// Dummy shipping options
$shippingOptions = [
    'J&T Express' => 20000,
    'JNE Express' => 16000,
    'Sicepat Regular' => 18000,
    'SPX Express' => 15000,
];

// Initialize shipping cost and total
$shippingCost = 0;
$total_bayar = $selectedProduct ? (int)$selectedProduct[7] + $shippingCost : 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
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

        .alamat,
        .produk,
        .rincian,
        .footer {
            background: #f1f1f1;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .produk {
            display: flex;
        }

        .produk img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            margin-right: 10px;
        }

        .produk-details {
            flex-grow: 1;
        }

        .shipping-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: grey;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: calc(100% - 20px);
            margin: 5px 0;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .shipping-button:hover {
            background-color: #BF3131;
        }

        .selected {
            background-color: #BF3131 !important;
        }

        .totalharga {
            text-align: center;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
        }

        .button {
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #BF3131;
        }
    </style>
</head>

<body>
    <?php include 'headerdatapesanan.php' ?>
    <div class="container">
        <h2>Data Pesanan</h2>
        <div class="alamat">
            <strong>Alamat Pengiriman:</strong>
            <p><?php echo htmlspecialchars($alamat); ?></p>
        </div>

        <?php if ($selectedProduct): ?>
            <div class="produk">
                <img src="img/<?php echo htmlspecialchars($selectedProduct[4]); ?>" alt="<?php echo htmlspecialchars($selectedProduct[1]); ?>">
                <div class="produk-details">
                    <strong><?php echo htmlspecialchars($selectedProduct[1]); ?></strong>
                    <p>Warna: <?php echo htmlspecialchars($selectedProduct[3]); ?> Ukuran: <?php echo htmlspecialchars($selectedProduct[5]); ?></p>
                    <p>Harga: Rp <?php echo number_format($selectedProduct[7], 0, ',', '.'); ?></p>
                </div>
            </div>

            <div class="rincian">
                <p><strong>Pilih Jasa Pengiriman:</strong></p>
                <?php foreach ($shippingOptions as $option => $cost): ?>
                    <button class="shipping-button" onclick="updateTotal('<?php echo htmlspecialchars($option); ?>', <?php echo $cost; ?>, this)">
                        <?php echo htmlspecialchars($option); ?> - Rp <?php echo number_format($cost, 0, ',', '.'); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="rincian">
                <p><strong>Pilih Metode Pembayaran:</strong></p>
                <button class="shipping-button" onclick="selectPaymentMethod('Bayar Ditempat')">
                    Bayar Ditempat
                </button>
            </div>

            <div class="totalharga">
                <div class="total">Total yang Harus Dibayar: <br> Rp<span id="totalAmount"><?php echo number_format($total_bayar, 0, ',', '.'); ?></span></div>
                <form method="POST" action="your_payment_processing_script.php">
                <input type="hidden" name="shipping_method" id="hiddenShippingMethod" value="">
                <input type="hidden" name="payment_method" id="hiddenPaymentMethod" value="">
            </form>
            </div>
        <?php else: ?>
            <p>Produk tidak ditemukan.</p>
        <?php endif; ?>
    </div>
    <br><br><br><br>
    <?php include 'footerdatapesanan.php'; ?>
    
    <script>
        function updateTotal(option, cost, button) {
            const productPrice = <?php echo (int)$selectedProduct ? (int)$selectedProduct[7] : 0; ?>;
            const totalAmount = productPrice + cost;
            document.getElementById('totalAmount').innerText = totalAmount.toLocaleString('id-ID');
            document.getElementById('hiddenShippingMethod').value = option; // Update hidden input for shipping method

            // Remove 'selected' class from all buttons and add it to the clicked button
            const buttons = document.querySelectorAll('.shipping-button');
            buttons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        }

        function selectPaymentMethod(method) {
            document.getElementById('hiddenPaymentMethod').value = method; // Update hidden input for payment method
        }
    </script>

</body>

</html>