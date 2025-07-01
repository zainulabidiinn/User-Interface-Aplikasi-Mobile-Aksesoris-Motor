<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Variabel untuk menampilkan modal
$modal = false;

// Proses pengiriman komplain
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $komplain = trim($_POST['komplain']);

    // Validasi input
    if (!empty($komplain)) {
        // Set modal untuk menampilkan pesan sukses
        $modal = true;
    }
}

// Dummy data komplain
$daftarKomplain = [
    "Saya tidak bisa melakukan pembayaran",
    "Saya sudah bayar tapi status masih belum terupdate",
    "Saya tidak bisa mengubah password"
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Komplain</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            margin-top: -10px;
        }

        textarea {
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 100px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .button:hover {
            background-color: #BF3131;
        }

        /* Style untuk modal */
        .modal {
            display: <?php echo $modal ? 'block' : 'none'; ?>;
            /* Tampilkan modal jika berhasil */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            /* Latar belakang hitam dengan transparansi */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style untuk daftar komplain */
        .komplain-list {
            margin-top: 20px;
        }

        .komplain-item {
            background: #f1f1f1;
            border-left: 5px solid #C70000;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .komplain-item:hover {
            background: #e1e1e1;
        }
    </style>
</head>

<body>
    <?php include 'headerkomplain.php'; ?>
    <div class="form-container">
        <h2>Kirim Komplain</h2>
        <form method="POST">
            <textarea name="komplain" placeholder="Tulis komplain Anda di sini..." required></textarea>
            <button type="submit" class="button">Kirim</button>
        </form>

        <!-- Daftar Komplain Modern -->
        <div class="komplain-list">
            <h3>Daftar Komplain:</h3>
            <?php foreach ($daftarKomplain as $item): ?>
                <div class="komplain-item">
                    <?php echo htmlspecialchars($item); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal untuk konfirmasi -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Komplain Anda telah dikirimkan.</p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>

    <?php include 'footerberanda.php'; ?>
</body>

</html>