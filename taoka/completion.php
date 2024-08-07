<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文完了</title>
    <link rel="stylesheet" href="orderComplete.css">
</head>
<body>
    <div class="orderComplete">
        <h1>注文が完了しました</h1>
        <p>ご注文いただき、ありがとうございます。</p>
        <p>ご注文番号: <?php echo htmlspecialchars($_SESSION['orderNumber'] ?? ''); ?></p>
        <a href="index.php">トップページへ戻る</a>
    </div>
</body>
</html>
