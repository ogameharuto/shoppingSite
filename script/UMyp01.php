<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="UMyp01.css">
    <link rel="stylesheet" href="header.css">
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }
    </script>
</head>
<body>
<?php include "header.php"; ?>
    <h2>マイページ</h2>

    <nav>
        <div class="left-side">
            <h4 class="box">
                <a href="https://www.google.com/">会員情報を見る</a>
            </h4>
        </div>
        <div class="right-side">
            <ul>
                <li><button onclick="navigateTo('orders.php')">注文履歴</button></li>
                <li><button onclick="navigateTo('usage.php')">利用履歴</button></li>
                <li><button onclick="navigateTo('support.php')">サポート</button></li>
                <li><button onclick="navigateTo('coupons.php')">クーポン</button></li>
                <li><button onclick="navigateTo('reviews.php')">マイレビュー</button></li>
            </ul>
        </div>
    </nav>
    <footer>
        
    </footer>
</body>
</html>
