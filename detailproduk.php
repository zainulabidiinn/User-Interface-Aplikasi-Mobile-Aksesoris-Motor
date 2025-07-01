<?php
// Mengambil id_produk dari parameter URL
$id_produk = isset($_GET['id_produk']) ? $_GET['id_produk'] : 0;

// Mengambil data produk dari CSV
$produk = [];
$varian_set = []; // Untuk menyimpan varian unik
if (($handle = fopen("data/dataproduk.csv", "r")) !== FALSE) {
    fgetcsv($handle); // Mengabaikan header
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($data[0] == $id_produk) {
            // Menyimpan produk dan varian
            $produk[] = [
                'nama_produk' => htmlspecialchars($data[1]),
                'foto_varian' => htmlspecialchars($data[4]),
                'harga_produk' => number_format($data[7], 0, ',', '.'),
                'deskripsi_produk' => nl2br(htmlspecialchars(str_replace('.', ".\n\n", $data[8]))),
                'produk_terjual' => (int)$data[11],
                'foto_produk' => explode(',', htmlspecialchars($data[10])), // Memisahkan foto produk
                'varian_ukuran' => htmlspecialchars($data[5]),
                'varian_warna' => htmlspecialchars($data[3]), // Menyimpan varian warna
            ];
            // Menyimpan varian unik berdasarkan varian_warna dan foto_varian
            $varian_set[$data[3]] = htmlspecialchars($data[4]); // Menggunakan varian_warna sebagai kunci
        }
    }
    fclose($handle);
}

// Mengambil data ulasan dari CSV
$ulasan = [];
if (($handle = fopen("data/dataulasan.csv", "r")) !== FALSE) {
    fgetcsv($handle); // Mengabaikan header
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($data[2] == $produk[0]['nama_produk']) { // Memastikan nama produk cocok
            $ulasan[] = [
                'nama_pengguna' => htmlspecialchars($data[1]),
                'varian_warna' => htmlspecialchars($data[4]),
                'varian_ukuran' => htmlspecialchars($data[5]),
                'nilai_ulasan' => (int)$data[7],
                'deskripsi_ulasan' => htmlspecialchars($data[8]),
            ];
        }
    }
    fclose($handle);
}

// Menghitung total produk terjual untuk id_produk yang sama
$total_terjual = array_sum(array_column($produk, 'produk_terjual'));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="style.css"> <!-- Gaya CSS Anda -->
    <style>
        body {
            margin: 0;
            /* Menghapus margin default */
            padding-top: 60px;
            /* Jarak untuk menghindari konten tertutup header */
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        .foto-produk-container {
            display: flex;
            overflow-x: scroll;
            /* Mengizinkan scroll horizontal */
            scroll-snap-type: x mandatory;
            /* Mengaktifkan snap */
            padding: 10px 0;
        }

        .foto-produk {
            min-width: 800px;
            /* Lebar minimal foto produk */
            height: auto;
            /* Tinggi otomatis untuk menjaga proporsi */
            margin-right: 10px;
            /* Jarak antar foto */
            border-radius: 5px;
            /* Sudut melengkung */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Bayangan */
            scroll-snap-align: start;
            /* Memastikan foto menyentuh awal */
        }

        .varian {
            margin-top: 20px;
            /* Jarak atas varian */
            display: flex;
            /* Mengatur foto varian dalam baris */
            flex-wrap: wrap;
            /* Mengizinkan pembungkusan jika diperlukan */
        }

        .foto-varian {
            width: 80px;
            /* Lebar foto varian */
            height: auto;
            /* Tinggi otomatis untuk menjaga proporsi */
            margin-right: 5px;
            /* Jarak antar foto varian */
            border-radius: 5px;
            /* Sudut melengkung untuk foto varian */
            cursor: pointer;
            /* Pointer saat hover */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk foto varian */
        }

        .produk-info {
            margin-top: 20px;
        }

        .harga {
            font-size: 24px;
            /* Ukuran font harga */
            color: #C70000;
            /* Warna harga */
            font-weight: bold;
            /* Menebalkan teks */
        }

        .deskripsi {
            text-align: justify;
            margin-top: 15px;
            /* Jarak atas deskripsi */
        }

        .ulasan-wrapper {
            overflow-x: auto;
            /* Mengizinkan scroll horizontal */
            display: flex;
            /* Mengatur kontainer untuk scroll */
        }

        .ulasan-container {
            display: flex;
            flex-direction: column;
            /* Mengatur ulasan secara vertikal */
            min-width: 300px;
            /* Lebar minimum untuk setiap grup ulasan */
            margin-right: 10px;
            /* Jarak antar grup ulasan */
        }

        .ulasan {
            margin-bottom: 10px;
            /* Jarak antar ulasan */
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
            /* Warna latar belakang */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Bayangan */
        }

        .scroll-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #C70000;
            /* Warna tombol */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #C70000;
            /* Warna tombol */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nama-pengguna {
            font-weight: bold;
            font-size: 18px;
            /* Ukuran font pengguna */
        }

        .star-rating {
            color: grey;
            /* Warna bintang */
        }

        .star {
            font-size: 18px;
            /* Ukuran bintang */
            margin-right: 2px;
            /* Jarak antar bintang */
        }

        .star.filled {
            color: #FFD700;
            /* Warna untuk bintang terisi */
        }

        .average-rating {
            font-weight: bold;
            margin-bottom: 10px;
            color: #C70000;
            /* Color for the average rating */
            margin-top: -15px;
            margin-bottom: 10px;
        }

        .rating-summary {
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .average-rating {
            font-size: 24px;
            font-weight: bold;
            color: #C70000;
        }

        .star-rating {
            color: grey;
            margin: 0 10px;
        }

        .rating-details {
            font-size: 16px;
            color: #555;
        }

        .rating-breakdown {
            display: flex;
            flex-direction: column;
        }

        .rating-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }

        .star-count {
            width: 20px;
            text-align: center;
        }

        .progress-bar {
            flex-grow: 1;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            margin: 0 10px;
        }

        .progress {
            height: 100%;
            background-color: #C70000;
            border-radius: 5px;
        }

        .count {
            width: 30px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
                max-width: 325px;
                margin: auto;
                padding-top: 0px;
            }

            .foto-produk-container {
                display: flex;
                overflow-x: scroll;
                /* Mengizinkan scroll horizontal */
                scroll-snap-type: x mandatory;
                /* Mengaktifkan snap */
                padding: 5px 0;
            }

            .foto-produk {
                min-width: 325px;
                /* Lebar minimal foto produk */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                margin-right: 10px;
                /* Jarak antar foto */
                border-radius: 5px;
                /* Sudut melengkung */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                /* Bayangan */
                scroll-snap-align: start;
                /* Memastikan foto menyentuh awal */
            }

            .varian {
                margin-top: 20px;
                /* Jarak atas varian */
                display: flex;
                /* Mengatur foto varian dalam baris */
                flex-wrap: wrap;
                /* Mengizinkan pembungkusan jika diperlukan */
                justify-content: left;
            }

            .foto-varian {
                width: 50px;
                /* Lebar foto varian */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                margin-right: 15px;
                /* Jarak antar foto varian */
                border-radius: 5px;
                /* Sudut melengkung untuk foto varian */
                cursor: pointer;
                /* Pointer saat hover */
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                /* Bayangan untuk foto varian */
            }

            .produk-info {
                margin-top: 20px;
            }

            .harga {
                font-size: 24px;
                /* Ukuran font harga */
                color: #C70000;
                /* Warna harga */
                font-weight: bold;
                /* Menebalkan teks */
                margin-top: 10px;
            }

            .deskripsi {
                margin-top: 15px;
                /* Jarak atas deskripsi */
            }

            .terjual {
                margin-top: 5px;
            }

            .nama {
                font-size: 30px;
                font-weight: bold;
            }
        }

        @media (max-width: 400px) {
            .container {
                padding: 10px;
                max-width: 325px;
                margin: auto;
                padding-top: 0px;
            }

            .foto-produk-container {
                display: flex;
                overflow-x: scroll;
                /* Mengizinkan scroll horizontal */
                scroll-snap-type: x mandatory;
                /* Mengaktifkan snap */
                padding: 5px 0;
            }

            .foto-produk {
                min-width: 325px;
                /* Lebar minimal foto produk */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                margin-right: 10px;
                /* Jarak antar foto */
                border-radius: 5px;
                /* Sudut melengkung */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                /* Bayangan */
                scroll-snap-align: start;
                /* Memastikan foto menyentuh awal */
            }

            .varian {
                margin-top: 20px;
                /* Jarak atas varian */
                display: flex;
                /* Mengatur foto varian dalam baris */
                flex-wrap: wrap;
                /* Mengizinkan pembungkusan jika diperlukan */
                justify-content: left;
            }

            .foto-varian {
                width: 50px;
                /* Lebar foto varian */
                height: auto;
                /* Tinggi otomatis untuk menjaga proporsi */
                margin-right: 15px;
                /* Jarak antar foto varian */
                border-radius: 5px;
                /* Sudut melengkung untuk foto varian */
                cursor: pointer;
                /* Pointer saat hover */
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                /* Bayangan untuk foto varian */
            }

            .produk-info {
                margin-top: 20px;
            }

            .harga {
                font-size: 24px;
                /* Ukuran font harga */
                color: #C70000;
                /* Warna harga */
                font-weight: bold;
                /* Menebalkan teks */
                margin-top: 10px;
            }

            .deskripsi {
                margin-top: 15px;
                /* Jarak atas deskripsi */
            }

            .terjual {
                margin-top: 5px;
            }

            .nama {
                font-size: 30px;
                font-weight: bold;
            }
        }
    </style>
</head>

<body>
    <?php include 'headerdetailproduk.php' ?>
    <div class="container">
        <?php if (!empty($produk)): ?>
            <div class="foto-produk-container">
                <?php foreach ($produk[0]['foto_produk'] as $foto): ?>
                    <img src="img/<?php echo $foto; ?>" alt="<?php echo $produk[0]['nama_produk']; ?>" class="foto-produk">
                <?php endforeach; ?>
            </div>

            <div class="produk-info">
                <div class="nama"><?php echo $produk[0]['nama_produk']; ?></div>
                <div class="harga">Rp <?php echo $produk[0]['harga_produk']; ?></div>
                <div class="terjual">Terjual: <?php echo $total_terjual; ?></div><br>
                <div class="stok">Stok: 500</div>

                <h3>Varian Warna:</h3>
                <div class="varian">
                    <?php foreach ($varian_set as $varian_warna => $foto_varian): ?>
                        <img src="img/<?php echo $foto_varian; ?>" alt="<?php echo $varian_warna; ?>" class="foto-varian">
                    <?php endforeach; ?>
                </div>

                <h3>Deskripsi Produk</h3>
                <div class="deskripsi"><?php echo $produk[0]['deskripsi_produk']; ?></div>

                <h3>Ulasan Produk</h3>
                <?php
                $totalScores = array_fill(1, 5, 0); // Initialize counts for ratings 1-5
                $reviewCount = count($ulasan); // Total number of reviews

                if ($reviewCount > 0) {
                    foreach ($ulasan as $review) {
                        $totalScores[$review['nilai_ulasan']]++; // Count each rating
                    }
                    // Calculate average score
                    $averageScore = round(array_sum(array_map(function ($score, $count) {
                        return $score * $count;
                    }, range(1, 5), $totalScores)) / $reviewCount, 2);
                } else {
                    $averageScore = 0; // Default to 0 if no reviews
                }
                ?>

                Total Penilaian:
                <div class="rating-summary">
                    <div class="average-rating">
                        <i class="fas fa-star star <?php echo ($averageScore >= 1) ? 'filled' : ''; ?>" style="font-size: 25px;"></i>
                        <span class="average-score"><?php echo $averageScore; ?></span> / 5
                    </div>
                    <div class="rating-details">
                        <span>dari <?php echo $reviewCount; ?> ulasan</span>
                    </div><br>
                    <div class="rating-breakdown">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <div class="rating-item">
                                <i class="fas fa-star star" style="color: #FFD700;"></i>
                                <span class="star-count"><?php echo $i; ?></span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: <?php echo ($reviewCount > 0) ? round(($totalScores[$i] / $reviewCount) * 100, 2) : 0; ?>%;"></div>
                                </div>
                                <span class="count"><?php echo $totalScores[$i]; ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div><br>


                <div class="ulasan-wrapper">
                    <div class="ulasan-container">
                        <?php if (!empty($ulasan)): ?>
                            <?php foreach ($ulasan as $index => $review): ?>
                                <div class="ulasan" data-index="<?php echo $index; ?>" style="display: none;">
                                    <div class="nama-pengguna"><?php echo $review['nama_pengguna']; ?></div>
                                    <div class="star-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star star <?php echo ($i <= $review['nilai_ulasan']) ? 'filled' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <div>Varian Warna: <?php echo $review['varian_warna']; ?></div>
                                    <div>Varian Ukuran: <?php echo $review['varian_ukuran']; ?></div>
                                    <div>Deskripsi: <?php echo $review['deskripsi_ulasan']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada ulasan untuk produk ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="scroll-button" onclick="scrollUlasan()">Lihat lebih banyak</button>
                <button class="back-button" onclick="backUlasan()" style="display: none;">Sebelumnya</button>
            </div>
        <?php else: ?>
            <p>Produk tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <script>
        let currentIndex = 0; // Menyimpan indeks ulasan saat ini
        const ulasan = document.querySelectorAll('.ulasan'); // Mengambil semua ulasan
        const perPage = 5; // Jumlah ulasan yang ditampilkan per klik
        let history = []; // Stack untuk menyimpan indeks sebelumnya

        function updateDisplay() {
            // Menyembunyikan semua ulasan
            ulasan.forEach(item => {
                item.style.display = 'none'; // Menyembunyikan semua ulasan
            });

            // Menampilkan ulasan dari currentIndex
            for (let i = currentIndex; i < currentIndex + perPage && i < ulasan.length; i++) {
                ulasan[i].style.display = 'block'; // Menampilkan ulasan
            }

            // Button visibility
            document.querySelector('.scroll-button').style.display = (currentIndex + perPage < ulasan.length) ? 'inline' : 'none';
            document.querySelector('.back-button').style.display = (history.length > 0) ? 'inline' : 'none';
        }

        function scrollUlasan() {
            // Push currentIndex to history before moving forward
            if (currentIndex < ulasan.length) {
                history.push(currentIndex);
                currentIndex += perPage; // Move to the next set of reviews
                updateDisplay();
            }
        }

        function backUlasan() {
            if (history.length > 0) {
                currentIndex = history.pop(); // Go back to the previous index
                updateDisplay();
            }
        }
        // Custom back function for header
        function goBack() {
            window.history.back(); // Go back to the previous page in browser history
        }

        // Menampilkan 5 ulasan pertama saat halaman dimuat
        updateDisplay();
    </script>
    <br><br><br><br>
    <?php include 'footerdetailproduk.php'; ?>
</body>

</html>