<?php
if(isset($_COOKIE['user'])){
    $user =($_COOKIE['user']);
}
else {
    $user = 'Аноним';
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1> Привет, <?php echo $user;?> ! </h1>
</body>