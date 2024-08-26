<?php
session_start();
require_once('../utilConnDB.php');

// セッションから顧客番号を取得
$userName = $_SESSION['customer'] ?? null;
$userId = $userName['customerNumber'] ?? null;

if ($userId === null) {
    echo "ログイン情報が確認できません。";
    exit();
}

// データベース接続
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 顧客情報の更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームからデータを取得
    $address = $_POST['address'] ?? '';
    $postCode = $_POST['postCode'] ?? '';

    try {
        // トランザクションを開始（既にトランザクションがない場合のみ）
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
        
        // データベースの更新
        $sql = "UPDATE customer SET address = :address, postCode = :postCode WHERE customerNumber = :customerNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':postCode', $postCode);
        $stmt->bindParam(':customerNumber', $userId);
        $stmt->execute();
        
        // コミット
        $pdo->commit();
        
        // 成功時にリダイレクト（status=success パラメータを削除）
        header('Location: UInfop01.php');
        exit();
    } catch (PDOException $e) {
        // エラー発生時はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "データベースエラー: " . $e->getMessage();
        $pdo = null;
        exit();
    }
}

// 顧客情報を取得
try {
    $sql = "SELECT * FROM customer WHERE customerNumber = :customerNumber";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customerNumber', $userId);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
    $pdo = null;
    exit();
}

// 接続を閉じる
$pdo = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客情報変更</title>
    <link rel="stylesheet" href="UInfo01.css">
</head>
<body>
    <h1>顧客情報変更</h1>
    <form action="" method="post">
        <div class="section-container">
            <h2>住所・郵便番号</h2>
            <label for="address">住所:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"><br>
            <label for="postCode">郵便番号:</label>
            <input type="text" id="postCode" name="postCode" value="<?php echo htmlspecialchars($customer['postCode']); ?>"><br>
            <button type="submit">変更</button>
        </div>
    </form>
</body>
</html>
