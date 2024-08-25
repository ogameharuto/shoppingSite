<?php
session_start();

// 商品一覧ページから送信された選択された商品のIDを取得
$products = $_SESSION['product'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmUpdate() {
            return confirm("商品を更新してもよろしいですか？");
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>商品情報編集</h1>
            <p>商品の情報を編集します。変更内容を確認してください。</p>
        </div>
        <div class="content">
            <!-- enctype を追加 -->
            <form action="updateInventory.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmUpdate();">
                <table class="edit-table">
                    <thead>
                        <tr>
                            <th>商品コード</th>
                            <th>現在の商品画像</th>
                            <th>編集する商品画像</th>
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
                                <?php if (!empty($product['imageHash'])): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100">
                                <?php else: ?>
                                    画像なし
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="file" name="productImage[<?php echo htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>]">
                            </td>
                            <td>
                                <input type="text" name="productName[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['productName']); ?>">
                            </td>
                            <td>
                                <input type="text" name="price[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['price']); ?>">
                            </td>
                            <td>
                                <input type="text" name="dateAdded[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['dateAdded']); ?>">
                            </td>
                            <td>
                                <input type="text" name="releaseDate[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['releaseDate']); ?>">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">確認</button>
                <button type="button" onclick="window.history.back();">キャンセル</button>
            </form>
        </div>
    </div>
</body>
</html>
