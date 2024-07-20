<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with ChatGPT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">Chat with ChatGPT</div>
        <div class="card-body">
            <div id="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                <div id="messages"></div>
            </div>
            <form id="chat-form">
                <div class="input-group mt-3">
                    <input type="text" id="user-message" class="form-control" placeholder="Type your message here...">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const userMessage = document.getElementById('user-message').value;
    const messagesDiv = document.getElementById('messages');

    // Display user message
    const userMessageDiv = document.createElement('div');
    userMessageDiv.className = 'alert alert-secondary';
    userMessageDiv.innerText = userMessage;
    messagesDiv.appendChild(userMessageDiv);

    // Clear input field
    document.getElementById('user-message').value = '';

    // Send message to the server
    fetch('chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: userMessage })
    })
    .then(response => response.json())
    .then(data => {
        // Display ChatGPT reply
        const botMessageDiv = document.createElement('div');
        botMessageDiv.className = 'alert alert-primary';
        botMessageDiv.innerText = data.reply;
        messagesDiv.appendChild(botMessageDiv);

        // Scroll to the bottom of the chat box
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    });
});
</script>
</body>
</html>
