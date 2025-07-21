<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Suspension Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .notice-container {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            max-width: 900px;
            text-align: center;
        }
        .notice-container h1 {
            font-size: 24px;
            color: #d9534f;
            margin-bottom: 15px;
        }
        .notice-container p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        .notice-container a {
            text-decoration: none;
            background-color: #0275d8;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
        }
        .notice-container a:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="notice-container">
            <h1>System Suspended</h1>
            @if(isset($message))
            <div class="alert alert-danger">{!! $message !!}</div>
        @endif
    </div>
</body>
</html>
