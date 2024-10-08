<?php
session_start();
require_once('../../utilConnDB.php');

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
    <form action="editNameMain.php" method="post">
        <div class="section-container">
            <h2>顧客名・フリガナ・生年月日</h2>
            <label for="customerName">顧客名:</label>
            <input type="text" id="customerName" name="customerName" value="<?php echo htmlspecialchars($customer['customerName']); ?>"><br>
            <label for="furigana">フリガナ:</label>
            <input type="text" id="furigana" name="furigana" value="<?php echo htmlspecialchars($customer['furigana']); ?>"><br>
            <label for="dateOfBirth">生年月日:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo htmlspecialchars($customer['dateOfBirth']); ?>"><br>
            <button type="submit">変更</button>
        </div>
    </form>
</body>
</html>
