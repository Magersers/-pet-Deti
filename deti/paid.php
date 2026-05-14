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
    <title>ЭнергоКидс — Оплата прошла успешно</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="success-page">
<div class="stars"></div>
<div class="container">
    <div class="reward-layout">
        <img src="assets/images/nagrada.png" alt="Награда за оплату" class="reward-image">
        <a class="logout-btn" href="receipt_pdf.php" id="downloadReceiptBtn">Скачать чек (PDF)</a>
        <a class="logout-btn reward-exit-btn" href="logout.php">Выйти</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/script.js"></script>
<script>
    (function () {
        const link = document.getElementById('downloadReceiptBtn');
        if (link) {
            setTimeout(() => link.click(), 450);
        }
    })();
</script>
</body>
</html>
