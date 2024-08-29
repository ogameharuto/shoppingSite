<?php
$user = $_SESSION['customer'];
$userId = $user['customerNumber'];
$userName = $user['customerName'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yahoo! JAPAN ショッピング</title>
    <link rel="stylesheet" href="header.css">
    <script>
        function performSearch() {
            const query = document.getElementById('search-input').value;
            if (query.trim() !== '') {
                const url = 'http://localhost/shopp/script/productSearchList/productSearchListMain.php?query=' + encodeURIComponent(query);
                window.location.href = url;
            }
        }
    </script>
</head>
<body>
    <header class="header">
        <div class="top-bar topheader">
            <div class="logo">
                <a href="http://localhost/shopp/script/clientToppage.php">
                    <img src="http://localhost/shopp/taoka/Yahoo_Syopping_Logo.png" alt="Yahoo! JAPAN" onclick="location.reload()">
                </a>
            </div>
            <div class="user-info">
                <p>ようこそ、<?php echo htmlspecialchars($_SESSION['customer']['customerName'], ENT_QUOTES, 'UTF-8'); ?> さん LYPプレミアム会員登録 (合計3,000円相当プレゼント！最大3ヶ月無料でお試し)</p>
            </div>
            <div class="top-links">
                <a href="http://localhost/shopp/script/login/loginMenu.php">Yahoo! JAPAN 無料でお店を開こう！</a>
                <a href="login/clientLogOut.php">ログアウト</a>
            </div>
        </div>
        <div class="middle-bar">
            <p>毎日5% - LYPプレミアム特典 + 2%の商品券付与終了について </p>
        </div>
        <div class="bottom-bar">
            <div class="search-container">
                <input type="text" name="searchTerm" id="search-input" placeholder="何をお探しですか？">
                <button onclick="performSearch()">検索</button>
            </div>
            <div class="nav-icons">
                <a href="http://localhost/shopp/script/cart/cartMain.php?userId=<?php echo urlencode($userId); ?>" class="icon cart">カート</a>
                <a href="http://localhost/shopp/script/productDetails/favoriteList.php?userId=<?php echo urlencode($userId); ?>" class="icon favorites">お気に入り</a>
                <a href="UOdr01.php?userId=<?php echo urlencode($userId); ?>" class="icon orders">注文履歴</a>
                <a href="http://localhost/shopp/script/myPage.php?userId=<?php echo urlencode($userId); ?>" class="icon profile">マイページ</a>
            </div>
        </div>
    </header>
</body>
</html>
