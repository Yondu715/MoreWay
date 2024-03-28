<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сброс пароля</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #F36D72;
        }
        .code {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            font-size: 24px;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777777;
            font-size: 14px;
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
