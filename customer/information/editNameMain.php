<?php
session_start();
require_once('../../utilConnDB.php');

// データベース接続
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// セッションから顧客番号を取得
$userName = $_SESSION['customer'] ?? null;
$userId = $userName['customerNumber'] ?? null;

// 顧客番号が無効な場合の処理
if ($userId === null) {
    echo "無効な顧客番号です。";
    exit();
}

// 顧客情報の更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームからデータを取得
    $customerName = $_POST['customerName'] ?? '';
    $furigana = $_POST['furigana'] ?? '';
    $dateOfBirth = $_POST['dateOfBirth'] ?? '';

    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
        
        // データベースの更新
        $sql = "UPDATE customer SET customerName = :customerName, furigana = :furigana, dateOfBirth = :dateOfBirth WHERE customerNumber = :customerNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':customerName', $customerName);
        $stmt->bindValue(':furigana', $furigana);
        $stmt->bindValue(':dateOfBirth', $dateOfBirth);
        $stmt->bindValue(':customerNumber', $userId);
        $stmt->execute();

        // 更新された顧客情報を取得してセッションに保存
        $sql = "SELECT customerName, furigana, dateOfBirth FROM customer WHERE customerNumber = :customerNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':customerNumber', $userId);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            $_SESSION['customer']['customerName'] = $customer['customerName'];
        }

        // コミット
        $pdo->commit();
        
        // 成功時にリダイレクト
        header('Location: informationEditMenu.php');
        exit();
    } catch (PDOException $e) {
        // エラー発生時はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        exit();
    }
}
?>
