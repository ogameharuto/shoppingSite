<?php
session_start();
// データベース接続設定
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();


// 商品一覧ページから送信された選択された商品のIDを取得
if (isset($_POST['product'])) {
    $_SESSION['selectProduct'] = $_POST['product'];
}

// セッションから選択された商品のIDを取得
$selectedProductNumbers = isset($_SESSION['selectProduct']) ? $_SESSION['selectProduct'] : [];


$products = $storeSQL->productEditSelect($pdo, $selectedProductNumbers);

$_SESSION['product'] = $products;

header('Location: editProductInventory.php');
?>
