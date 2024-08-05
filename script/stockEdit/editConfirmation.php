<?php
session_start();

// セッションからデータを取得
$products = $_SESSION['product'] ?? [];
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
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productNumber']); ?></td>
                            <td><?php echo htmlspecialchars($product['productName']); ?></td>
                            <td><?php echo htmlspecialchars($_POST['stock'][$product['productNumber']] ?? $product['stock']); ?></td>
                            <td><?php echo htmlspecialchars($_POST['method'][$product['productNumber']] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($_POST['value'][$product['productNumber']] ?? ''); ?></td>
                            <td><?php echo isset($_POST['allow_overflow'][$product['productNumber']]) ? '注文可能' : '注文不可'; ?></td>
                        </tr>
                        <input type="hidden" name="stock[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($_POST['stock'][$product['productNumber']] ?? $product['stock']); ?>">
                        <input type="hidden" name="method[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($_POST['method'][$product['productNumber']] ?? ''); ?>">
                        <input type="hidden" name="value[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($_POST['value'][$product['productNumber']] ?? ''); ?>">
                        <input type="hidden" name="allow_overflow[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo isset($_POST['allow_overflow'][$product['productNumber']]) ? '1' : '0'; ?>">
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
