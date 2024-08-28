<?php
// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// POSTデータを取得
$productNumber = $_POST['productNumber'];
$customerNumber = $_POST['customerNumber'];
$reviewText = $_POST['reviewText'];
$evaluation = $_POST['evaluation'];
$purchaseFlag = isset($_POST['purchaseFlag']) ? (int)$_POST['purchaseFlag'] : 1; // 購入フラグを取得

try {
    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }
    
    // レビューを挿入
    $sql = 'INSERT INTO review (customerNumber, productNumber, reviewText, purchaseFlag, evaluation) 
            VALUES (:customerNumber, :productNumber, :reviewText, :purchaseFlag, :evaluation)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
    $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
    $stmt->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindParam(':purchaseFlag', $purchaseFlag, PDO::PARAM_INT);
    $stmt->bindParam(':evaluation', $evaluation, PDO::PARAM_INT);
    $stmt->execute();
    
    // トランザクションをコミット
    $pdo->commit();
} catch (PDOException $e) {
    // エラーが発生した場合はロールバック
    $pdo->rollback();
    echo 'エラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
} finally {
    // データベース接続を切断
    $utilConnDB->disconnect($pdo);
}

// レビュー投稿後、元の商品ページにリダイレクト
header('Location: reviewMenu.php?productNumber=' . urlencode($productNumber));
exit;
?>
