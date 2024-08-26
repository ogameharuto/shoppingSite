<?php
// エラー表示を有効にする
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=syain_db'; // データベース名を適切に変更してください
$username = 's20227048'; // データベースのユーザー名
$password = '20030502'; // データベースのパスワード

try {
    // PDOインスタンスの作成
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8mb4'");

    // 顧客情報をデータベースから取得
    $stmt = $pdo->query('SELECT * FROM customer');
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    $customers = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客管理</title>
    <link rel="stylesheet" href="kokyakutouroku.css">
</head>
<body>
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
