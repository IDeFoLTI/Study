<!DOCTYPE html>
<html>
        <h1>
            1 Задание Напишите PHP-скрипт, который читает JSON из файла products.json с информацией о товарах (название, категория, цена), а затем возвращает список товаров, чья цена выше 1000.
        </h1>
</html>
<?php
$json = file_get_contents('Products.json');

$data = json_decode($json, true);
print_r($data);
$highPrice = array_filter($data, function($price) {
return $price['price'] >= 1000;});

header('Content-Type: application/json');
echo json_encode(array_values($highPrice), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>