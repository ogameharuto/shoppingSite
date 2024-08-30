<?php
session_start();
$storeNumber = $_SESSION['store'];

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}

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
        </div>
    </header>
    <div class="content-header">
        <span>お客様番号:<?php echo $storeNumber['storeNumber'] ?></span>
        <span class="name">お名前：<?php echo $storeNumber['companyRepresentative'] ?>さん</span>
        （<a href="login/logOut.php" class="logOut">ログアウト</a>）
    </div>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-section">
                <h2>ツールメニュー</h2>
                <ul class="sidebar-list">
                    <li class="collapsible">
                        <div class="collapsible-header">注文管理</div>
                        <div class="collapsible-content">
                        <p><a href="orderList.php">注文管理</a></p>
                        </div>
                    </li>
                    <li class="collapsible">
                        <div class="collapsible-header">商品・画像・在庫</div>
                        <div class="collapsible-content">
                            <p><a href="../taoka/productInsMenu.php">商品データ登録</a></p>
                            <p><a href="../taoka/productManagerMenu.php">商品管理</a></p>
                            <p><a href="productCategory/categoryManagement.php">カテゴリ管理</a></p>
                            <p><a href="imageIns/imageInsMenu.php">画像管理</a></p>
                            <p><a href="stockEdit/productStructure.php">在庫管理</a></p>
                        </div>
                    </li>
                    <li class="collapsible">
                        <div class="collapsible-header">ストア構築</div>
                        <div class="collapsible-content">
                            <p><a href="http://localhost/shopp/script/storeManagerMenu.php">ストア情報設定</a></p>
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


