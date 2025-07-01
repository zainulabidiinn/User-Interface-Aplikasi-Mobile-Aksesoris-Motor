<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Beranda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0; /* Menghilangkan margin default */
            margin-bottom: 5px;
        }
        .footer {
            background-color: #C70000; /* Warna latar belakang footer */
            padding: 10px 0; /* Ruang di dalam footer */
            display: flex; /* Mengatur item dalam baris */
            justify-content: space-around; /* Meratakan item secara horizontal */
            align-items: center; /* Memusatkan item secara vertikal */
            width: 100%; /* Lebar penuh */
            position: fixed; /* Memastikan footer tetap di bawah */
            bottom: 0; /* Posisi footer di bawah halaman */
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
            margin-bottom: 0px;
        }
        .footer a {
            text-decoration: none; /* Menghilangkan garis bawah */
            color: #FFFF; /* Warna ikon */
            text-align: center; /* Memusatkan teks */
            flex: 1; /* Membagi ruang secara merata */
            padding: 10px; /* Ruang di sekitar ikon */
        }
        .footer a:hover {
            color: #EAD196; /* Warna saat hover */
        }
        .footer i {
            display: block; /* Menampilkan ikon dalam blok untuk pemusatan */
            font-size: 24px; /* Ukuran ikon */
        }
        @media (max-width: 600px) {
            .footer {
                background-color: #C70000; /* Memastikan latar belakang penuh */
            }
            .footer a {
                padding: 5px; /* Mengurangi padding pada tampilan mobile */
            }
            .footer i {
                font-size: 27px; /* Ukuran ikon lebih kecil di mobile */
            }
        }
    </style>
</head>
<body>

<div class="footer">
    <a href="beranda.php">
        <i class="fas fa-home"></i>
    </a>
    <a href="pesanan.php">
        <i class="fas fa-bag-shopping"></i>
    </a>
    <a href="chat.php">
        <i class="fas fa-comment-dots"></i>
    </a>
    <a href="profil.php">
        <i class="fas fa-user"></i>
    </a>
</div>

</body>
</html>