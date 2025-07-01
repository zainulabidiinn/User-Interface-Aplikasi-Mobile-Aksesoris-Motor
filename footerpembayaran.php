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
            color:white;
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
        <button class="button" id="payButton">Sudah Bayar</button>
    </div>

    <!-- Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">

            <h3>Selamat, pesanan Anda berhasil dibuat!</h3>
        </div>
    </div>

    <script>
        document.getElementById("payButton").onclick = function() {
            document.getElementById("confirmationModal").style.display = "block";

            // Redirect after 2 seconds
            setTimeout(function() {
                window.location.href = "pesanan.php";
            }, 2000);
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("confirmationModal")) {
                document.getElementById("confirmationModal").style.display = "none";
            }
        }
    </script>

</body>

</html>