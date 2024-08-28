<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Greeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }
        .greeting {
            font-size: 24px;
            color: #333333;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="email-container">
    <p class="greeting">
        Hi ! <?php echo e($comment->commentable->user->name); ?>

    </p>
</div>
</body>
</html>
<?php /**PATH C:\MyStudies\My_repo\Simple_Blog_Post\resources\views\Mail\Posts\CommentedPost.blade.php ENDPATH**/ ?>