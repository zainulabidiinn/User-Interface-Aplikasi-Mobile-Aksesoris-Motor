<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            /* Font default */
        }

        .catalog-container {
            display: flex;
            /* Mengatur katalog dalam baris */
            flex-wrap: wrap;
            /* Memungkinkan katalog melipat ke baris baru */
            justify-content: space-between;
            /* Jarak antar produk */
            gap: 20px;
            /* Jarak antar produk */
            padding: 20px;
            /* Ruang di dalam kontainer */
        }

        .product {
            flex: 0 1 calc(50% - 10px);
            /* Setiap produk mengambil 50% lebar kontainer */
            background-color: #f9f9f9;
            /* Warna latar belakang produk */
            border: 1px solid #ddd;
            /* Garis batas */
            border-radius: 10px;
            /* Sudut melengkung */
            text-align: left;
            /* Memusatkan teks ke kiri */
            padding: 10px;
            /* Ruang di dalam produk */
            position: relative;
            /* Untuk penempatan harga */
            box-sizing: border-box;
            /* Memastikan padding dan border termasuk dalam lebar */
            text-decoration: none;
            /* Menghapus garis bawah */
            color: inherit;
            /* Menggunakan warna teks yang diwarisi */
        }

        .product img {
            width: 100%;
            /* Mengatur lebar gambar sesuai lebar produk */
            height: auto;
            /* Tinggi otomatis untuk menjaga proporsi */
            border-radius: 10px;
            /* Sudut melengkung untuk gambar */
            margin-bottom: 10px;
            /* Jarak antara gambar dan konten lainnya */
        }

        .product-name {
            font-weight: bold;
            /* Membuat nama produk lebih tebal */
            margin: 5px 0;
            /* Jarak antara nama dan deskripsi */
            font-size: 35px;
        }

        .product-price {
            color: #C70000;
            /* Warna harga produk */
            font-size: 25px;
            /* Ukuran font untuk harga */
            font-weight: bold;
        }

        .product-sold {
            font-size: 0.9em;
            /* Ukuran font untuk produk terjual */
            color: #555;
            /* Warna teks produk terjual */
            margin-top: 10px;
            /* Jarak antara harga dan produk terjual */
        }

        .help-button {
            position: fixed;
            /* Memposisikan tombol tetap di layar */
            bottom: 70px;
            /* Jarak dari bawah */
            right: 25px;
            /* Jarak dari kanan */
            background-color: #EAD196;
            /* Warna latar belakang tombol */
            color: red;
            /* Warna teks tombol */
            border: none;
            /* Menghilangkan batas */
            border-radius: 50%;
            /* Membuat tombol bulat */
            width: 40px;
            /* Lebar tombol */
            height: 40px;
            /* Tinggi tombol */
            font-size: 20px;
            /* Ukuran font untuk tanda tanya */
            font-weight: bold;
            cursor: pointer;
            /* Kursor pointer saat hover */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            /* Bayangan tombol */
            z-index: 1000;
            /* Pastikan tombol di atas elemen lain */
            transition: background-color 0.3s;
            /* Transisi warna saat hover */
        }

        .help-button:hover {
            background-color: #7D0A0A;
            /* Warna saat hover */
        }

        @media (max-width: 600px) {
            .catalog-container {
                display: flex;
                /* Mengatur katalog dalam baris */
                flex-wrap: wrap;
                /* Memungkinkan katalog melipat ke baris baru */
                justify-content: center;
                /* Jarak antar produk */
                gap: 30px;
                /* Jarak antar produk */
                padding: 10px;
                /* Ruang di dalam kontainer */
                margin-top: 45px;
                justify-content: left;
                margin-left: 10px;
            }

            .product {
                flex: 0 1 calc(47% - 10px);
                /* Setiap produk mengambil 50% lebar kontainer */
                background-color: #f9f9f9;
                /* Warna latar belakang produk */
                border: 1px solid #ddd;
                /* Garis batas */
                border-radius: 5px;
                /* Sudut melengkung */
                text-align: left;
                /* Memusatkan teks ke kiri */
                padding: 5px;
                /* Ruang di dalam produk */
                position: relative;
                /* Untuk penempatan harga */
                box-sizing: border-box;
                margin-top: -30px;
                margin-bottom: 10px;

            }

            .product img {
                width: 100%;
                /* Mengatur lebar gambar sesuai lebar produk */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                border-radius: 5px;
                /* Sudut melengkung untuk gambar */
                margin-bottom: 5px;
                /* Jarak antara gambar dan konten lainnya */
            }

            .product-name {
                font-weight: bold;
                /* Membuat nama produk lebih tebal */
                margin: 5px 0;
                /* Jarak antara nama dan deskripsi */
                font-size: 15px;
            }

            .product-price {
                color: #C70000;
                /* Warna harga produk */
                font-size: 12px;
                /* Ukuran font untuk harga */
                font-weight: bold;
            }

            .product-sold {
                font-size: 10px;
                /* Ukuran font untuk produk terjual */
                color: #555;
                /* Warna teks produk terjual */
                margin-top: 10px;
                /* Jarak antara harga dan produk terjual */
            }
            
        }

        @media (max-width: 400px) {
            .catalog-container {
                display: flex;
                /* Mengatur katalog dalam baris */
                flex-wrap: wrap;
                /* Memungkinkan katalog melipat ke baris baru */
                justify-content: center;
                /* Jarak antar produk */
                gap: 30px;
                /* Jarak antar produk */
                padding: 10px;
                /* Ruang di dalam kontainer */
                margin-top: 45px;
                justify-content: left;
                margin-left: 10px;
            }

            .product {
                flex: 0 1 calc(47% - 10px);
                /* Setiap produk mengambil 50% lebar kontainer */
                background-color: #f9f9f9;
                /* Warna latar belakang produk */
                border: 1px solid #ddd;
                /* Garis batas */
                border-radius: 5px;
                /* Sudut melengkung */
                text-align: left;
                /* Memusatkan teks ke kiri */
                padding: 5px;
                /* Ruang di dalam produk */
                position: relative;
                /* Untuk penempatan harga */
                box-sizing: border-box;
                margin-top: -30px;
                margin-bottom: 10px;

            }

            .product img {
                width: 100%;
                /* Mengatur lebar gambar sesuai lebar produk */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                border-radius: 5px;
                /* Sudut melengkung untuk gambar */
                margin-bottom: 5px;
                /* Jarak antara gambar dan konten lainnya */
            }

            .product-name {
                font-weight: bold;
                /* Membuat nama produk lebih tebal */
                margin: 5px 0;
                /* Jarak antara nama dan deskripsi */
                font-size: 15px;
            }

            .product-price {
                color: #C70000;
                /* Warna harga produk */
                font-size: 12px;
                /* Ukuran font untuk harga */
                font-weight: bold;
            }

            .product-sold {
                font-size: 10px;
                /* Ukuran font untuk produk terjual */
                color: #555;
                /* Warna teks produk terjual */
                margin-top: 10px;
                /* Jarak antara harga dan produk terjual */
            }

        }
    </style>
</head>

<body>
    <?php include 'headerberanda.php'; ?>

    <div class="catalog-container">
        <?php
        // Mengambil query dari parameter URL
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        // Membaca file CSV produk
        if (($handle = fopen("data/dataproduk.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header
            $products = [];

            // Mengumpulkan data produk yang sesuai dengan pencarian
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (stripos($data[1], $query) !== false) { // Mencocokkan nama produk
                    $id_produk = $data[0];
                    $nama_produk = $data[1];
                    $foto_utama = $data[9];
                    $harga_produk = number_format($data[7], 0, ',', '.');
                    $produk_terjual = (int)$data[11];

                    // Menyimpan data produk
                    $products[$id_produk] = [
                        'nama_produk' => $nama_produk,
                        'foto_utama' => $foto_utama,
                        'harga_produk' => $harga_produk,
                        'total_terjual' => $produk_terjual
                    ];
                }
            }
            fclose($handle);

            // Menampilkan produk yang ditemukan
            if (count($products) > 0) {
                foreach ($products as $id_produk => $product) {
                    echo '<a href="detailproduk.php?id_produk=' . htmlspecialchars($id_produk) . '" class="product">';
                    echo '<img src="img/' . htmlspecialchars($product['foto_utama']) . '" alt="' . htmlspecialchars($product['nama_produk']) . '">';
                    echo '<div class="product-name">' . htmlspecialchars($product['nama_produk']) . '</div>';
                    echo '<div class="product-price">Rp ' . $product['harga_produk'] . '</div>';
                    echo '<div class="product-sold">Terjual: ' . $product['total_terjual'] . '</div>';
                    echo '</a>';
                }
            } else {
                echo '<div class="product">Tidak ada produk yang ditemukan.</div>';
            }
        } else {
            echo '<div class="product">Gagal membuka file produk.</div>';
        }
        ?>
    </div>
    <button class="help-button" onclick="window.location.href='chat.php'">?</button>

    <br><br><br><br><br>
    <?php include 'footerberanda.php'; ?>

</body>

</html>