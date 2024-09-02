<?php
session_start();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: ../account/storeLoginMenu.php");
    exit();
}

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
    <link rel="stylesheet" href="../../css/styles.css">
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
        <div class="content">
        <form action="updateStock.php" method="POST" onsubmit="return confirmUpdate();">
            <table class="edit-table">
                <thead>
                    <tr>
                        <th>商品コード</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>在庫数</th>
                        <th>指定方法</th>
                        <th>設定値</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['productNumber']); ?></td>
                            <td>
                                <?php if (!empty($product['imageHash'])): ?>
                                    <img src="../../uploads/<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100">
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
