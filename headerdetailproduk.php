<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="style.css"> <!-- Gaya CSS Anda -->
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #C70000;
            border-bottom: 1px solid #ddd;
            position: fixed;
            /* Mengunci header di atas */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            /* Agar selalu di atas */
        }

        .icon {
            cursor: pointer;
            font-size: 24px;
            /* Ukuran ikon */
            color: white;
            /* Warna ikon */
            position: relative;
            /* Untuk badge */
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .icon:hover {
            color: #F3EDC8;
            /* Warna saat hover */
        }

        body {
            margin: 0;
            /* Menghapus margin default */
            padding-top: 60px;
            /* Jarak untuk menghindari konten tertutup header */
        }

        .badge {
            position: absolute;
            /* Badge di atas ikon */
            top: -5px;
            /* Posisi badge */
            right: -10px;
            /* Posisi badge */
            background-color: black;
            /* Warna badge */
            color: white;
            /* Warna teks badge */
            border-radius: 50%;
            /* Membuat badge bulat */
            padding: 2px 5px;
            /* Ruang di dalam badge */
            font-size: 10px;
            /* Ukuran font badge */
            min-width: 10px;
            /* Lebar minimal badge */
            text-align: center;
            /* Memusatkan teks */
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="javascript:goBack()" class="icon" title="Kembali">
            <i class="fas fa-arrow-left"></i> <!-- Ikon kembali -->
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

        <a href="keranjang.php" class="icon" title="Keranjang">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge"><?php echo $jumlah_produk; ?></span> <!-- Menampilkan jumlah produk -->
        </a>
    </div>



</body>

</html>