<?php
// セッションを開始
session_start();

// 必要なファイルをインポート
require_once('../storeSQL.php');
require_once('../utilConnDB.php');

// インスタンス生成
$cartDAO = new StoreSQL();
$utilConnDB = new UtilConnDB();

// DB接続
$pdo = $utilConnDB->connect();

// 顧客番号の取得
$customerNumber = $_SESSION['customer']['customerNumber'] ?? null;

// 商品番号の取得
$productNumber = $_GET['productNumber'] ?? null;

try {
    if ($customerNumber !== null && $productNumber !== null) {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        // カートから商品を削除
        $result = $cartDAO->deleteCartItem($pdo, $customerNumber, $productNumber);

        if ($result) {
            $pdo->commit(); // トランザクションをコミット
            echo "削除成功";
        } else {
            throw new Exception("削除が失敗しました。");
        }
    } else {
        throw new Exception("Error: 顧客番号または商品番号が無効です。");
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack(); // トランザクションをロールバック
    }
    echo "削除失敗: " . $e->getMessage();
}

// DB切断
$utilConnDB->disconnect($pdo);

// カート一覧ページにリダイレクト
header('Location: cartMain.php');
exit;
?>
