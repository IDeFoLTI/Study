<!DOCTYPE html>
<himl lang = 'ru'>
    <head>
        <title>Текущая погода</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <form method="post">
                Введите название города<br>
                <input type="text" name="city">
	            <input type="submit" value="Ну давай узнаем почему у нас такой сильный гололед">
            </form>
        </div>
    </body>
</himl>

<?php
$apiKey='6b62ee70507b39c22b690df511aec294';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city = urlencode(trim($_POST['city']));
    
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=ru";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    curl_close($curl);
    
    $data = json_decode($response, true);
    
    if ($data['cod'] == 200) {
        echo "Город: " . $_POST['city'] . "<br>".
        "Температура: " . round($data['main']['temp']) . "°C". "<br>".
        "Погода: " . ($data['weather'][0]['description']). "<br>".
        "Влажность: " . ($data['main']['humidity']) . '%'. "<br>";
    } else {
        echo "Ошибка: " . 'Что-то пошло не так';
    }
}
?>