<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php");
    exit;
}

// Retrieve the query parameters if available
$rating = isset($_GET['rating']) ? htmlspecialchars($_GET['rating']) : '';
$deskripsi = isset($_GET['deskripsi']) ? htmlspecialchars($_GET['deskripsi']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #eef2f3;
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 85vh;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .chat-list {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 10px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
            max-height: calc(100vh - 120px);
        }
        .chat-message {
            display: flex;
            flex-direction: column;
            margin: 10px 0;
        }
        .chat-bubble {
            padding: 12px 15px;
            border-radius: 20px;
            max-width: 75%;
            position: relative;
            display: inline-block;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        .bubble-sent {
            background-color: #007BFF;
            color: white;
            align-self: flex-end;
        }
        .bubble-received {
            background-color: #e1e1e1;
            color: black;
            align-self: flex-start;
        }
        .bubble-sent .time,
        .bubble-received .time {
            font-size: 12px;
            color: #bbb;
            position: absolute;
            bottom: -18px;
            right: 10px;
        }
        .input-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .input-message {
            flex-grow: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .input-message:focus {
            border-color: #007BFF;
            outline: none;
        }
        .send-button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .send-button:hover {
            background-color: #218838;
        }
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 600px) {
            .input-container {
                flex-direction: column;
            }
            .send-button {
                width: 100%;
            }
            .input-message {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'headerchat.php'; ?>
    <div class="chat-container">
        <div class="chat-list" id="chatList">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="input-container">
            <input type="text" id="messageInput" class="input-message" 
                   placeholder="Mengetik pesan..." 
                   value="<?php echo $rating ? 'Rating: ' . $rating . ', Deskripsi: ' . $deskripsi : ''; ?>">
            <input type="file" id="imageInput" accept="image/*">
            <button class="send-button" onclick="sendMessage()">Kirim</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const imageInput = document.getElementById('imageInput');
            const messageText = messageInput.value.trim();
            const chatList = document.getElementById('chatList');

            if (messageText || imageInput.files.length > 0) {
                const messageWrapper = document.createElement('div');
                messageWrapper.className = 'chat-message';

                // Handle image upload
                if (imageInput.files.length > 0) {
                    const file = imageInput.files[0];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageBubble = document.createElement('div');
                        imageBubble.className = 'chat-bubble bubble-sent';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100%';
                        img.style.borderRadius = '15px';
                        imageBubble.appendChild(img);
                        messageWrapper.appendChild(imageBubble);
                        chatList.appendChild(messageWrapper);
                    };
                    reader.readAsDataURL(file);
                }

                // Handle text message
                if (messageText) {
                    const bubble = document.createElement('div');
                    bubble.className = 'chat-bubble bubble-sent';
                    bubble.textContent = messageText;

                    const timeElement = document.createElement('div');
                    timeElement.className = 'time';
                    timeElement.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    bubble.appendChild(timeElement);
                    messageWrapper.appendChild(bubble);
                    chatList.appendChild(messageWrapper);
                }

                messageInput.value = '';
                imageInput.value = ''; // Clear the image input
                chatList.scrollTop = chatList.scrollHeight;
            }
        }

        function addAdminMessage(text) {
            const chatList = document.getElementById('chatList');
            const messageWrapper = document.createElement('div');
            messageWrapper.className = 'chat-message';

            const bubble = document.createElement('div');
            bubble.className = 'chat-bubble bubble-received';
            bubble.textContent = text;

            const timeElement = document.createElement('div');
            timeElement.className = 'time';
            timeElement.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            bubble.appendChild(timeElement);
            messageWrapper.appendChild(bubble);
            chatList.appendChild(messageWrapper);
            chatList.scrollTop = chatList.scrollHeight;
        }

        window.onload = function() {
            addAdminMessage("Selamat datang di Racing Claash! ada yang bisa saya bantu?");
        }
    </script>
</body>
</html>