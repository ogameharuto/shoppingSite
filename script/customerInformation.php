<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB;
$pdo = $utilConnDB->connect();

// セッションから顧客番号を取得
$userId = intval($_GET['userId']);
$current_page = basename($_SERVER['PHP_SELF']);

if ($userId !== null) {
    // 顧客情報をデータベースから取得
    $sql = 'SELECT * FROM customer WHERE customerNumber = :customerNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customerNumber', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $customers = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客管理</title>
    <link rel="stylesheet" href="customerInformation.css">
</head>
<body>
    <div class="navbar">
        <a href="http://localhost/shopp/script/customerInformation.php?userId=<?php echo urlencode($userId); ?>" class="nav-item <?php echo ($current_page == 'customerInformation.php') ? 'active' : ''; ?>">顧客情報</a>
        <a href="http://localhost/shopp/script/UInfop01.php?userId=<?php echo urlencode($userId); ?>" class="nav-item <?php echo ($current_page == 'UInfop01.php') ? 'active' : ''; ?>">顧客情報編集</a>
    </div>
    <h1>顧客管理</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>顧客名</th>
                <th>フリガナ</th>
                <th>住所</th>
                <th>郵便番号</th>
                <th>誕生日</th>
                <th>メールアドレス</th>
                <th>電話番号</th>
                <th>パスワード</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['customerNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['customerName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['furigana'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['postCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['dateOfBirth'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['mailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['telephoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($customer['password'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">顧客情報がありません。</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
