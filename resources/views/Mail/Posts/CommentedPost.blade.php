<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Comment Notification</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #007bff;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            overflow: hidden;
            border-top: 8px solid #007BFF;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img.logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-info img.user-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid #2990ff; /* Adds a rounded gray border */
        }
        .user-info-text {
            font-size: 16px;
            color: #333;
        }
        .user-info-text strong {
            color: #007BFF;
        }
        .comment-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007BFF;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #999;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="#" alt="Your Company Logo" class="logo">
        <h1>New Comment Notification</h1>
    </div>
    <div class="content">
        <!-- User info container -->
        <div class="user-info">
            <img src="{{  $userAvatar   ? $message->embed($userAvatar) : $message->embed("") }}"  class="user-image">
            <div class="user-info-text">
                <a href="{{ route('users.show', $comment->user->id) }}">
                    <strong>{{ $comment->user->name }}</strong>
                </a>
                has commented on your post:
            </div>
        </div>
        <p>Your post titled "<strong>{{ $comment->commentable->title }}</strong>" has received a new comment:</p>
        <div class="comment-box">
            "{{ $comment->content }}"
        </div>
        <a href="{{ route('posts.show', $comment->commentable->id) }}">View Post</a>
    </div>
    <div class="footer">
        &copy; 2024 Your Company. All rights reserved. <br>
        <a href="https://yourcompany.com/unsubscribe">Unsubscribe</a> from these notifications.
    </div>
</div>
</body>
</html>
