<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mail = $_POST["mail"];
    $login = $_POST["login"];
    $pass = $_POST["pass"];

    setcookie("user_login", $login, time() + 100, "/");
    setcookie("user_pass", $pass, time() + 100, "/");
    setcookie("user_mail", $mail, time() + 100, "/");

header("Location: index.php");
exit();
}else{
    echo"Данные не получены господа";
    }
?>