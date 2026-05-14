<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['child_user'];
$readingError = '';
$readingSuccess = '';
$showReceipt = false;
$receiptData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentReading = (int) ($_POST['current_reading'] ?? -1);

    if ($currentReading < 0) {
        $readingError = 'Введи корректное показание счётчика, чтобы отправить данные ⚡';
    } else {
        $tariff = 5.67;
        $serviceFee = 35;
        $amount = round(($currentReading * $tariff) + $serviceFee, 2);
        $receiptNumber = 'ESV-' . date('Ymd') . '-' . random_int(1000, 9999);

        $receiptData = [
            'receiptNumber' => $receiptNumber,
            'payer' => $user['login'],
            'currentReading' => $currentReading,
            'tariff' => number_format($tariff, 2, ',', ' '),
            'serviceFee' => number_format($serviceFee, 2, ',', ' '),
            'amount' => number_format($amount, 2, ',', ' '),
            'period' => date('m.Y'),
            'date' => date('d.m.Y'),
        ];

        $readingSuccess = "Отлично! Показание {$currentReading} кВт·ч принято. Этап 3 — готова квитанция на оплату. 🌟";
        $showReceipt = true;
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
            <img src="assets/images/logo_Deti.png" alt="Логотип ЭСВ" class="auth-logo meter-logo">
            <h1>Привет, <?= $user['login'] ?>! ⚡</h1>
            <p class="subtitle">Этап 2: передай текущее показание счётчика за электричество и получи звание ЭнергоГероя!</p>

            <?php if ($readingError !== ''): ?>
                <div class="error-box"><?= $readingError ?></div>
            <?php endif; ?>

            <?php if ($readingSuccess !== ''): ?>
                <div class="success-box"><?= $readingSuccess ?></div>
            <?php endif; ?>

            <form method="post" class="auth-form meter-form">
                <label for="current_reading">Текущее показание (кВт·ч)</label>
                <input type="number" id="current_reading" name="current_reading" min="0" placeholder="Например: 1296" required>

                <button type="submit" id="readingBtn">Передать показания ✨</button>
            </form>

            <?php if ($showReceipt): ?>
                <section class="receipt" aria-label="Квитанция на оплату">
                    <div class="receipt-head">
                        <strong>КВИТАНЦИЯ НА ОПЛАТУ ЭЛЕКТРОЭНЕРГИИ</strong>
                        <span>№ <?= $receiptData['receiptNumber'] ?></span>
                    </div>

                    <div class="receipt-grid">
                        <div><span>Получатель:</span> АО «ЭнергоСбыт Детям»</div>
                        <div><span>ИНН/КПП:</span> 7701234567 / 770101001</div>
                        <div><span>Плательщик:</span> <?= htmlspecialchars($receiptData['payer'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div><span>Период:</span> <?= $receiptData['period'] ?></div>
                        <div><span>Показание:</span> <?= $receiptData['currentReading'] ?> кВт·ч</div>
                        <div><span>Дата:</span> <?= $receiptData['date'] ?></div>
                    </div>

                    <table class="receipt-table">
                        <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Тариф</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Электроснабжение</td>
                            <td><?= $receiptData['tariff'] ?> ₽/кВт·ч</td>
                            <td><?= $receiptData['amount'] ?> ₽</td>
                        </tr>
                        <tr>
                            <td>Сервисный сбор</td>
                            <td>—</td>
                            <td><?= $receiptData['serviceFee'] ?> ₽</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="receipt-total">ИТОГО К ОПЛАТЕ: <b><?= $receiptData['amount'] ?> ₽</b></div>
                    <button type="button" class="pay-btn">Оплатить квитанцию 💳</button>
                </section>
            <?php endif; ?>

            <a class="logout-btn" href="logout.php">Выйти</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
