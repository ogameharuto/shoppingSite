<?php
// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// セッション開始
session_start();

// レビューIDを取得
$reviewNumber = $_POST['reviewNumber'] ?? null;
$customerNumber = $_POST['customerNumber'] ?? null;

if ($reviewNumber) {
    try {
        // トランザクション開始
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        // レビューを削除
        $sql = 'DELETE FROM review WHERE reviewNumber = :reviewNumber AND customerNumber = :customerNumber';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reviewNumber', $reviewNumber, PDO::PARAM_INT);
        $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
        $stmt->execute();

        // トランザクションコミット
        $pdo->commit();
        
        // 成功メッセージ
        header('Location: reviewMenu.php');
        exit;
    } catch (Exception $e) {
        // エラー処理
        $pdo->rollBack();
        echo 'レビューの削除に失敗しました。';
    }
} else {
    echo 'レビューIDが指定されていません。';
}
?>
