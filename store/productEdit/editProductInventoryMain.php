<?php
session_start();

// データベース接続設定
require_once('../../utilConnDB.php');
require_once('../../storeSQL.php');

$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品一覧ページから送信された選択された商品のIDを取得
if (isset($_POST['product']) && is_array($_POST['product'])) {
    // 商品IDが配列形式であることを確認し、セッションに保存
    $_SESSION['selectedProductNumbers'] = array_map('intval', $_POST['product']);
}

// セッションから選択された商品のIDを取得
$selectedProductNumbers = isset($_SESSION['selectedProductNumbers']) ? $_SESSION['selectedProductNumbers'] : [];

// 商品情報を取得
if (!empty($selectedProductNumbers)) {
    $products = $storeSQL->productUpdSelect($pdo, $selectedProductNumbers);

    $_SESSION['products'] = $products;
} else {
    // 選択された商品がない場合は、エラーメッセージをセッションに保存
    $_SESSION['error'] = "商品が選択されていません。";
}
// 在庫編集ページにリダイレクト
header('Location: editProductInventory.php');
exit;
?>
