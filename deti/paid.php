<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЭнергоКидс — Платёж в обработке</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="success-page">
<div class="stars"></div>
<div class="container">
    <div class="auth-card pulse">
        <img src="assets/images/logo_Deti.png" alt="Логотип ЭСВ" class="auth-logo">
        <h1>Платёж отправлен! 🎉</h1>
        <p class="subtitle">Это страница-заглушка: оплата успешно имитирована для обучения.</p>
        <a class="logout-btn" href="cabinet.php">Вернуться к показаниям</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
