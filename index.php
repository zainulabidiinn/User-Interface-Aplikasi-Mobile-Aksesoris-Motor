<?php

session_start();
// Fungsi untuk membaca data dari CSV
function readCSV($filename) {
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

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = readCSV('data/datapengguna.csv');

    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $_SESSION['id_pengguna'] = $user;
            header("Location: beranda.php"); // Redirect ke halaman welcome
            exit;
        }
    }
    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            flex-direction: column; /* Mengatur item secara vertikal */
            justify-content: center; /* Memusatkan konten secara vertikal */
            align-items: center;
            margin: 0;
            background-color: #C70000;
            font-family: Arial, sans-serif;
            margin-top: 200px;
        }
        .logo {
            width: 100%;
            max-width: 150px; /* Maksimal lebar logo */
            margin-bottom: 20px;
            margin-top: -100px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #555;
        }
        .footer {
            background-color: #333; /* Warna latar belakang footer */
            color: white; /* Warna teks footer */
            text-align: center;
            padding: 10px 0; /* Ruang di dalam footer */
            width: 100%; /* Lebar penuh */
            position: fixed;
            bottom: 0; /* Posisi footer di bawah halaman */
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            left: 0;
            right: 0;
            z-index: 1000;
            margin-bottom: -4px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<img src="img/logo.jpg" alt="Logo" class="logo">
<div class="container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
<div class="footer">
    <p>Belum punya akun? <a href="daftar.php" style="color: white;">Daftar</a></p>
</div>

</body>
</html>