<?php
session_start();
$storeNumber = $_SESSION['store'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="storeToppage.css">
    <title>ストアクリエイターPro</title>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <h1>Yahoo! JAPAN ストアクリエイターPro</h1>
            </div>
            <div class="header-links">
                <a href="#">Yahoo! JAPAN</a> | 
                <a href="#">Yahoo! ビジネスセンター</a> | 
                <a href="#">マニュアル</a> | 
                <a href="#">FAQ</a> | 
                <a href="#">お問い合わせ</a>
            </div>
        </div>
    </header>
    <div class="content-header">
        <span>お客様番号:<?php echo $storeNumber['storeNumber'] ?></span>
        <span class="name">お名前：<?php echo $storeNumber['companyRepresentative'] ?>さん</span>
        （<a href="" class="">登録情報</a>-
        <a href="loginMenu.php" class="logOut">ログアウト</a>）
    </div>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-section">
                <h2>お知らせ</h2>
                <ul class="sidebar-list">
                    <li class="subTitle">注文管理</li>
                    <li>新規注文 <span class="badge">〇件</span></li>
                    <li>注文未完了 <span class="badge">〇件</span></li>
                </ul>
                <ul class="sidebar-list">
                    <li class="subTitle">お問い合わせ管理ツール</li>
                    <li>未回答 <span class="badge">〇件</span></li>
                </ul>
            </div>
            <div class="sidebar-section">
                <h2>ツールメニュー</h2>
                <ul class="sidebar-list">
                    <li class="collapsible">
                        <div class="collapsible-header">注文管理</div>
                        <div class="collapsible-content">
                        <p><a href="">注文検索</a></p>
                        <p><a href="">注文管理設定</a></p>
                        </div>
                    </li>
                    <li class="collapsible">
                        <div class="collapsible-header">商品・画像・在庫</div>
                        <div class="collapsible-content">
                            <p><a href="">商品データ登録</a></p>
                            <p><a href="../taoka/productManagerMenu.php">商品管理</a></p>
                            <p><a href="">カテゴリ管理</a></p>
                            <p><a href="">画像管理</a></p>
                            <p><a href="stockEdit/productStructure.php">在庫管理</a></p>
                        </div>
                    </li>
                    <li class="collapsible">
                        <div class="collapsible-header">ストア構築</div>
                        <div class="collapsible-content">
                            <p><a href="">ストア情報設定</a></p>
                            <p><a href="">カート設定</a></p>
                            <p><a href="">配送日情報設定</a></p>
                            <p><a href="">ストアエディタ基本設定</a></p>
                            <p><a href="">ページ編集</a></p>
                            <p><a href="">ストアデザイン</a></p>
                            <p><a href="">反映管理</a></p>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="content">
            <div class="content-body">
                <div class="notifications">
                    
                </div>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var collapsibleHeaders = document.querySelectorAll('.collapsible-header');

        collapsibleHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                var content = this.nextElementSibling;
                if (content.style.display === 'block') {
                    content.style.display = 'none';
                } else {
                    content.style.display = 'block';
                }
            });
        });
    });
    </script>
</body>
</html>


