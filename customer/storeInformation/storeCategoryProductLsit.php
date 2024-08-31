<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$storeNumber = isset($_GET['storeNumber']) ? (int)$_GET['storeNumber'] : null;

if ($storeNumber) {
    // ストア番号に基づくカテゴリを取得するクエリ
    $sql = 'SELECT storeCategoryNumber, storeCategoryName 
            FROM storecategory 
            WHERE storeNumber = :storeNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $storeCategoryNumber = isset($_GET['storeCategoryNumber']) ? (int)$_GET['storeCategoryNumber'] : null;

    if ($storeCategoryNumber) {
        // 商品と画像の情報を取得するクエリ
        $sql = 'SELECT p.productNumber, p.productName, p.productDescription, p.price, p.stockQuantity, p.pageDisplayStatus, i.imageName 
                FROM product p
                LEFT JOIN images i ON p.imageNumber = i.imageNumber
                WHERE p.storeNumber = :storeNumber AND p.storeCategoryNumber = :storeCategoryNumber AND p.pageDisplayStatus = 1';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
        $stmt->bindParam(':storeCategoryNumber', $storeCategoryNumber, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $products = [];
    }
} else {
    echo "ストア番号が指定されていません。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <link rel="stylesheet" href="../../css/storeInformation.css">
    <link rel="stylesheet" type="text/css" href="../../css/header.css" />
</head>
<body>
    <?php include "../header.php"; ?>
    <h1>カテゴリの商品一覧</h1>
        <div class="container">
        <div class="categories">
            <h2>カテゴリ</h2>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($category['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($category['storeCategoryName'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="products">
            <?php if (!empty($products)): ?>
                <div class="product-list">
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <?php if (!empty($product['imageName'])): ?>
                                <img src="../../uploads/<?= htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?>" class="product-image">
                            <?php else: ?>
                                <p>画像なし</p>
                            <?php endif; ?>
                            <div class="product-info">
                                <h2><a href="../productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?></a></h2>
                                <p>価格: <?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>円</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>このカテゴリには商品がありません。</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
