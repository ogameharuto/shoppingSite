<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
session_start();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: account/storeLoginMenu.php");
    exit();
}

$store = $_SESSION['store'];
$storeNumber = $store['storeNumber'];

try {
    // ストア情報をデータベースから取得
    $query = 'SELECT * FROM store WHERE storeNumber = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$storeNumber]);
    $stores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    $stores = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ストア管理</title>
    <link rel="stylesheet" href="../css/store.css">
</head>
<body>
    <h1>ストア管理</h1>
    <button type="button" onclick="location.href='../storeToppage.php'">戻る</button>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ストア番号</th>
                    <th>会社名</th>
                    <th>郵便番号</th>
                    <th>会社所在地</th>
                    <th>代表者名</th>
                    <th>店舗名</th>
                    <th>フリガナ</th>
                    <th>電話番号</th>        
                    <th>メールアドレス</th>
                    <th>店舗の説明</th>
                    <th>追加情報</th>
                    <th>運営責任者</th>
                    <th>連絡先住所</th>
                    <th>連絡先郵便番号</th>
                    <th>連絡先電話番号</th>
                    <th>連絡先メールアドレス</th>
                    <th>パスワード</th>
                    <th>編集</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stores)): ?>
                    <?php foreach ($stores as $storeItem): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($storeItem['storeNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['companyName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['companyPostalCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['companyAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['companyRepresentative'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['storeName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['furigana'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['telephoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['mailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['storeDescription'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['storeAdditionalInfo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['operationsManager'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['contactAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['contactPostalCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['contactPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['contactEmailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($storeItem['password'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="informationEditMenu.php?id=<?php echo htmlspecialchars($storeItem['storeNumber'], ENT_QUOTES, 'UTF-8'); ?>">編集</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="17">ストア情報がありません。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
