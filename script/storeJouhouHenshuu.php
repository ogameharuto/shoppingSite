<?php
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

try {

    // ストア情報をデータベースから取得
    $stmt = $pdo->query('SELECT * FROM store');
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
    <link rel="stylesheet" href="store.css">
</head>
<body>
    <h1>ストア管理</h1>
    <div class="table-container">
        <table>
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
                <th>店舗の画像URL</th>
                <th>追加情報</th>
                <th>運営責任者</th>
                <th>連絡先住所</th>
                <th>連絡先郵便番号</th>
                <th>連絡先電話番号</th>
                <th>連絡先メールアドレス</th>
                <th>パスワード</th>
                <th>aaaaa</th>
            </tr>
            <tbody>
                <?php if (!empty($stores)): ?>
                    <?php foreach ($stores as $store): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($store['storeNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['companyName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['companyPostalCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['companyAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['companyRepresentative'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['storeName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['furigana'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['telephoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['mailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['storeDescription'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['storeImageURL'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['storeAdditionalInfo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['operationsManager'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['contactAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['contactPostalCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['contactPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['contactEmailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($store['password'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="editStore.php?id=<?php echo htmlspecialchars($store['storeNumber'], ENT_QUOTES, 'UTF-8'); ?>">編集</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="1">ストア情報がありません。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
