<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php'); // StoreSQL クラスを読み込む

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
$storeSQL = new StoreSQL(); // StoreSQL クラスのインスタンスを作成

$searchTerm = $_GET['query'] ?? '';

$_SESSION['query'] = $searchTerm;
$searchTerm = '%' . trim($searchTerm) . '%';

// 商品検索
$products = $storeSQL->searchProducts($pdo, $searchTerm);

$_SESSION['products'] = $products;

// 類似商品検索
$similarProducts = [];
if (!empty($products)) {
    $categoryNumber = $products['categoryNumber'];
    $similarProducts = $storeSQL->findSimilarProducts($pdo, $categoryNumber, $searchTerm);
}

$_SESSION['similarProducts'] = $similarProducts;
header('Location: productSearchList.php');
?>