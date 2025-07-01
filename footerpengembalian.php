<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            background-color: #C70000;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            margin-bottom: -4px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        body {
            margin: 0;
        }

        .button {
            font-size: 20px;
            font-weight: bold;
            color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            background-color: #C70000;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div class="footer">
        <button class="button" onclick="ajukanPengembalian()">Ajukan Pengembalian</button>
    </div>

    <script>
        function ajukanPengembalian() {
            const option = document.getElementById('jenisPengembalian').value;
            const modalMessage = document.getElementById('modalMessage');

            if (option === 'retur') {
                modalMessage.innerText = "Kirimkan produk anda sekarang dan tunggu produk baru dikirimkan.";
            } else if (option === 'refund') {
                modalMessage.innerText = "Dana dikembalikan dan kirimkan produk anda sekarang.";
            } else {
                alert("Silakan pilih jenis pengembalian terlebih dahulu.");
                return;
            }

            document.getElementById('modal').style.display = "block";

            // Redirect to home after 3 seconds
            setTimeout(() => {
                closeModal(); // Optionally close the modal
                redirectToHome();
            }, 3000); // Change 3000 to the desired delay in milliseconds
        }

        function closeModal() {
            document.getElementById('modal').style.display = "none";
        }

        function redirectToHome() {
            window.location.href = 'beranda.php';
        }
    </script>

</body>

</html>