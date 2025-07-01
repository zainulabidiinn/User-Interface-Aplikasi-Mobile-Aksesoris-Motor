<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Keranjang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="style.css"> <!-- Gaya CSS Anda -->
    <style>
        body {
            margin: 0;
        }


        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #C70000;
            border-top: 1px solid #ddd;
            position: fixed;
            /* Mengunci footer di bawah */
            left: 0;
            right: 0;
            bottom: 0;
            /* Posisi footer di bawah */
            z-index: 1000;
            /* Agar footer selalu di atas */
        }

        .icon {
            cursor: pointer;
            font-size: 24px;
            /* Ukuran ikon */
            color: white;
            /* Warna ikon */
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .icon:hover {
            color: #F3EDC8;
            /* Warna saat hover */
        }

        .checkout-button {
            background-color: #F3EDC8;
            /* Warna hijau */
            padding: 10px 20px;
            color: #7D0A0A;
            /* Warna teks putih */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            /* Ukuran font lebih besar */
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Efek transisi */
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .checkout-button:hover {
            background-color: #EAD196;
            /* Warna hijau lebih gelap saat hover */
            transform: translateY(-2px);
            /* Efek angkat saat hover */
        }
        .teks {
            color: white;
        }
    </style>
</head>

<body>

    <div class="footer">
        <div class="teks"> Total Harga Produk:<br><span id="totalChecked">Rp0</span></div>
        <a href="datapesanankeranjang.php" class="checkout-button">Checkout</a> 
    </div>

    <script>
        function updateTotal(checkbox, price, quantity) {
            const totalElement = document.getElementById('totalChecked');
            let currentTotal = parseInt(totalElement.textContent.replace(/[^0-9]/g, '')) || 0;
            const itemTotal = price * quantity;

            if (checkbox.checked) {
                currentTotal += itemTotal;
            } else {
                currentTotal -= itemTotal;
            }
            totalElement.textContent = 'Rp ' + currentTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function changeQuantity(button, change, price) {
            const quantityElement = button.parentElement.querySelector('.cart-item-quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            currentQuantity += change;

            if (currentQuantity < 0) {
                currentQuantity = 0;
            }

            quantityElement.textContent = currentQuantity;

            const checkbox = button.parentElement.parentElement.querySelector('.cart-checkbox');
            if (checkbox.checked) {
                const itemTotal = price * change;
                const totalElement = document.getElementById('totalChecked');
                let currentTotal = parseInt(totalElement.textContent.replace(/[^0-9]/g, '')) || 0;
                currentTotal += itemTotal;
                totalElement.textContent = 'Rp ' + currentTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
        }
    </script>
</body>

</html>