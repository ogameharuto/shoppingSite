<?php
session_start();

// セッションからデータを取得
$products = $_SESSION['product'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームからのデータを取得
    $productNames = $_POST['productName'] ?? [];
    $prices = $_POST['price'] ?? [];
    $dateAdded = $_POST['dateAdded'] ?? [];
    $releaseDates = $_POST['releaseDate'] ?? [];
}
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
            <h1>商品情報確認</h1>
            <p>以下の内容で商品情報を更新します。よろしいですか？</p>
        </div>
        <div class="content">
            <form action="updateInventory.php" method="POST">
                <table class="edit-table">
                    <thead>
                        <tr>
                            <th>商品コード</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>特価</th>
                            <th>販売開始日</th>
                            <th>販売終了日</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productNumber']); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['productImageURL']); ?>" alt="Product Image" style="width: 50px; height: auto;">
                            </td>
                            <td>
                                <input type="text" name="productName[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($productNames[$product['productNumber']] ?? $product['productName']); ?>" readonly>
                            </td>
                            <td>
                                <input type="text" name="price[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($prices[$product['productNumber']] ?? $product['price']); ?>" readonly>
                            </td>
                            <td>
                                <input type="text" name="dateAdded[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($dateAdded[$product['productNumber']] ?? $product['dateAdded']); ?>" readonly>
                            </td>
                            <td>
                                <input type="text" name="releaseDate[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($releaseDates[$product['productNumber']] ?? $product['releaseDate']); ?>" readonly>
                            </td>
                        </tr>
                        <input type="hidden" name="productName[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($productNames[$product['productNumber']] ?? $product['productName']); ?>">
                        <input type="hidden" name="price[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($prices[$product['productNumber']] ?? $product['price']); ?>">
                        <input type="hidden" name="dateAdded[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($dateAdded[$product['productNumber']] ?? $product['dateAdded']); ?>">
                        <input type="hidden" name="releaseDate[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($releaseDates[$product['productNumber']] ?? $product['releaseDate']); ?>">
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="hidden" name="confirm" value="yes">
                <button type="submit">保存</button>
                <button type="button" onclick="window.history.back();">修正</button>
            </form>
        </div>
    </div>
</body>
</html>
