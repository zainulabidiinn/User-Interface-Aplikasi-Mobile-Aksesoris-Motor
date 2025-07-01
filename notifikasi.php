<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-left: 10px;
            margin-right: 10px;
        }

        .notification-item {
            border-bottom: 1px solid #ccc;
            padding: 15px 0;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-title {
            font-weight: bold;
            color: #C70000;
        }

        .notification-description {
            margin: 5px 0;
            color: #555;
        }

        .notification-date {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>
    <?php include 'headernotifikasi.php'; ?>

    <div class="container">
        <?php
        if (($handle = fopen("data/notifikasi.csv", "r")) !== FALSE) {
            fgetcsv($handle); // Mengabaikan header
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $id_notifikasi = htmlspecialchars($data[0]);
                $nama_notifikasi = htmlspecialchars($data[1]);
                $deskripsi = htmlspecialchars($data[2]);
                $tanggal = htmlspecialchars($data[3]);

                echo "<div class='notification-item'>";
                echo "<div class='notification-title'>$nama_notifikasi</div>";
                echo "<div class='notification-description'>$deskripsi</div>";
                echo "<div class='notification-date'>$tanggal</div>";
                echo "</div>";
            }
            fclose($handle);
        } else {
            echo "<p>Gagal memuat notifikasi.</p>";
        }
        ?>
    </div>

</body>

</html>