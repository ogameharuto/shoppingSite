<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$utilConnDB = new UtilConnDB();
$storeSQL = new StoreSQL();
$pdo = $utilConnDB->connect();

// 検索クエリの取得
$query = isset($_GET['query']) ? $_GET['query'] : '';


$products = $storeSQL->searchProducts($pdo, $query);

$_SESSION['searchTerm'] = $query;
$_SESSION['products'] = $products;

header('Location: productSearchList.php');
exit;
?>
