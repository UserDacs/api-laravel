<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messaging Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Messaging Demo</h2>

<div>
    <h3>Send Message</h3>
    <form id="sendMessageForm">
        <input type="hidden" name="receiver_id" value="8"> {{-- Dummy receiver for testing --}}
        <input type="hidden" name="reply_to_id" id="reply_to_id">
        <textarea name="message" placeholder="Type your message..."></textarea>
        <br>
        <input type="file" name="image" id="image">
        <br>
        <button type="submit">Send</button>
    </form>
</div>

<hr>

<div>
    <h3>Inbox</h3>
    <button id="loadInbox">Load Inbox</button>
    <ul id="inboxList"></ul>
</div>

<hr>

<div>
    <h3>Conversation with User #2</h3>
    <button id="loadConversation">Load Conversation</button>
    <ul id="conversationList"></ul>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sendMessageForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '/api/message/send',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: res => {
                alert(res.message);
                $('#sendMessageForm')[0].reset();
            },
            error: err => {
                alert('Error sending message');
            }
        });
    });

    $('#loadInbox').on('click', function () {
        $.get('/api/message/inbox', function (res) {
            $('#inboxList').html('');
            res.forEach(msg => {
                $('#inboxList').append(`<li><strong>From:</strong> ${msg.sender.name}<br>${msg.message}<br><small>${msg.created_at}</small></li>`);
            });
        });
    });

    $('#loadConversation').on('click', function () {
        $.get('/api/message/conversation/0', function (res) {
            $('#conversationList').html('');
            res.forEach(msg => {
                $('#conversationList').append(`<li>
                    <strong>${msg.sender_id === {{ auth()->id() }} ? 'You' : 'Them'}:</strong> ${msg.message}
                    <br><small>${msg.created_at}</small>
                </li>`);
            });
        });
    });
</script>
</body>
</html>
