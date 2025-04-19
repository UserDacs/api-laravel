<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Socket.IO Chat</title>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <style>
        #typing {
            color: gray;
            font-style: italic;
        }

        .dot-typing {
            position: relative;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: black;
            color: black;
            animation: dot-typing 1.5s infinite linear;
            box-shadow: 8px 0 0 black, 16px 0 0 black;
        }

        @keyframes dot-typing {
            0% {
                box-shadow: 8px 0 0 black, 16px 0 0 black;
            }

            25% {
                box-shadow: 8px 0 0 black, 16px 0 0 black;
            }

            50% {
                box-shadow: 8px 0 0 black, 16px 0 0 transparent;
            }

            75% {
                box-shadow: 8px 0 0 transparent, 16px 0 0 transparent;
            }

            100% {
                box-shadow: 8px 0 0 black, 16px 0 0 black;
            }
        }
    </style>
</head>

<body>
    <h2>Real-time Chat</h2>

    <textarea id="messageInput" rows="4" cols="40" placeholder="Type a message..."></textarea><br>
    <button onclick="sendMessage()">Send Message</button>

    <div id="typing"></div>
    <ul id="messages"></ul>
    <span id="loading-dots">•</span>

    <script>
        const dots = document.getElementById('loading-dots');
        let count = 1;

        setInterval(() => {
        dots.textContent = '•'.repeat(count);
        count = (count % 3) + 1;
        }, 500);


        const socket = io("http://192.168.1.104:3000");

        let typingTimeout;
        let isTyping = false;

        socket.on("connect", () => {
            console.log("✅ Connected to server:", socket.id);
        });

        socket.on("receive-message", (data) => {
            console.log("📥 Received message from server:", data);
            const messageList = document.getElementById("messages");
            const item = document.createElement("li");
            item.textContent = `From ${data.sender_id} to ${data.receiver_id}: ${data.message}`;
            messageList.appendChild(item);
        });

        socket.on("typing", (data) => {
            console.log(`✏️ [typing event received] ${data.sender_name} is typing...`);
            document.getElementById("typing").textContent = `${data.sender_name} is typing...`;
        });

        socket.on("stop-typing", (data) => {
            console.log(`🛑 [stop-typing event received] ${data.sender_name} stopped typing.`);
            document.getElementById("typing").textContent = '';
        });

        const messageInput = document.getElementById("messageInput");

        messageInput.addEventListener("input", () => {
            console.log("⌨️ User input detected");
            //   document.getElementById("typing").innerHTML = 'typing...';

            if (!isTyping) {
                isTyping = true;
                console.log("🚀 Emitting 'typing' event");
                socket.emit("typing", {
                    sender_id: 2,
                    sender_name: "User 2"
                });
            }

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
                console.log("⌛ Timeout reached, emitting 'stop-typing'");
                // document.getElementById("typing").innerHTML = '';
                socket.emit("stop-typing", {
                    sender_id: 2,
                    sender_name: "User 2"
                });
            }, 1500);
        });

        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) {
                console.log("⚠️ Cannot send empty message.");
                return;
            }

            const messageData = {
                id: Math.floor(Math.random() * 1000),
                sender_id: 2,
                receiver_id: "6",
                message: message,
                image_path: null,
                reply_to_id: null,
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString()
            };

            console.log("📤 Sending message:", messageData);
            socket.emit("send-message", messageData);
            messageInput.value = "";
        }
    </script>
</body>

</html>
