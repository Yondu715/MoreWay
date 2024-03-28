<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сброс пароля</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            background-color: #f7f7f7;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-bottom: 10px;
            font-weight: normal;
        }
        h1 {
            font-size: 24px;
        }
        p {
            margin-bottom: 15px;
        }
        a {
            color: #337ab7;
            text-decoration: none;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }
        .header {
            margin-bottom: 20px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        .code {
            font-family: monospace;
            font-size: 18px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Сброс пароля</h1>
    </div>
    <p>
        Ваш код для сброса пароля:
    </p>
    <div class="code">
        {{ $resetCode }}
    </div>
    <p>
        Чтобы сбросить пароль, пожалуйста, используйте этот код.
    </p>
    <p>
        Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.
    </p>
    <div class="footer">
        <p>
            С уважением,<br>
            Команда нашего сервиса
        </p>
    </div>
</div>
</body>
</html>
