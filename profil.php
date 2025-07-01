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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            text-align: center;
        }

        .profile-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #C70000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .button:hover {
            background-color: #BF3131;
        }
    </style>
</head>

<body>
<?php include 'headerprofil.php'; ?>
    <div class="profile-container">
        <?php if ($currentUser): ?>
            <img src="img/<?php echo htmlspecialchars($currentUser['foto_profil']); ?>" alt="Foto Profil" style="width: 150px; height: 150px;">
            <h2><?php echo htmlspecialchars($currentUser['nama_pengguna']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($currentUser['email']); ?></p>
            <p>Alamat: <?php echo htmlspecialchars($currentUser['alamat']); ?></p>
            <a href="ubahprofil.php" class="button">Ubah Profil</a><br>
            <a href="komplain.php" class="button">Pusat Bantuan</a>
            <br><br>
            <a href="logout.php" style="text-decoration: none; color: white; background-color: #333; padding: 10px 20px; border-radius: 5px;">Logout</a>
        <?php else: ?>
            <p>Pengguna tidak ditemukan.</p>
        <?php endif; ?>
    </div>
    <?php include 'footerberanda.php'; ?>
</body>

</html>