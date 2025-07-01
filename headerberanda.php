<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Beranda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding-top: 60px;
            /* Memberi ruang untuk header yang tetap */
        }

        .header {
            background-color: #C70000;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .logo {
            margin-right: 20px;
        }

        .logo img {
            height: 40px;
        }

        .search-container {
            display: flex;
            flex-grow: 1;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            /* Sudut melengkung di kiri */
            outline: none;
            /* Menghilangkan outline */
        }

        .search-icon {
            font-size: 24px;
            color: #FFF;
            cursor: pointer;
            background-color: #C70000;
            padding: 10px;
            border: 1px solid #ccc;
            border-left: none;
            border-radius: 0 4px 4px 0;
            /* Hanya sudut kanan melengkung */
            display: flex;
            /* Menyelaraskan ikon */
            align-items: center;
            /* Memusatkan ikon secara vertikal */
        }

        .notification {
            font-size: 24px;
            color: #FFF;
            margin-left: 20px;
            cursor: pointer;
            position: relative;
        }

        .notification .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: black;
            color: white;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 12px;
        }

        .cart {
            font-size: 24px;
            color: #FFF;
            position: relative;
            margin-left: 20px;
            cursor: pointer;
        }

        .cart .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: black;
            color: white;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="img/logo.jpg" alt="Logo">
        </div>
        <div class="search-container">
            <form action="hasilcari.php" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="query" class="search-input" placeholder="Cari produk..." required>
                <button type="submit" class="search-icon">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <?php
        // Menghitung jumlah notifikasi dari notifikasi.csv
        $jumlah_notifikasi = 0;

        // Membaca file CSV notifikasi
        if (($handle = fopen("data/notifikasi.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $jumlah_notifikasi++; // Menghitung jumlah notifikasi
            }
            fclose($handle);
        }
        ?>

        <a href="notifikasi.php" class="notification">
            <i class="fas fa-bell"></i>
            <span class="badge"><?php echo $jumlah_notifikasi; ?></span> <!-- Menampilkan jumlah notifikasi -->
        </a>
        
        <?php
        // Inisialisasi jumlah produk dalam keranjang
        $jumlah_produk = 0;

        // Membaca file CSV keranjang
        if (($handle = fopen("data/datakeranjang.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header

            // Menghitung total jumlah produk
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $jumlah_produk += (int)$data[6]; // Mengambil jumlah produk dari kolom
            }
            fclose($handle);
        }
        ?>

        <a href="keranjang.php" class="cart">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge"><?php echo $jumlah_produk; ?></span> <!-- Menampilkan jumlah produk -->
        </a>
    </div>

</body>

</html>