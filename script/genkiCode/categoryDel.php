<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$transactionStarted = false; // トランザクション管理用フラグ

if (isset($_GET['categoryNumber'])) {
    $categoryNumber = $_GET['categoryNumber'];

    // プレースホルダーを使用してDELETEステートメントを準備
    $query = "DELETE FROM category WHERE categoryNumber = :categoryNumber";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':categoryNumber', $categoryNumber, PDO::PARAM_INT); // プレースホルダーのバインディングを整数に変更

    try {
        // トランザクション開始（まだ開始していない場合のみ）
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
        
        // クエリの実行
        $result = $stmt->execute();

        // 削除後にカテゴリーがまだ存在するか確認
        $checkQuery = "SELECT * FROM category WHERE categoryNumber = :categoryNumber";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindValue(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
        $checkStmt->execute();
        $category = $checkStmt->fetch();

        if ($category) {
            // カテゴリーがまだ存在する場合
            $pdo->rollBack();
        } else {
            // 削除が成功した場合
            $pdo->commit();
        }
    } catch (Exception $e) {
        // エラーが発生した場合はロールバック
        if ($transactionStarted) {
            $pdo->rollBack();
        }
    }

    header('Location: categoryManagement.php');
}
?>
