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
    $mailAddress = $_POST['mailAddress'] ?? '';
    $telephoneNumber = $_POST['telephoneNumber'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // トランザクションを開始（既にトランザクションがない場合のみ）
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
        
        // データベースの更新
        $sql = "UPDATE customer SET mailAddress = :mailAddress, telephoneNumber = :telephoneNumber, password = :password WHERE customerNumber = :customerNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mailAddress', $mailAddress);
        $stmt->bindParam(':telephoneNumber', $telephoneNumber);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':customerNumber', $userId);
        $stmt->execute();
        
        // コミット
        $pdo->commit();
        
        // 成功時にリダイレクト
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
            <h2>メールアドレス・電話番号・パスワード</h2>
            <label for="mailAddress">メールアドレス:</label>
            <input type="email" id="mailAddress" name="mailAddress" value="<?php echo htmlspecialchars($customer['mailAddress']); ?>"><br>
            <label for="telephoneNumber">電話番号:</label>
            <input type="tel" id="telephoneNumber" name="telephoneNumber" value="<?php echo htmlspecialchars($customer['telephoneNumber']); ?>"><br>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>"><br>
            <button type="submit">変更</button>
        </div>
    </form>
</body>
</html>
