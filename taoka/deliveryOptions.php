<?php
// セッション開始
session_start();

// データベース接続
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$current_page = basename($_SERVER['PHP_SELF']);

// ストア番号を取得
$storeNumber = $_SESSION['store']['storeNumber'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="../script/stockEdit/productStructure.css">
    <script src="product.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="navbar">
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">ページ編集</a>
                <a href="http://localhost/shopp/taoka/productManagerMenu.php"
                    class="nav-item <?php echo ($current_page == 'productManagerMenu.php') ? 'active' : ''; ?>">商品管理</a>
                <a href="http://localhost/shopp/script/stockEdit/productStructure.php"
                    class="nav-item <?php echo ($current_page == 'productStructure.php') ? 'active' : ''; ?>">在庫管理</a>
                <a href="http://localhost/shopp/script/imageIns/imageInsMenu.php"
                    class="nav-item <?php echo ($current_page == 'imageInsMenu.php') ? 'active' : ''; ?>">画像管理</a>
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">カテゴリ管理</a>
            </div>
        </div>
        <div class="content">
            <form id="productForm" method="POST" action="delete_products.php">
                <label>配達方法</label>
                <select name="deliveryOptions">
                    <option value="宅配便">宅配便</option>
                    <option value="即日宅配便">即日宅配便</option>
                </select>
                
            </form>
        </div>
    </div>
</body>

<script>
    function checkDel() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        if (checkboxes.length === 0) {
            alert("削除する商品を選んでください.");
            return;
        }
        else if (confirm('削除しますか？')) {
            return true;
        } else {
            alert('キャンセルされました');
            return false;
        }
    }
    function handleEditButtonClick() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        if (checkboxes.length === 0) {
            alert("編集する商品を選んでください.");
            return;
        }

        const selectedItems = [];
        checkboxes.forEach((checkbox) => {
            selectedItems.push(checkbox.value);
        });

        // POST リクエストを送信
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../script/productEdit/editProductInventoryMain.php';

        selectedItems.forEach((item) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product[]';
            input.value = item;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
</script>

</html>