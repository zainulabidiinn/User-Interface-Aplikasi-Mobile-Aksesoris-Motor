<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            /* Font default */
        }

        .categories {
            display: flex;
            /* Mengatur kategori dalam baris */
            flex-wrap: wrap;
            /* Memungkinkan kategori melipat ke baris baru */
            justify-content: center;
            /* Memusatkan kategori secara horizontal */
            gap: 10px;
            /* Jarak antar kategori */
            margin: 20px 0;
            /* Margin atas dan bawah */

        }

        .category {
            background-color: #BF3131;
            /* Warna latar belakang kategori */
            padding: 10px;
            /* Ruang di dalam kategori */
            border-radius: 10px;
            /* Sudut melengkung */
            text-align: center;
            /* Memusatkan teks */
            flex: 1 1 calc(23% - 10px);
            /* Batas lebar kategori (4 per baris) */
            max-width: calc(23% - 10px);
            /* Maksimal lebar kategori */
            text-decoration: none;
            /* Menghapus garis bawah */
            color: inherit;
            /* Menggunakan warna teks yang diwarisi */

        }

        .category img {
            width: 100%;
            /* Mengatur lebar gambar sesuai lebar kategori */
            height: 150px;
            /* Tinggi tetap untuk gambar */
            object-fit: cover;
            /* Memastikan gambar terpotong sesuai proporsi */
            border-radius: 10px;
            /* Sudut melengkung untuk gambar */
        }

        .category-text {
            color: white;
            /* Warna teks kategori */
            font-weight: bold;
            /* Membuat teks lebih tebal */
            margin-top: 5px;
            /* Jarak antara gambar dan teks */
        }

        .banner-container {
            width: 100%;
            /* Lebar penuh */
            overflow: hidden;
            /* Menyembunyikan bagian yang keluar dari kontainer */
            position: relative;
            /* Untuk penempatan banner */
            height: 0;
            /* Tinggi diatur dengan padding */
            padding-bottom: 50%;
            /* Menjaga rasio 2:1 */
        }

        .banner-wrapper {
            display: flex;
            /* Mengatur banner dalam baris */
            transition: transform 1s ease;
            /* Efek transisi saat scroll */
            height: 100%;
            /* Tinggi penuh untuk wrapper */
            will-change: transform;
            /* Meningkatkan performa */
            position: absolute;
            /* Memungkinkan banner menutupi kontainer */
            top: 0;
            /* Posisi atas */
            left: 0;
            /* Posisi kiri */
        }

        .banner {
            flex: 0 0 100%;
            /* Setiap banner mengambil 50% lebar kontainer (2:1) */
            height: 100%;
            /* Tinggi penuh untuk banner */
            position: relative;
            /* Untuk penempatan teks */
        }

        .banner img {
            width: 100%;
            /* Mengatur lebar gambar sesuai lebar banner */
            height: 100%;
            /* Mengatur tinggi gambar sesuai tinggi banner */
            object-fit: cover;
            /* Memastikan gambar terpotong sesuai proporsi */
        }

        .navigation {
            position: absolute;
            /* Posisi navigasi */
            top: 50%;
            /* Tengah secara vertikal */
            width: 100%;
            /* Lebar penuh */
            display: flex;
            /* Mengatur navigasi dalam baris */
            justify-content: space-between;
            /* Jarak antara tombol */
            transform: translateY(-50%);
            /* Memusatkan secara vertikal */
        }

        .nav-button {
            background-color: rgba(255, 255, 255, 0.8);
            /* Warna latar belakang tombol */
            border: none;
            /* Menghilangkan batas */
            border-radius: 50%;
            /* Membuat tombol bulat */
            padding: 10px;
            /* Ruang di dalam tombol */
            cursor: pointer;
            /* Kursor pointer saat hover */
            font-size: 10px;
            /* Ukuran font untuk tombol */
            margin-left: 10px;
            margin-right: 10px;
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

        @media (max-width: 800px) {
            .categories {
                display: flex;
                /* Mengatur kategori dalam baris */
                flex-wrap: wrap;
                /* Memungkinkan kategori melipat ke baris baru */
                justify-content: center;
                /* Memusatkan kategori secara horizontal */
                gap: 5px;
                /* Jarak antar kategori */
                margin: 20px 0;
                /* Margin atas dan bawah */
            }

            .category {
                background-color: #BF3131;
                /* Warna latar belakang kategori */
                padding: 10px;
                /* Ruang di dalam kategori */
                border-radius: 10px;
                /* Sudut melengkung */
                text-align: center;
                /* Memusatkan teks */
                flex: 1 1 calc(20% - 10px);
                /* Batas lebar kategori (4 per baris) */
                max-width: calc(20% - 10px);
                /* Maksimal lebar kategori */
            }

            .category img {
                width: 100%;
                /* Mengatur lebar gambar sesuai lebar kategori */
                height: 70px;
                /* Tinggi tetap untuk gambar */
                object-fit: cover;
                /* Memastikan gambar terpotong sesuai proporsi */
                border-radius: 10px;
                /* Sudut melengkung untuk gambar */
            }

            .category-text {
                color: white;
                /* Warna teks kategori */
                font-weight: bold;
                /* Membuat teks lebih tebal */
                margin-top: 5px;
                /* Jarak antara gambar dan teks */
                font-size: 10px;
            }

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
                margin-top: 5px;
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
                /* Memastikan padding dan border termasuk dalam lebar */

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

        @media (max-width: 600px) {
            .categories {
                display: flex;
                /* Mengatur kategori dalam baris */
                flex-wrap: wrap;
                /* Memungkinkan kategori melipat ke baris baru */
                justify-content: center;
                /* Memusatkan kategori secara horizontal */
                gap: 5px;
                /* Jarak antar kategori */
                margin: 20px 0;
                /* Margin atas dan bawah */
            }

            .category {
                background-color: #BF3131;
                /* Warna latar belakang kategori */
                padding: 10px;
                /* Ruang di dalam kategori */
                border-radius: 10px;
                /* Sudut melengkung */
                text-align: center;
                /* Memusatkan teks */
                flex: 1 1 calc(20% - 10px);
                /* Batas lebar kategori (4 per baris) */
                max-width: calc(20% - 10px);
                /* Maksimal lebar kategori */
            }

            .category img {
                width: 100%;
                /* Mengatur lebar gambar sesuai lebar kategori */
                height: 70px;
                /* Tinggi tetap untuk gambar */
                object-fit: cover;
                /* Memastikan gambar terpotong sesuai proporsi */
                border-radius: 10px;
                /* Sudut melengkung untuk gambar */
            }

            .category-text {
                color: white;
                /* Warna teks kategori */
                font-weight: bold;
                /* Membuat teks lebih tebal */
                margin-top: 5px;
                /* Jarak antara gambar dan teks */
                font-size: 10px;
            }

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
                margin-top: 5px;
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
                /* Memastikan padding dan border termasuk dalam lebar */

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
            .categories {
                display: flex;
                /* Mengatur kategori dalam baris */
                flex-wrap: wrap;
                /* Memungkinkan kategori melipat ke baris baru */
                justify-content: center;
                /* Memusatkan kategori secara horizontal */
                gap: 5px;
                /* Jarak antar kategori */
                margin: 20px 0;
                /* Margin atas dan bawah */
            }

            .category {
                background-color: #BF3131;
                /* Warna latar belakang kategori */
                padding: 10px;
                /* Ruang di dalam kategori */
                border-radius: 10px;
                /* Sudut melengkung */
                text-align: center;
                /* Memusatkan teks */
                flex: 1 1 calc(20% - 10px);
                /* Batas lebar kategori (4 per baris) */
                max-width: calc(20% - 10px);
                /* Maksimal lebar kategori */
            }

            .category img {
                width: 100%;
                /* Mengatur lebar gambar sesuai lebar kategori */
                height: 50px;
                /* Tinggi tetap untuk gambar */
                object-fit: cover;
                /* Memastikan gambar terpotong sesuai proporsi */
                border-radius: 10px;
                /* Sudut melengkung untuk gambar */
            }

            .category-text {
                color: white;
                /* Warna teks kategori */
                font-weight: bold;
                /* Membuat teks lebih tebal */
                margin-top: 5px;
                /* Jarak antara gambar dan teks */
                font-size: 10px;
            }

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
                margin-top: 5px;
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
                /* Memastikan padding dan border termasuk dalam lebar */

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
    <div class="categories">
        <?php
        // Membaca file CSV dan menampilkan kategori
        if (($handle = fopen("data/datakategori.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $id_kategori = $data[0]; // Kolom id kategori
                $foto = $data[2]; // Kolom foto
                $nama = $data[1]; // Kolom nama

                // Menentukan URL berdasarkan id_kategori
                $link = "detailkategori.php?id_kategori=" . htmlspecialchars($id_kategori);

                echo '<a href="' . $link . '" class="category">';
                echo '<img src="img/' . htmlspecialchars($foto) . '" alt="' . htmlspecialchars($nama) . '">';
                echo '<div class="category-text">' . htmlspecialchars($nama) . '</div>';
                echo '</a>';
            }
            fclose($handle);
        } else {
            echo '<div class="category">Tidak ada kategori tersedia.</div>';
        }
        ?>
    </div>

    <div class="banner-container">
        <div class="banner-wrapper" id="bannerWrapper">
            <?php
            // Membaca file CSV dan menampilkan banner promosi
            if (($handle = fopen("data/datapromosi.csv", "r")) !== FALSE) {
                fgetcsv($handle); // Mengabaikan header
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $foto = $data[2]; // Kolom foto
                    echo '<div class="banner">';
                    echo '<img src="img/' . htmlspecialchars($foto) . '" alt="' . htmlspecialchars($nama) . '">';
                    echo '</div>';
                }
                fclose($handle);
            } else {
                echo '<div class="banner">Tidak ada banner promosi tersedia.</div>';
            }
            ?>
        </div>
        <div class="navigation">
            <button class="nav-button" id="prevButton">&#10094;</button>
            <button class="nav-button" id="nextButton">&#10095;</button>
        </div>
    </div>

    <script>
        const bannerWrapper = document.getElementById('bannerWrapper');
        const banners = document.querySelectorAll('.banner');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        let currentIndex = 0;
        let scrollInterval;

        function showBanner(index) {
            const offset = -index * 100; // Hitung offset untuk scroll
            bannerWrapper.style.transform = `translateX(${offset}%)`; // Scroll ke banner berikutnya
        }

        function showNextBanner() {
            currentIndex = (currentIndex + 1) % banners.length; // Menghitung index banner berikutnya
            showBanner(currentIndex);
        }

        function showPrevBanner() {
            currentIndex = (currentIndex - 1 + banners.length) % banners.length; // Menghitung index banner sebelumnya
            showBanner(currentIndex);
        }

        prevButton.addEventListener('click', showPrevBanner);
        nextButton.addEventListener('click', showNextBanner);

        function startAutoScroll() {
            scrollInterval = setInterval(showNextBanner, 10000); // Auto scroll setiap 10 detik
        }

        function stopAutoScroll() {
            clearInterval(scrollInterval); // Menghentikan auto scroll
        }

        // Mulai auto scroll saat halaman dimuat
        startAutoScroll();

        // Hentikan auto scroll saat pengguna mengklik navigasi
        prevButton.addEventListener('click', stopAutoScroll);
        nextButton.addEventListener('click', stopAutoScroll);
    </script>



    <div class="catalog-container">
        <?php
        // Membaca file CSV dan menampilkan produk
        if (($handle = fopen("data/dataproduk.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header
            $products = [];

            // Mengumpulkan data produk berdasarkan id_produk
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $id_produk = $data[0]; // Kolom id produk
                $nama_produk = $data[1]; // Kolom nama produk
                $foto_utama = $data[9]; // Kolom foto utama
                $harga_produk = number_format($data[7], 0, ',', '.'); // Kolom harga produk
                $produk_terjual = (int)$data[11]; // Kolom produk terjual

                // Menyimpan data produk dan jumlah produk terjual
                if (!isset($products[$id_produk])) {
                    $products[$id_produk] = [
                        'nama_produk' => $nama_produk,
                        'foto_utama' => $foto_utama,
                        'harga_produk' => $harga_produk,
                        'total_terjual' => 0
                    ];
                }
                // Menambahkan jumlah produk terjual
                $products[$id_produk]['total_terjual'] += $produk_terjual;
            }
            fclose($handle);

            // Menampilkan produk
            foreach ($products as $id_produk => $product) {
                echo '<a href="detailproduk.php?id_produk=' . htmlspecialchars($id_produk) . '" class="product">';
                echo '<img src="img/' . htmlspecialchars($product['foto_utama']) . '" alt="' . htmlspecialchars($product['nama_produk']) . '">';
                echo '<div class="product-name">' . htmlspecialchars($product['nama_produk']) . '</div>';
                echo '<div class="product-price">Rp ' . $product['harga_produk'] . '</div>';
                echo '<div class="product-sold">Terjual: ' . $product['total_terjual'] . '</div>'; // Menampilkan total produk terjual
                echo '</a>';
            }
        } else {
            echo '<div class="product">Tidak ada produk tersedia.</div>';
        }
        ?>
    </div>
    <button class="help-button" onclick="window.location.href='chat.php'">?</button>

    <br><br><br><br>
    <?php include 'footerberanda.php'; ?>

</body>

</html>