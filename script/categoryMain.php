<?php
session_start();
require_once('utilConnDB.php');
require_once('storeSQL.php');

$utilConnDB = new UtilConnDB();
$storeSQL = new StoreSQL();
$pdo = $utilConnDB->connect();

if (!isset($_GET['categoryNumber'])) {
    die('カテゴリ番号が指定されていません。');
}

$parentCategoryNumber = intval($_GET['categoryNumber']);

// 親カテゴリの取得
$parentCategory = $storeSQL->categorySelectById($pdo, $parentCategoryNumber);

if (!$parentCategory) {
    die('指定されたカテゴリが存在しません。');
}

// 子カテゴリの取得
$childCategories = $storeSQL->selectChildCategories($pdo, $parentCategoryNumber);

// 商品の取得
$categoryIds = empty($childCategories) ? [$parentCategoryNumber] : array_merge([$parentCategoryNumber], array_column($childCategories, 'categoryNumber'));
$products = $storeSQL->productSelectByCategory($pdo, $categoryIds);

// 商品の画像データ取得
$imageData = $storeSQL->getProductImages($pdo);

// 画像データを商品データに結合
$imageMap = [];
foreach ($imageData as $image) {
    $imageMap[$image['productNumber']] = !empty($image['imageName']) ? $image['imageName'] : 'default.jpg';
}

// 商品データに画像情報を追加
foreach ($products as &$product) {
    $product['imageName'] = isset($imageMap[$product['productNumber']]) ? $imageMap[$product['productNumber']] : 'default.jpg';
}

// 親カテゴリリストの取得
$parentCategories = $storeSQL->categorySelectParent($pdo);

$category = $storeSQL->getCategories($pdo);

// セッションにデータを保存
$_SESSION['parentCategory'] = $parentCategory;
$_SESSION['childCategories'] = $childCategories;
$_SESSION['products'] = $products; // 商品データに画像情報を含めてセッションに保存
$_SESSION['parentCategories'] = $parentCategories;
$_SESSION['category'] = $category;

// リダイレクト先にカテゴリ番号を追加
header('Location: category.php?categoryNumber=' . $parentCategoryNumber);
exit(); // リダイレクト後の処理を終了
?>
