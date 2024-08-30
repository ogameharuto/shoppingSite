<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// フォームからの入力値を取得
$reviewNumber = $_POST['reviewNumber'] ?? null;
$productNumber = $_POST['productNumber'] ?? null;
$customerNumber = $_POST['customerNumber'] ?? null;
$reviewText = $_POST['reviewText'] ?? null;
$evaluation = $_POST['evaluation'] ?? null;

if ($reviewNumber && $productNumber && $customerNumber && $reviewText !== null && $evaluation !== null) {
    try {
        // トランザクション開始
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        // レビュー情報を更新するSQL文
        $sql = 'UPDATE review 
                SET reviewText = :reviewText, evaluation = :evaluation
                WHERE reviewNumber = :reviewNumber AND customerNumber = :customerNumber';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reviewNumber', $reviewNumber, PDO::PARAM_INT);
        $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
        $stmt->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $stmt->bindParam(':evaluation', $evaluation, PDO::PARAM_INT);
        
        // 更新を実行
        $stmt->execute();
        
        // トランザクションをコミット
        $pdo->commit();
        
        // 更新成功のメッセージまたはリダイレクト
        echo 'レビューが更新されました。';

        header('Location: reviewMenu.php');

    } catch (PDOException $e) {
        // トランザクションをロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollback();
        }
        echo '更新中にエラーが発生しました: ' . $e->getMessage();
    }
} else {
    echo 'すべての入力値が正しくありません。';
}
?>
