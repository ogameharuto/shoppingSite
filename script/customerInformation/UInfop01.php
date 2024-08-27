<?php
session_start();
require_once('../../utilConnDB.php');

// セッションから顧客番号を取得
$userName = $_SESSION['customer'] ?? null;
$userId = $userName['customerNumber'] ?? null;
$current_page = basename($_SERVER['PHP_SELF']);

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
    <title>会員情報</title>
    <link rel="stylesheet" href="UInfop01.css">
</head>
<body>
<div class="container">
<div class="navbar">
    <a href="http://localhost/shopp/script/customerInformation/customerInformation.php?userId=<?php echo urlencode($userId); ?>" class="nav-item <?php echo ($current_page == 'customerInformation.php') ? 'active' : ''; ?>">顧客情報</a>
    <a href="http://localhost/shopp/script/customerInformation/UInfop01.php?userId=<?php echo urlencode($userId); ?>" class="nav-item <?php echo ($current_page == 'UInfop01.php') ? 'active' : ''; ?>">顧客情報編集</a>
</div>
    <h1>会員情報</h1>
    <?php if (isset($_POST['success']) && $_POST['success'] == '1'): ?>
        <script>
            alert("顧客情報が正常に更新されました。");
        </script>
    <?php endif; ?>

    <!-- 顧客名、フリガナ、生年月日 -->
    <div class="section-container">
        <h2>顧客名・フリガナ・生年月日</h2>
        <p><strong>顧客名:</strong> <?php echo htmlspecialchars($customer['customerName']); ?></p>
        <p><strong>フリガナ:</strong> <?php echo htmlspecialchars($customer['furigana']); ?></p>
        <p><strong>生年月日:</strong> <?php echo htmlspecialchars($customer['dateOfBirth']); ?></p>
        <a href="updateCustomerNameMenu.php"><button type="button">変更</button></a>
    </div>

    <!-- 住所、郵便番号 -->
    <div class="section-container">
        <h2>住所・郵便番号</h2>
        <p><strong>住所:</strong> <?php echo htmlspecialchars($customer['address']); ?></p>
        <p><strong>郵便番号:</strong> <?php echo htmlspecialchars($customer['postCode']); ?></p>
        <a href="updateCustomerAddressMenu.php"><button type="button">変更</button></a>
    </div>

    <!-- メールアドレス、電話番号、パスワード -->
    <div class="section-container">
        <h2>メールアドレス・電話番号・パスワード</h2>
        <p><strong>メールアドレス:</strong> <?php echo htmlspecialchars($customer['mailAddress']); ?></p>
        <p><strong>電話番号:</strong> <?php echo htmlspecialchars($customer['telephoneNumber']); ?></p>
        <a href="updateCustomerContactMenu.php"><button type="button">変更</button></a>
    </div>

    <form action="../myPage.php" method="get">
        <button type="submit">マイページへ戻る</button>
    </form>
</div>
</body>
</html>
