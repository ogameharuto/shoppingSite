<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
$storeSQL = new StoreSQL(); 

$searchTerm = $_GET['query'] ?? '';

$_SESSION['query'] = $searchTerm;
$searchTerm = '%' . trim($searchTerm) . '%';

// 商品検索
$products = $storeSQL->searchProducts($pdo, $searchTerm);
$_SESSION['products'] = $products;

header('Location: productSearchList.php');
?>