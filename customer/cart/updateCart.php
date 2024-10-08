<?php
// セッションを開始
session_start();

// 必要なファイルをインポート
require_once('../../storeSQL.php');
require_once('../../utilConnDB.php');

// インスタンス生成
$cartDAO = new StoreSQL();
$utilConnDB = new UtilConnDB();

// DB接続
$pdo = $utilConnDB->connect();

// 顧客番号の取得
$customerNumber = $_SESSION['customer']['customerNumber'] ?? null;

// 商品番号と数量の取得
$productNumber = $_POST['productNumber'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if ($customerNumber !== null && $productNumber !== null && $quantity !== null) {
    try {
        // 在庫情報を取得
        $stmt = $pdo->prepare("SELECT stockQuantity FROM product WHERE productNumber = :productNumber");
        $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $stockQuantity = $product['stockQuantity'];

            if ($quantity > $stockQuantity) {
                // 在庫数を超えている場合の処理
                $_SESSION['error'] = "在庫数を超えています。";
                header('Location: cartMain.php');
                exit();
            }

            if (!$pdo->inTransaction()) {
                $pdo->beginTransaction();
            }

            // カートの数量を更新
            $cartDAO->updateCartItem($pdo, $customerNumber, $productNumber, $quantity);

            // カート内の商品を再取得して合計金額を計算
            $cartList = $cartDAO->selectCartItems($pdo, $customerNumber);
            $totalPrice = 0;
            foreach ($cartList as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // セッションに合計金額を保存
            $_SESSION['totalPrice'] = $totalPrice;

            if ($pdo->inTransaction()) {
                $pdo->commit();
            }

            // カート一覧ページにリダイレクト
            header('Location: cartMain.php');
            exit;
        } else {
            echo "Error: 商品が見つかりません。";
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "エラー: " . $e->getMessage();
    }
} else {
    echo "Error: 顧客番号、商品番号、または数量が無効です。";
}

// DB切断
$pdo = $utilConnDB->disconnect($pdo);
?>
