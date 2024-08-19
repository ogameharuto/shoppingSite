<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品番号の取得
$productNumber = isset($_GET['productNumber']) ? intval($_GET['productNumber']) : 0;
print($productNumber);
// StoreSQL クラスのインスタンス化
$storeSQL = new StoreSQL();

// 商品データの取得
$product = $storeSQL->getProductByNumber($pdo, $productNumber);

if (!$product) {
    echo "商品が見つかりません。";
    exit;
}

// カテゴリデータの取得
$categories = $storeSQL->getCategories($pdo);

// 商品のカテゴリを取得
$productCategoryNumber = $product['categoryNumber'];

// カテゴリツリーのHTMLを生成
$categoryTreeHTML = $storeSQL->displayCategoryTree($categories, $productCategoryNumber);

// レビューデータの取得
$reviews = $storeSQL->getReviewsByProductNumber($pdo, $productNumber);

// ストア情報の取得
$stores = $storeSQL->getStoreByProductNumber($pdo, $productNumber);
if (!$stores) {
    echo "ストア情報が見つかりません。";
    exit;
}
$productImages = $storeSQL->fetchProductDataAndImages($pdo, $productNumber);

$_SESSION['product'] = $product;
$_SESSION['categoryTreeHTML'] = $categoryTreeHTML;
$_SESSION['reviews'] = $reviews;
$_SESSION['stores'] = $stores;
$_SESSION['images'] = $productImages;

header('Location: productDetails.php');
exit;
?>
