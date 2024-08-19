<?php
header('Content-Type: text/plain; charset=utf-8');

/* インポート */
require_once('../storeSQL.php');
require_once('../utilConnDB.php');

/* インスタンス生成 */
$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();

/* main */
/* DB接続 */
$pdo = $utilConnDB->connect();

/* 顧客番号の取得 */
session_start();
$customerNumber = $_SESSION['customer']['customerNumber'] ?? null;

/* カートリストの取得 */
$cartList = [];
if ($customerNumber !== null) {
    $cartList = $storeSQL->selectCartItems($pdo, $customerNumber);
} else {
    // 顧客番号がセッションに保存されていない場合の処理
    $cartList = [];
}

/* 商品画像データの取得 */
$productImages = [];
if (!empty($cartList)) {
    foreach ($cartList as $cartItem) {
        $productNumber = $cartItem['productNumber'] ?? null;
        if ($productNumber) {
            $images = $storeSQL->fetchProductDataAndImages($pdo, $productNumber);
            if (!empty($images)) {
                $productImages[$productNumber] = $images;
            }
        }
    }
}

/* DB切断 */
$utilConnDB->disconnect($pdo);

/* データを渡す */
$_SESSION['cartList'] = $cartList;
$_SESSION['images'] = $productImages;

/* 次に実行するモジュール */
header('Location: cartList.php');
exit;
?>
