<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Alamat pengembalian dummy
$alamatPengembalian = "Jl. Pasuruan Indah Gg 06 Kota Pasuruan";

// Data produk dummy (harusnya diambil dari database atau sumber data lain)
$id_produk = 1;
$varian_warna = "Warna 01";
$foto_varian = "mb1.jpg"; // Ganti dengan nama file gambar yang sesuai
$varian_ukuran = "Beat New";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        .container {
            margin-left: 10px;
            margin-right: 10px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: -30px;
        }
        h2 {
            text-align: center;
        }
        .option {
            margin-bottom: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }
        .button:hover {
            background-color: #BF3131;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'headerpengembalian.php'; ?>
    <div class="container">
        <h2>Pengembalian Produk</h2>
        <div class="option">
            <p><strong>Alamat Pengembalian:</strong></p>
            <p><?php echo htmlspecialchars($alamatPengembalian); ?></p>
            <p> [CATAT DULU ALAMATNYA] </p>
        </div>

        <div>
            <label for="jenisPengembalian" style="font-weight: bold;">Pilih Jenis Pengembalian:</label><br>
            <select id="jenisPengembalian" onchange="showForm()">
                <option value="">-- Pilih --</option>
                <option value="retur">Retur</option>
                <option value="refund">Refund</option>
            </select>
        </div>

        <div id="productInfo" class="product-info" style="display: none;">
            <h3>Informasi Produk</h3>
            <p><strong>Warna:</strong> <?php echo htmlspecialchars($varian_warna); ?></p>
            <img src="img/<?php echo htmlspecialchars($foto_varian); ?>" alt="<?php echo htmlspecialchars($varian_warna); ?>" style="width: 100px; height: auto;">
            <p><strong>Ukuran:</strong> <?php echo htmlspecialchars($varian_ukuran); ?></p>
        </div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalMessage"></p>
        </div>
    </div>

    <br><br><br><br>
    <?php include 'footerpengembalian.php'; ?>

    <script>
        function showForm() {
            const option = document.getElementById('jenisPengembalian').value;
            const productInfo = document.getElementById('productInfo');

            // Show product info only if 'retur' is selected
            productInfo.style.display = (option === 'retur') ? 'block' : 'none';
        }

        function closeModal() {
            document.getElementById('modal').style.display = "none";
        }
    </script>
</body>
</html>