<?php
session_start();

// フォームデータを取得
$formData = $_POST;

// データベース接続設定
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品コードのリストを取得
$productNumbers = array_keys($formData['stock'] ?? []);

// 商品情報を取得
$products = $storeSQL->productEditSelect($pdo, $productNumbers);
$productsMap = [];

// 商品情報を商品コードをキーにしてマップする
foreach ($products as $product) {
    $productsMap[$product['productNumber']] = $product;
}

// フォームデータに基づいて商品情報を更新
foreach ($formData['stock'] as $productNumber => $stock) {
    if (isset($productsMap[$productNumber])) {
        $productsMap[$productNumber]['stock'] = htmlspecialchars($stock);
        $productsMap[$productNumber]['method'] = htmlspecialchars($formData['method'][$productNumber] ?? '');
        $productsMap[$productNumber]['value'] = htmlspecialchars($formData['value'][$productNumber] ?? '');
        $productsMap[$productNumber]['allow_overflow'] = htmlspecialchars($formData['allow_overflow'][$productNumber] ?? '');
        $productsMap[$productNumber]['disallow_overflow'] = htmlspecialchars($formData['disallow_overflow'][$productNumber] ?? '');
    }
}

$_SESSION['confirm_data'] = $productsMap;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>在庫更新確認</h1>
            <p>以下の内容で在庫を更新します。よろしいですか？</p>
        </div>
        <div class="content">
            <form action="updateInventory.php" method="POST">
                <table class="edit-table">
                    <thead>
                        <tr>
                            <th>商品コード</th>
                            <th>商品名</th>
                            <th>在庫数</th>
                            <th>指定方法</th>
                            <th>設定値</th>
                            <th>在庫数を超えた注文</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productsMap as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productNumber']); ?></td>
                            <td><?php echo htmlspecialchars($product['productName']); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><?php echo htmlspecialchars($product['method']); ?></td>
                            <td><?php echo htmlspecialchars($product['value']); ?></td>
                            <td><?php echo htmlspecialchars($product['allow_overflow'] ? '注文可能' : '注文不可'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="hidden" name="confirm" value="yes">
                <button type="submit">更新</button>
                <button type="button" onclick="window.history.back();">戻る</button>
            </form>
        </div>
    </div>
</body>
</html>
