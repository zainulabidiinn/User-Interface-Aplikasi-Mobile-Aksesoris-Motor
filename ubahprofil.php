<?php
session_start();

// Fungsi untuk membaca data dari CSV
function readCSV($filename)
{
    $data = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        fgetcsv($handle); // Membaca header
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = [
                'id_pengguna' => $row[0],
                'nama_pengguna' => $row[1],
                'username' => $row[2],
                'password' => $row[3],
                'email' => $row[4],
                'telepon_pengguna' => $row[5],
                'alamat' => $row[6],
                'foto_profil' => $row[7],
            ];
        }
        fclose($handle);
    }
    return $data;
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Mendapatkan data pengguna berdasarkan id_pengguna
$users = readCSV('data/datapengguna.csv');
$currentUser = null;

foreach ($users as $user) {
    if ($user['id_pengguna'] == $_SESSION['id_pengguna']['id_pengguna']) {
        $currentUser = $user;
        break;
    }
}

// Proses pengeditan data
$modal = false; // Variabel untuk menampilkan modal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'id_pengguna' => $currentUser['id_pengguna'],
        'nama_pengguna' => $_POST['nama_pengguna'],
        'username' => $_POST['username'],
        'password' => $currentUser['password'], // Tetap sama untuk sementara
        'email' => $_POST['email'],
        'telepon_pengguna' => $_POST['telepon_pengguna'],
        'alamat' => $_POST['alamat'],
        'foto_profil' => $currentUser['foto_profil'], // Tetap sama untuk sementara
    ];

    // Cek jika password baru diisi
    if (!empty($_POST['password'])) {
        $updatedData['password'] = $_POST['password']; // Update password jika diisi
    }

    // Cek jika ada file foto profil yang diunggah
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "img/"; // Folder untuk menyimpan foto
        $targetFile = $targetDir . basename($_FILES["foto_profil"]["name"]);

        // Pindahkan file ke folder target
        if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $targetFile)) {
            $updatedData['foto_profil'] = basename($_FILES["foto_profil"]["name"]); // Update foto profil
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Simpan data ke CSV
    $users[array_search($currentUser['id_pengguna'], array_column($users, 'id_pengguna'))] = $updatedData;
    $file = fopen('data/datapengguna.csv', 'w');
    fputcsv($file, ['id_pengguna', 'nama_pengguna', 'username', 'password', 'email', 'telepon_pengguna', 'alamat', 'foto_profil']); // Header
    foreach ($users as $user) {
        fputcsv($file, $user);
    }
    fclose($file);

     // Tampilkan modal jika berhasil
    $modal = true;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .form-container {
            background-color: #fff;
            justify-content: center;
            margin-left: 20px;
            border-radius: 10px;
            margin-right: 50px;
            text-align: left;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #C70000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #BF3131;
        }

        .modal {
            display: <?php echo $modal ? 'block' : 'none'; ?>; /* Tampilkan modal jika berhasil */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Latar belakang hitam dengan transparansi */
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
    </style>
</head>

<body>
    <?php include 'headerprofil.php'; ?>
    <div class="form-container">
        <h2>Ubah Profil</h2>
        <?php if ($currentUser): ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nama_pengguna" value="<?php echo htmlspecialchars($currentUser['nama_pengguna']); ?>" required>
                <input type="text" name="username" value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                <input type="password" name="password" placeholder="Password (biarkan kosong jika tidak diubah)">
                <input type="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                <input type="text" name="telepon_pengguna" value="<?php echo htmlspecialchars($currentUser['telepon_pengguna']); ?>" required>
                <textarea name="alamat" rows="3" required><?php echo htmlspecialchars($currentUser['alamat']); ?></textarea>
                <label for="foto_profil">Ganti Foto Profil (opsional):</label>
                <input type="file" name="foto_profil" accept="image/*"><br>
                <button type="submit" class="button">Simpan</button>
            </form>
        <?php else: ?>
            <p>Pengguna tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Modal untuk konfirmasi -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Perubahan telah berhasil.</p>
            <button onclick="redirect()">OK</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        function redirect() {
            window.location.href = 'profil.php';
        }
    </script>

    <?php include 'footerberanda.php'; ?>
</body>

</html>