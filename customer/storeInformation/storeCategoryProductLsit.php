<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$storeNumber = isset($_GET['storeNumber']) ? (int)$_GET['storeNumber'] : null;

if ($storeNumber) {
    $storeCategoryNumber = isset($_GET['storeCategoryNumber']) ? (int)$_GET['storeCategoryNumber'] : null;

    if ($storeCategoryNumber) {
        // 親カテゴリとその小カテゴリを含むすべての商品を取得するクエリ
        $sql = 'SELECT p.productNumber, p.productName, p.productDescription, p.price, p.stockQuantity, p.pageDisplayStatus, i.imageName 
                FROM product p
                LEFT JOIN images i ON p.imageNumber = i.imageNumber
                WHERE p.storeNumber = :storeNumber 
                AND (p.storeCategoryNumber = :storeCategoryNumber 
                OR p.storeCategoryNumber IN (SELECT storeCategoryNumber FROM storecategory WHERE parentStoreCategoryNumber = :storeCategoryNumber))
                AND p.pageDisplayStatus = 1';
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

// 親カテゴリとその小カテゴリを取得するクエリ
$sql = 'SELECT sc.storeCategoryNumber, sc.storeCategoryName, sc.parentStoreCategoryNumber
        FROM storecategory sc
        WHERE sc.storeNumber = :storeNumber';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリを親子構造に整形
$categoryTree = [];
foreach ($categories as $category) {
    if ($category['parentStoreCategoryNumber'] == 0) {
        // 親カテゴリ
        $categoryTree[$category['storeCategoryNumber']] = $category;
        $categoryTree[$category['storeCategoryNumber']]['children'] = [];
    } else {
        // 小カテゴリ
        $categoryTree[$category['parentStoreCategoryNumber']]['children'][] = $category;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <link rel="stylesheet" href="../../css/storeCategoryProductLsit.css">
    <link rel="stylesheet" type="text/css" href="../../css/header.css" />
</head>
<body>
    <?php include "../header.php"; ?>
    <h1 class="title">カテゴリの商品一覧</h1>
    <div class="container">
        <div class="categories">
            <h2>カテゴリ</h2>
            <ul>
                <?php foreach ($categoryTree as $parentCategory): ?>
                    <li class="parent-category">
                        <a href="#" class="parent-link" data-category-id="<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($parentCategory['storeCategoryName'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <?php if (!empty($parentCategory['children'])): ?>
                            <ul class="child-categories">
                                <li>
                                    <a href="?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>&showAll=true">
                                        すべての商品
                                    </a>
                                </li>
                                <?php foreach ($parentCategory['children'] as $childCategory): ?>
                                    <li>
                                        <a href="?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($childCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= htmlspecialchars($childCategory['storeCategoryName'], ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="child-categories">
                                <li>
                                    <a href="?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>&showAll=true">
                                        すべての商品
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
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
                                <a href="../productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?></a>
                                <p>価格: <?= number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')) ?>円</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>このカテゴリには商品がありません。</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.querySelectorAll('.parent-link').forEach(function(parentLink) {
            parentLink.addEventListener('click', function(e) {
                e.preventDefault();

                const childCategories = this.parentElement.querySelector('.child-categories');
                if (childCategories) {
                    const isDisplayed = childCategories.style.display === 'block';
                    document.querySelectorAll('.child-categories').forEach(function(ul) {
                        ul.style.display = 'none';
                    });
                    childCategories.style.display = isDisplayed ? 'none' : 'block';
                }
            });
        });
    </script>
</body>
</html>
