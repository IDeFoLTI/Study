<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>"Cookie"</title>
</head>

<body>
    <style>

    </style>
    <div class="container">
        <div class="container-form">
            <form class="Main" action="cook.php" method="post">
                <input type="email" name="mail" placeholder="Почта" required>
                <input type="text" name="login" placeholder="Логин" required>
                <input type="password" name="pass" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
        </div>
    </div>
</body>
<!--Выводим сохранённые данные печенья-->
<?php
if (isset($_COOKIE["user_login"])) {
    echo "1 Этап <br>";
    if (isset($_COOKIE["user_mail"])) {
        echo "2 этап пройден <br>";
        if (isset($_COOKIE["user_pass"])) {
            echo "Сработало";
        }
    }
} else {
    echo "не работает";
}
?>
<?php
function validateEmail($mail) {
    if (!filter_var($_COOKIE["user_mail"], FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('<br>Некорректный email');
    }
    return true;
}

try {
    validateEmail('invalid-email');
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
?>
</html>