<?php
session_start();
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if (!isset($_GET['categoryNumber'])) {
    die('カテゴリ番号が指定されていません。');
}

$parentCategoryNumber = intval($_GET['categoryNumber']);

// 親カテゴリの取得
$parentCategoryStmt = $pdo->prepare("SELECT * FROM category WHERE categoryNumber = ?");
$parentCategoryStmt->execute([$parentCategoryNumber]);
$parentCategory = $parentCategoryStmt->fetch(PDO::FETCH_ASSOC);

if (!$parentCategory) {
    die('指定されたカテゴリが存在しません。');
}

// 子カテゴリの取得
$categoryStmt = $pdo->prepare("SELECT categoryNumber FROM category WHERE parentCategoryNumber = ?");
$categoryStmt->execute([$parentCategoryNumber]);
$childCategories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN, 0);

// 商品の取得
if (empty($childCategories)) {
    // 子カテゴリがない場合、親カテゴリに属する商品の取得
    $productsStmt = $pdo->prepare("SELECT * FROM product WHERE categoryNumber = ?");
    $productsStmt->execute([$parentCategoryNumber]);
} else {
    // 子カテゴリがある場合、親カテゴリと子カテゴリに属する商品の取得
    $categoryIds = array_merge([$parentCategoryNumber], $childCategories);
    $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
    $productsStmt = $pdo->prepare("SELECT * FROM product WHERE categoryNumber IN ($placeholders)");
    $productsStmt->execute($categoryIds);
}

// 商品データと画像データの取得
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

// 商品の画像データ取得
$imageStmt = $pdo->prepare("
    SELECT p.productNumber, i.imageName
    FROM product p
    LEFT JOIN images i ON p.productNumber = i.productNumber
");
$imageStmt->execute();
$imageData = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

// 画像データを商品データに結合
$imageMap = [];
foreach ($imageData as $image) {
    $imageMap[$image['productNumber']] = !empty($image['imageName']) ? $image['imageName'] : 'default.jpg';
}

// 親カテゴリリストの取得
$parentCategories = $pdo->query("SELECT * FROM category WHERE parentCategoryNumber IS NULL")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($parentCategory['categoryName'], ENT_QUOTES, 'UTF-8') ?> - 商品一覧</title>
    <link rel="stylesheet" href="clientToppage.css">
</head>
<body>
<?php include "header.php"; ?>
<div class="container">
    <div class="sidebar">
        <h2>カテゴリリスト</h2>
        <ul class="parent-categories">
            <?php foreach ($parentCategories as $category): ?>
                <li class="parent-category">
                    <a href="category.php?categoryNumber=<?= htmlspecialchars($category['categoryNumber'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="main-content">
        <h1><?= htmlspecialchars($parentCategory['categoryName'], ENT_QUOTES, 'UTF-8') ?>の商品一覧</h1>
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <a href="productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <?php
                            $imageName = isset($imageMap[$product['productNumber']]) ? htmlspecialchars($imageMap[$product['productNumber']], ENT_QUOTES, 'UTF-8') : 'default.jpg';
                            $imagePath = "imageIns/uploads/" . $imageName;
                            ?>
                            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8') ?>" width="120" height="120">
                            <p>価格: <?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?>円</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>このカテゴリには商品がありません。</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
