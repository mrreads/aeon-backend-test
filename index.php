<?php $auth = include_once('./includes/is_login.php') ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="./styles/general.css">
    <script src="./scripts/auth.js" defer></script>
</head>
<body data-auth="<?=($auth) ? 'true' : 'false' ?>">
    <div class="container">
       <div class="auth">
            <?php include __DIR__ . './view/auth.php'; ?>
       </div>
       <div class="info">
        <?php include __DIR__ . './view/info.php'; ?>
       </div>
    </div>
</body>
</html>