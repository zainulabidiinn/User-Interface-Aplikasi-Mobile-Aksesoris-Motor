<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Detail Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            background-color: #C70000;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .icon {
            cursor: pointer;
            font-size: 24px;
            color: white;
            text-decoration: none;
        }

        .icon:hover {
            color: #F3EDC8;
        }

        .btn-beli {
            background-color: #F3EDC8;
            color: #C70000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-beli:hover {
            background-color: #D1C1A0;
        }

        .modal {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            border-top: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            transform: translateY(100%);
            z-index: 1001;
        }

        .modal.active {
            display: block;
            transform: translateY(0);
        }

        .variants {
            display: flex;
            overflow-x: auto;
            padding: 10px 0;
            gap: 10px;
            margin-bottom: 10px;
        }

        .variant-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border: 2px solid transparent;
            transition: border-color 0.3s;
            flex: 0 0 auto;
            width: 100px;
            margin-bottom: 5px;
        }

        .variant-item.selected {
            border-color: #007BFF;
        }

        .variant-item img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .variant-name {
            margin-top: 5px;
            text-align: center;
        }

        .alert {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #C70000;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1002;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="footer">
        <a href="chat.php" class="icon" title="Chat">
            <i class="fas fa-comment-dots"></i>
        </a>
        <a href="javascript:void(0);" class="icon" title="Tambah ke Keranjang" onclick="showModal()">
            <i class="fas fa-cart-plus"></i>
        </a>
        <button class="btn-beli" onclick="showBeli()">Beli Sekarang</button>
    </div>

    <div class="modal" id="variantModal">
        <span class="close-modal" style="float: right; color: red; font-size: 30px; cursor: pointer; margin-top:-10px;" onclick="closeModal()">X</span>
        <div class="modal-header">
            <div class="teks-pilih" style="font-weight: bold;"> Pilih Varian </div>
        </div>
        <div class="modal-content" id="variantContent"></div>
        <button class="btn-beli" id="cartButton" onclick="addToCart()">Tambahkan ke Keranjang</button>
        <button class="btn-beli" id="orderButton" style="display: none;" onclick="placeOrder()">Buat Pesanan</button>
    </div>

    <div class="alert" id="alertMessage">Produk sudah berhasil ditambahkan ke keranjang belanja Anda.</div>

    <script>
        let selectedWarna = null;
        let selectedUkuran = null;
        let quantity = 1; // Inisialisasi jumlah produk

        function getProductId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id_produk'); // Assuming 'id_produk' is the parameter name
        }

        function showModal() {
            const modal = document.getElementById('variantModal');
            const variantContent = document.getElementById('variantContent');
            const productId = getProductId();

            const variants = <?php
                                $data = [];
                                if (($handle = fopen("data/dataproduk.csv", "r")) !== FALSE) {
                                    fgetcsv($handle);
                                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        $data[$row[0]]['varian_warna'][$row[3]] = $row[4];
                                        $data[$row[0]]['varian_ukuran'][$row[5]] = true;
                                    }
                                    fclose($handle);
                                }
                                echo json_encode($data);
                                ?>;

            const productVariants = variants[productId] || {
                varian_warna: {},
                varian_ukuran: {}
            };

            let variantWarnaHTML = '';
            for (const [warna, foto] of Object.entries(productVariants.varian_warna)) {
                variantWarnaHTML += `
            <div class="variant-item" onclick="selectWarna('${warna}', this)">
                <img src="img/${foto}" alt="${warna}">
                <div class="variant-name">${warna}</div>
            </div>
            `;
            }

            const uniqueUkuran = Object.keys(productVariants.varian_ukuran);
            const ukuranHTML = uniqueUkuran.map(ukuran => `
        <div class="variant-item" onclick="selectUkuran('${ukuran}', this)">
            <div class="variant-name">${ukuran}</div>
        </div>
        `).join('');

            variantContent.innerHTML = `
        <div class="variants">${variantWarnaHTML}</div>
        <div>
            <strong>Ukuran:</strong>
            <div class="variants">${ukuranHTML}</div>
        </div>
        <div>
            <strong>Jumlah:</strong>
            <button onclick="changeQuantity(-1)">-</button>
            <span id="quantityDisplay">${quantity}</span>
            <button onclick="changeQuantity(1)">+</button>
        </div><br>
        `;

            modal.classList.add('active');
            document.getElementById('cartButton').style.display = 'block'; // Show cart button
            document.getElementById('orderButton').style.display = 'none'; // Hide order button
        }

        function changeQuantity(amount) {
            quantity += amount;
            if (quantity < 1) quantity = 1; // Minimal jumlah 1
            document.getElementById('quantityDisplay').textContent = quantity;
        }

        function addToCart() {
            const alertMessage = document.getElementById('alertMessage');
            alertMessage.style.display = 'block';

            // Close modal
            closeModal();

            // Hide alert after 3 seconds
            setTimeout(() => {
                alertMessage.style.display = 'none';
            }, 3000);
        }

        function showBeli() {
            const modal = document.getElementById('variantModal');
            const variantContent = document.getElementById('variantContent');
            const productId = getProductId();

            const variants = <?php
                                $data = [];
                                if (($handle = fopen("data/dataproduk.csv", "r")) !== FALSE) {
                                    fgetcsv($handle);
                                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        $data[$row[0]]['varian_warna'][$row[3]] = $row[4];
                                        $data[$row[0]]['varian_ukuran'][$row[5]] = true;
                                    }
                                    fclose($handle);
                                }
                                echo json_encode($data);
                                ?>;

            const productVariants = variants[productId] || {
                varian_warna: {},
                varian_ukuran: {}
            };

            let variantWarnaHTML = '';
            for (const [warna, foto] of Object.entries(productVariants.varian_warna)) {
                variantWarnaHTML += `
            <div class="variant-item" onclick="selectWarna('${warna}', this)">
                <img src="img/${foto}" alt="${warna}">
                <div class="variant-name">${warna}</div>
            </div>
            `;
            }

            const uniqueUkuran = Object.keys(productVariants.varian_ukuran);
            const ukuranHTML = uniqueUkuran.map(ukuran => `
        <div class="variant-item" onclick="selectUkuran('${ukuran}', this)">
            <div class="variant-name">${ukuran}</div>
        </div>
        `).join('');

            variantContent.innerHTML = `
        <div class="variants">${variantWarnaHTML}</div>
        <div>
            <strong>Ukuran:</strong>
            <div class="variants">${ukuranHTML}</div>
        </div>
        <div>
            <strong>Jumlah: </strong>
            <button onclick="changeQuantity(-1)">-</button>
            <span id="quantityDisplay">${quantity}</span>
            <button onclick="changeQuantity(1)">+</button>
        </div><br>
        `;

            modal.classList.add('active');
            document.getElementById('cartButton').style.display = 'none'; // Hide cart button
            document.getElementById('orderButton').style.display = 'block'; // Show order button
        }

        function placeOrder() {
            const productId = getProductId();
            const redirectUrl = `datapesanan.php?id_produk=${productId}&warna=${selectedWarna}&ukuran=${selectedUkuran}&jumlah=${quantity}`;
            window.location.href = redirectUrl;
        }

        function selectWarna(warna, element) {
            selectedWarna = warna;
            const warnaItems = document.querySelectorAll('.variant-item');
            warnaItems.forEach(item => {
                if (item.querySelector('.variant-name').textContent === warna) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        }

        function selectUkuran(ukuran, element) {
            selectedUkuran = ukuran;
            const ukuranItems = document.querySelectorAll('.variant-item');
            ukuranItems.forEach(item => {
                if (item.querySelector('.variant-name').textContent === ukuran) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });

            const warnaItems = document.querySelectorAll('.variant-item');
            warnaItems.forEach(item => {
                if (item.querySelector('.variant-name').textContent === selectedWarna) {
                    item.classList.add('selected');
                }
            });
        }

        function closeModal() {
            const modal = document.getElementById('variantModal');
            modal.classList.remove('active');
        }
    </script>

</body>

</html>