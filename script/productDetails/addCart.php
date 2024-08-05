<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$utilConnDB = new UtilConnDB();
$storeSQL = new StoreSQL();
$pdo = $utilConnDB->connect();

$customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : null;

if (!$customer) {
    echo "無効なリクエストです。";
    exit;
}

$customerNumber = $customer['customerNumber'];
$productNumber = isset($_POST['productNumber']) ? intval($_POST['productNumber']) : null;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if (!$productNumber) {
    echo "無効なリクエストです。";
    exit;
}

try {
    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    // 既存のアイテムをチェック
    $cartItem = $storeSQL->getCartItem($pdo, $customerNumber, $productNumber);

    if ($cartItem) {
        // 既存のアイテムがある場合は数量を更新
        $newQuantity = $cartItem['quantity'] + $quantity;
        $storeSQL->updateCartItemQuantity($pdo, $newQuantity, $customerNumber, $productNumber);
    } else {
        // 新規アイテムを追加
        $storeSQL->insertCartItem($pdo, $customerNumber, $productNumber, $quantity);
    }

    // トランザクションをコミット
    $pdo->commit();
    echo "カートに追加されました。";
    header('Location: ../cart/cartMain.php');
} catch (Exception $e) {
    // トランザクションが開始されている場合はロールバック
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "エラーが発生しました: " . $e->getMessage();
    error_log("エラー: " . $e->getMessage()); // エラーログに詳細なエラー情報を記録
}
?>
