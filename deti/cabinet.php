<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['child_user'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детский кабинет — Успешный вход</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="success-page">
<div class="stars"></div>
<div class="container">
    <div class="auth-card success-card">
        <h1>Ура, <?= $user['login'] ?>! 🎉</h1>
        <p class="subtitle">Ты успешно вошел в детский личный кабинет.</p>
        <p class="subtitle">Это 1 этап готов ✅<br>Следующий шаг — форма передачи показаний.</p>

        <a class="logout-btn" href="logout.php">Выйти</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
