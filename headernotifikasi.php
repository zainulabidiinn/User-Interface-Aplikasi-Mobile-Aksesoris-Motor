<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Profil</title>
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
    </style>
</head>

<body>

    <div class="header">
        <a href="javascript:goBack()" class="icon" title="Kembali">
            <i class="fas fa-arrow-left"></i> <!-- Ikon kembali -->  Notifikasi
        </a>
    </div>
    <script>
        // Custom back function for header
        function goBack() {
            window.history.back(); // Go back to the previous page in browser history
        }
    </script>

    <!-- Konten halaman detail produk akan dimasukkan di sini -->

</body>

</html>