<?php
session_start();

// セッションからデータを取得
$parentCategory = isset($_SESSION['parentCategory']) ? $_SESSION['parentCategory'] : null;
$childCategories = isset($_SESSION['childCategories']) ? $_SESSION['childCategories'] : [];
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];
$parentCategories = isset($_SESSION['parentCategories']) ? $_SESSION['parentCategories'] : [];
$categories = isset($_SESSION['category']) ? $_SESSION['category'] : [];
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
        <h2>カテゴリから探す</h2>
        <ul class="parent-categories">
            <?php foreach ($categories as $category): ?>
                <?php if ($category['parentCategoryNumber'] == 0): ?>
                    <li class="parent-category">
                        <a href="categoryMain.php?categoryNumber=<?= htmlspecialchars($category['categoryNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <?php
                        $childCategories = array_filter($categories, function($cat) use ($category) {
                            return $cat['parentCategoryNumber'] == $category['categoryNumber'];
                        });
                        ?>
                        <?php if (!empty($childCategories)): ?>
                            <ul class="child-categories">
                                <?php foreach ($childCategories as $childCategory): ?>
                                    <li>
                                        <a href="categoryMain.php?categoryNumber=<?= htmlspecialchars($childCategory['categoryNumber'], ENT_QUOTES, 'UTF-8') ?>">
                                            <?= htmlspecialchars($childCategory['categoryName'], ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
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
                            <?php if (!empty($product['images'])): ?>
                                <?php foreach ($product['images'] as $imageName): ?>
                                    <img src="uploads/<?= htmlspecialchars($imageName, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8') ?>">
                                <?php endforeach; ?>
                            <?php else: ?>
                                <img src="default-image.png" alt="商品画像がありません" width="120" height="120">
                            <?php endif; ?>
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
