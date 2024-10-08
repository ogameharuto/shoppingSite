<?php
session_start();
require_once('../../utilConnDB.php');
require_once('../../storeSQL.php');

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

$url = "../cart/cartMain.php?productNumber=" . urlencode($productNumber);

if (!$productNumber) {
    echo "無効なリクエストです。";
    exit;
}

try {
    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    // 商品の在庫数を取得
    $stmt = $pdo->prepare("SELECT stockQuantity FROM product WHERE productNumber = :productNumber");
    $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $stockQuantity = $product['stockQuantity'];

        // 既存のカートアイテムを取得
        $cartItem = $storeSQL->getCartItem($pdo, $customerNumber, $productNumber);
        $existingQuantity = $cartItem ? $cartItem['quantity'] : 0;

        // 既存の数量と新しい数量の合計が在庫数を超えていないか確認
        if ($existingQuantity + $quantity > $stockQuantity) {
            // 在庫数を超えている場合の処理
            $_SESSION['error'] = "在庫数を超えています。";
            header('Location: ' . $url);
            exit;
        }

        if ($cartItem) {
            // 既存のアイテムがある場合は数量を更新
            $newQuantity = $existingQuantity + $quantity;
            $storeSQL->updateCartItemQuantity($pdo, $newQuantity, $customerNumber, $productNumber);
        } else {
            // 新規アイテムを追加
            $storeSQL->insertCartItem($pdo, $customerNumber, $productNumber, $quantity);
        }

        // トランザクションをコミット
        $pdo->commit();
        $_SESSION['orderProductNumber'] = $productNumber;
        header('Location: ../cart/cartMain.php');
        exit;
    } else {
        echo "Error: 商品が見つかりません。";
    }
} catch (Exception $e) {
    // トランザクションが開始されている場合はロールバック
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "エラーが発生しました: " . $e->getMessage();
    error_log("エラー: " . $e->getMessage()); // エラーログに詳細なエラー情報を記録
}

// DB切断
$pdo = $utilConnDB->disconnect($pdo);
?>
