<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    
    <form action="./actions/auth.php" method="post">
        <input type="text" name="login" placeholder="Логин" require />
        <input type="password" name="password" placeholder="Пароль" require />
        <input type="submit" value="Войти" />
    </form>
</body>
</html>