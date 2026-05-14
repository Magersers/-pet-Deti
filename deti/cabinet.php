<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['child_user'];
$readingError = '';
$readingSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prevReading = (int) ($_POST['prev_reading'] ?? 0);
    $currentReading = (int) ($_POST['current_reading'] ?? 0);
    $month = trim($_POST['month'] ?? '');

    if ($month === '' || $prevReading < 0 || $currentReading < 0) {
        $readingError = 'Заполни все поля правильно, чтобы мы смогли принять показания ⚡';
    } elseif ($currentReading < $prevReading) {
        $readingError = 'Текущее значение не может быть меньше предыдущего. Проверь цифры 👀';
    } else {
        $used = $currentReading - $prevReading;
        $readingSuccess = "Готово! За {$month} передано {$used} кВт·ч. Ты супер! 🌟";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЭнергоКидс — Передача показаний</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="success-page meter-page">
<div class="stars"></div>
<div class="container">
    <div class="auth-layout meter-layout">
        <div class="left-character-wrap meter-character-wrap" aria-hidden="true">
            <img src="assets/images/woman.png" alt="" class="left-character meter-character">
        </div>

        <div class="auth-card meter-card pulse">
            <h1>Привет, <?= $user['login'] ?>! ⚡</h1>
            <p class="subtitle">Этап 2: передай показания за электричество и получи звание ЭнергоГероя!</p>

            <?php if ($readingError !== ''): ?>
                <div class="error-box"><?= $readingError ?></div>
            <?php endif; ?>

            <?php if ($readingSuccess !== ''): ?>
                <div class="success-box"><?= $readingSuccess ?></div>
            <?php endif; ?>

            <form method="post" class="auth-form meter-form">
                <label for="month">Месяц передачи</label>
                <input type="text" id="month" name="month" placeholder="Например: Май 2026" required>

                <label for="prev_reading">Предыдущее показание (кВт·ч)</label>
                <input type="number" id="prev_reading" name="prev_reading" min="0" placeholder="Например: 1234" required>

                <label for="current_reading">Текущее показание (кВт·ч)</label>
                <input type="number" id="current_reading" name="current_reading" min="0" placeholder="Например: 1296" required>

                <button type="submit" id="readingBtn">Передать показания ✨</button>
            </form>

            <a class="logout-btn" href="logout.php">Выйти</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
