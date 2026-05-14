<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login === '' || $password === '') {
        $error = 'Заполни логин и пароль, чтобы попасть в волшебный кабинет ✨';
    } else {
        $_SESSION['child_user'] = [
            'login' => htmlspecialchars($login, ENT_QUOTES, 'UTF-8'),
            'entered_at' => date('c'),
        ];

        header('Location: cabinet.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детский кабинет — Вход</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-page">
<div class="stars"></div>
<div class="container">
    <div class="auth-layout">
        <div class="left-character-wrap" aria-hidden="true">
            <img src="assets/images/men_sleva.png" alt="" class="left-character">
        </div>

        <div class="auth-card pulse">
            <img src="assets/images/logo_Deti.png" alt="Логотип ЭСВ" class="auth-logo">
            <h1>Добро пожаловать в ЭнергоКидс ⚡</h1>
            <p class="subtitle">Введи любой логин и пароль — и начнем приключение!</p>

            <?php if ($error !== ''): ?>
                <div class="error-box"><?= $error ?></div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <label for="login">Логин супергероя</label>
                <input type="text" id="login" name="login" placeholder="Например: kotik123" required>

                <label for="password">Секретный пароль</label>
                <input type="password" id="password" name="password" placeholder="Любой пароль" required>

                <button type="submit" id="loginBtn">Войти в кабинет 🚀</button>
            </form>
        </div>
    </div>
</div>

<script src="../jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
