<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h1 {
            text-align: center;
            color: #7D0A0A;
            margin-bottom: -5px;
        }

        .cart-item {
            display: flex;
            background-color: #fafafa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            align-items: center;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 80px;
            height: auto;
            border-radius: 5px;
            margin-right: 15px;
        }

        .cart-item-details {
            flex-grow: 1; /* Menggunakan flex-grow untuk memanfaatkan ruang */
        }

        .cart-item-name {
            font-weight: bold;
            font-size: 16px;
        }

        .cart-item-varian {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px; /* Ruang antara varian dan harga */
        }

        .cart-item-price {
            color: #C70000;
            font-weight: bold;
            font-size: 18px;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        .cart-button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cart-button:hover {
            background-color: #0056b3;
        }

        .cart-checkbox {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'headerkeranjang.php'; ?>
    <div class="cart-container">
        <h1>Keranjang Belanja</h1>
        <?php
        $total_checked_amount = 0;

        if (($handle = fopen("data/datakeranjang.csv", "r")) !== FALSE) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $nama_produk = $data[1];
                $foto_varian = $data[4];
                $varian_warna = $data[3];
                $varian_ukuran = $data[5];
                $jumlah_produk = (int)$data[6];
                $harga_produk = (int)$data[7];

                $formatted_price = number_format($harga_produk, 0, ',', '.');

                echo '<div class="cart-item">';
                echo '<input type="checkbox" class="cart-checkbox" onchange="updateTotal(this, ' . $harga_produk . ', ' . $jumlah_produk . ')">';
                echo '<img src="img/' . htmlspecialchars($foto_varian) . '" alt="' . htmlspecialchars($nama_produk) . '">';
                echo '<div class="cart-item-details">';
                echo '<div class="cart-item-name">' . htmlspecialchars($nama_produk) . '</div>';
                echo '<div class="cart-item-varian">' . htmlspecialchars($varian_warna) . ' - ' . htmlspecialchars($varian_ukuran) . '</div>';
                echo '<div class="cart-item-price">Rp ' . $formatted_price . '</div>';
                echo '</div>'; // Tutup div cart-item-details
                echo '<div class="cart-item-controls">';
                echo '<button class="cart-button" onclick="changeQuantity(this, -1, ' . $harga_produk . ')">-</button>';
                echo '<div class="cart-item-quantity">' . $jumlah_produk . '</div>';
                echo '<button class="cart-button" onclick="changeQuantity(this, 1, ' . $harga_produk . ')">+</button>';
                echo '</div>';
                echo '</div>';
            }
            fclose($handle);
        } else {
            echo '<div class="cart-item">Tidak ada produk dalam keranjang.</div>';
        }
        ?>
    </div>

    <br><br><br><br>
    <?php include 'footerkeranjang.php'; ?> 
</body>
</html>