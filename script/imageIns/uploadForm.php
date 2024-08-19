<?php
session_start();
require_once('../utilConnDB.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// ストア番号をセッションから取得
$storeNumber = isset($_SESSION['store']['storeNumber']) ? $_SESSION['store']['storeNumber'] : '';

if ($storeNumber) {
    // 商品リストを取得
    $sql = 'SELECT productNumber, productName FROM product WHERE storeNumber = :storeNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'SQLエラー: ' . $e->getMessage();
        $products = [];
    }
    
    $utilConnDB->disconnect($pdo);
} else {
    echo 'ストア番号が設定されていません。';
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="uploadForm.css">
    <title>画像アップロード</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">画像ファイル:</label>
        <input type="file" name="image" id="image" required>
        <label for="productNumber">商品番号:</label>
        <select name="productNumber" id="productNumber" required>
            <option value="">商品を選択してください</option>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['productNumber']); ?>">
                        <?php echo htmlspecialchars($product['productName']); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">商品がありません</option>
            <?php endif; ?>
        </select>
        <input type="hidden" name="storeNumber" value="<?php echo htmlspecialchars($storeNumber); ?>"> <!-- 店舗番号を設定 -->
        <button type="submit">アップロード</button>
    </form>
</body>
</html>
