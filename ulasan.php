<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php");
    exit;
}

// Data produk dummy
$nama_produk = "Cover Shockbreaker Depan Mio";
$varian_warna = "Warna 05";
$varian_ukuran = "Mio New Soul GT";
$harga = "Rp69.000";
$foto_varian = "mb5.jpg"; // Ganti dengan nama file gambar yang sesuai
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .container {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            margin-top: -30px;
            margin-left: 10px;
            margin-right: 10px;
        }

        h2 {
            text-align: center;
        }

        .product-info {
            margin-bottom: 20px;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .star {
            font-size: 30px;
            color: #FFD700;
            cursor: pointer;
        }

        .button {
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            margin-top: 15px;
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
    </style>
</head>

<body>
    <?php include 'headerulasan.php'; ?>
    <div class="container">
        <h2>Ulasan Produk</h2>
        <div class="product-info">
            <img src="img/<?php echo htmlspecialchars($foto_varian); ?>" alt="<?php echo htmlspecialchars($nama_produk); ?>" style="width: 200px; height: 200px; margin-left:50px;">
            <p><strong>Nama Produk:<br></strong> <?php echo htmlspecialchars($nama_produk); ?></p>
            <p><strong>Warna:</strong> <?php echo htmlspecialchars($varian_warna); ?></p>
            <p><strong>Ukuran:</strong> <?php echo htmlspecialchars($varian_ukuran); ?></p>
            <p><strong>Harga:</strong> <?php echo htmlspecialchars($harga); ?></p>
        </div>

        <p><strong>Berikan Penilaian: </strong><br>[isi bintang dengan klik]</p>
        <div class="star-rating">
            <span class="star" onclick="setRating(1)">&#9733;</span>
            <span class="star" onclick="setRating(2)">&#9733;</span>
            <span class="star" onclick="setRating(3)">&#9733;</span>
            <span class="star" onclick="setRating(4)">&#9733;</span>
            <span class="star" onclick="setRating(5)">&#9733;</span>
        </div>

        <textarea id="deskripsi" placeholder="Tulis deskripsi ulasan..." rows="4" style="width: 100%;"></textarea>

        <button class="button" onclick="submitReview()">Kirimkan Ulasan</button>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <p>Selamat! Ulasan Anda telah dikirim.</p>
            <button class="button" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
        let rating = 0;

        function setRating(value) {
            rating = value;
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                star.style.color = index < rating ? '#FFD700' : '#ccc';
            });
        }

        function submitReview() {
            const deskripsi = document.getElementById('deskripsi').value;

            if (rating < 1 || rating > 5) {
                alert("Silakan pilih bintang terlebih dahulu.");
                return;
            }

            const query = new URLSearchParams({
                rating: rating,
                deskripsi: encodeURIComponent(deskripsi)
            }).toString();

            if (rating <= 3) {
                // Redirect to chat.php with review data in query parameters
                window.location.href = `chat.php?${query}`;
            } else {
                // Show success modal
                document.getElementById('modal').style.display = 'block';
            }
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            window.location.href = 'pesanan.php';
        }
    </script>
</body>

</html>