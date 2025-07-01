<?php
session_start();
session_destroy(); // Menghentikan sesi
header('Location: index.php'); // Kembali ke halaman login
exit();