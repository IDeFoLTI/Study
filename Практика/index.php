<?php
if(isset($_POST['name'])){
    setcookie('user', $_POST['name'],[
        "expires" => time() + 60*30,
        "path" => "/",
    ]);
    header('Location: hisname.php');
    exit();
}
?>

<!DOCTYPE html>
<head>
    <meta charset="itf-8">
</head>
<body>
    <form method="post">
    <input type="text" name="name" placeholder="Введите Имя" />
    <button type="submit">Отправить</button>
    </form>
</body>