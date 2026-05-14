<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}

$receiptData = $_SESSION['receipt_data'] ?? null;
if (!$receiptData) {
    header('Location: cabinet.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЭнергоКидс — Квитанция на оплату</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="success-page meter-page">
<div class="stars"></div>
<div class="container">
    <div class="auth-card meter-card receipt-page-card pulse">
        <img src="assets/images/logo_Deti.png" alt="Логотип ЭСВ" class="auth-logo meter-logo">
        <h1>Этап 3: Квитанция готова 🧾</h1>
        <p class="subtitle">Проверь данные и нажми кнопку оплаты.</p>

        <section class="receipt" aria-label="Квитанция на оплату">
            <div class="receipt-head">
                <strong>КВИТАНЦИЯ НА ОПЛАТУ ЭЛЕКТРОЭНЕРГИИ</strong>
                <span>№ <?= htmlspecialchars($receiptData['receiptNumber'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <div class="receipt-grid">
                <div><span>Получатель:</span> АО «ЭнергоСбыт Детям»</div>
                <div><span>ИНН/КПП:</span> 7701234567 / 770101001</div>
                <div><span>Плательщик:</span> <?= htmlspecialchars($receiptData['payer'], ENT_QUOTES, 'UTF-8') ?></div>
                <div><span>Период:</span> <?= htmlspecialchars($receiptData['period'], ENT_QUOTES, 'UTF-8') ?></div>
                <div><span>Показание:</span> <?= (int) $receiptData['currentReading'] ?> кВт·ч</div>
                <div><span>Дата:</span> <?= htmlspecialchars($receiptData['date'], ENT_QUOTES, 'UTF-8') ?></div>
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
                    <td><?= htmlspecialchars($receiptData['tariff'], ENT_QUOTES, 'UTF-8') ?> ₽/кВт·ч</td>
                    <td><?= htmlspecialchars($receiptData['amount'], ENT_QUOTES, 'UTF-8') ?> ₽</td>
                </tr>
                <tr>
                    <td>Сервисный сбор</td>
                    <td>—</td>
                    <td><?= htmlspecialchars($receiptData['serviceFee'], ENT_QUOTES, 'UTF-8') ?> ₽</td>
                </tr>
                </tbody>
            </table>

            <div class="receipt-total">ИТОГО К ОПЛАТЕ: <b><?= htmlspecialchars($receiptData['amount'], ENT_QUOTES, 'UTF-8') ?> ₽</b></div>
            <button type="button" class="pay-btn">Оплатить квитанцию 💳</button>
        </section>

        <a class="logout-btn" href="logout.php">Выйти</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
