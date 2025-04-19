<!DOCTYPE html>
<html>
<head>
    <title>Ratings & Comments</title>
</head>
<body>
    <h1>Rate a Service</h1>
    <form method="POST" action="{{ route('rate.service') }}">
        @csrf
        <input type="number" name="service_id" placeholder="Service ID" required>
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <button type="submit">Rate Service</button>
    </form>

    <h1>Rate a Shop</h1>
    <form method="POST" action="{{ route('rate.shop') }}">
        @csrf
        <input type="number" name="shop_id" placeholder="Shop ID" required>
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <button type="submit">Rate Shop</button>
    </form>

    <h1>Rate a Technician</h1>
    <form method="POST" action="{{ route('rate.technician') }}">
        @csrf
        <input type="number" name="technician_id" placeholder="Technician ID" required>
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <button type="submit">Rate Technician</button>
    </form>

    <h1>Comment on a Service</h1>
    <form method="POST" action="{{ route('comment.service') }}">
        @csrf
        <input type="number" name="service_id" placeholder="Service ID" required>
        <input type="number" name="user_id" placeholder="User ID" required>
        <textarea name="comment" placeholder="Your comment..." required></textarea>
        <button type="submit">Add Comment</button>
    </form>

    <h1>Reply to a Comment</h1>
    <form method="POST" action="{{ route('comment.reply') }}">
        @csrf
        <input type="number" name="comment_id" placeholder="Comment ID" required>
        <input type="number" name="user_id" placeholder="User ID" required>
        <textarea name="reply" placeholder="Your reply..." required></textarea>
        <button type="submit">Reply</button>
    </form>
</body>
</html>
