<?php
session_start();

// 商品一覧ページから送信された選択された商品のIDを取得
if (isset($_SESSION['product'])) {
   $products = $_SESSION['product'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Edit Inventory</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmUpdate() {
            return confirm("在庫を更新してもよろしいですか？");
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>在庫編集</h1>
            <p>在庫設定の指定方法を選択し、在庫数を入力します。</p>
        </div>
        <div class="buttons">
            <button type="submit">確認</button>
            <button type="button" onclick="window.history.back();">キャンセル</button>
        </div>
        <div class="content">
        <form action="updateInventory.php" method="POST" onsubmit="return confirmUpdate();">
            <table class="edit-table">
                <thead>
                    <tr>
                        <th>商品コード</th>
                        <th>商品名/オプション</th>
                        <th>在庫数</th>
                        <th>指定方法</th>
                        <th>設定値</th>
                        <th>在庫数を超えた注文</th>
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
                        <td><?php echo htmlspecialchars($product['productName']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($product['stock']); ?>
                        </td>
                        <td>
                            <select name="method[<?php echo htmlspecialchars($product['productNumber']); ?>]">
                                <option value="足す">足す</option>
                                <option value="引く">引く</option>
                                <option value="値にする">値にする</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="value[<?php echo htmlspecialchars($product['productNumber']); ?>]">
                        </td>
                        <td>
                            <input type="radio" name="allow_overflow[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="1"> 注文可能
                            <input type="radio" name="disallow_overflow[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="0"> 注文不可
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">在庫を更新</button>
        </form>
        </div>
    </div>
</body>
</html>
