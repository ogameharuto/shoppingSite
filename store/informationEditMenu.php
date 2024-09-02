<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();


try {
    // 編集するストアのIDを取得
    $storeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($storeId > 0) {
        // ストア情報を取得
        $stmt = $pdo->prepare('SELECT * FROM store WHERE storeNumber = :storeNumber');
        $stmt->bindParam(':storeNumber', $storeId, PDO::PARAM_INT);
        $stmt->execute();
        $store = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo '無効なストアIDです。';
        exit;
    }

} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    $store = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ストア編集</title>
    <link rel="stylesheet" href="editstore.css">
</head>
<body>
    <h1>ストア編集</h1>
    <form action="updateStore.php" method="post"enctype="multipart/form-data">
        <input type="hidden" name="storeNumber" value="<?php echo htmlspecialchars($store['storeNumber'], ENT_QUOTES, 'UTF-8'); ?>">
        
        <label for="companyName">会社名:</label>
        <input type="text" id="companyName" name="companyName" value="<?php echo htmlspecialchars($store['companyName'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="companyPostalCode">郵便番号:</label>
        <input type="text" id="companyPostalCode" name="companyPostalCode" value="<?php echo htmlspecialchars($store['companyPostalCode'], ENT_QUOTES, 'UTF-8'); ?>" required pattern="\d{3}-?\d{4}" title="数字のみを入力してください。">
        
        <label for="companyAddress">会社所在地:</label>
        <input type="text" id="companyAddress" name="companyAddress" value="<?php echo htmlspecialchars($store['companyAddress'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="companyRepresentative">代表者名:</label>
        <input type="text" id="companyRepresentative" name="companyRepresentative" value="<?php echo htmlspecialchars($store['companyRepresentative'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="storeName">店舗名:</label>
        <input type="text" id="storeName" name="storeName" value="<?php echo htmlspecialchars($store['storeName'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="furigana">フリガナ:</label>
        <input type="text" id="furigana" name="furigana" value="<?php echo htmlspecialchars($store['furigana'], ENT_QUOTES, 'UTF-8'); ?>" required pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" title="カタカナのみを入力してください。">
        
        <label for="telephoneNumber">電話番号:</label>
        <input type="text" id="telephoneNumber" name="telephoneNumber" value="<?php echo htmlspecialchars($store['telephoneNumber'], ENT_QUOTES, 'UTF-8'); ?>" required pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" title="数字のみを入力してください。">
        
        <label for="mailAddress">メールアドレス:</label>
        <input type="email" id="mailAddress" name="mailAddress" value="<?php echo htmlspecialchars($store['mailAddress'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="storeDescription">店舗の説明:</label>
        <textarea id="storeDescription" name="storeDescription" rows="4" required><?php echo htmlspecialchars($store['storeDescription'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        
        <label for="storeAdditionalInfo">追加情報:</label>
        <textarea id="storeAdditionalInfo" name="storeAdditionalInfo" rows="4"><?php echo htmlspecialchars($store['storeAdditionalInfo'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        
        <label for="operationsManager">運営責任者:</label>
        <input type="text" id="operationsManager" name="operationsManager" value="<?php echo htmlspecialchars($store['operationsManager'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="contactAddress">連絡先住所:</label>
        <input type="text" id="contactAddress" name="contactAddress" value="<?php echo htmlspecialchars($store['contactAddress'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="contactPostalCode">連絡先郵便番号:</label>
        <input type="text" id="contactPostalCode" name="contactPostalCode" value="<?php echo htmlspecialchars($store['contactPostalCode'], ENT_QUOTES, 'UTF-8'); ?>" required pattern="\d{3}-?\d{4}" title="数字のみを入力してください。">
        
        <label for="contactPhoneNumber">連絡先電話番号:</label>
        <input type="text" id="contactPhoneNumber" name="contactPhoneNumber" value="<?php echo htmlspecialchars($store['contactPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?>" required pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" title="数字のみを入力してください。">
        
        <label for="contactEmailAddress">連絡先メールアドレス:</label>
        <input type="email" id="contactEmailAddress" name="contactEmailAddress" value="<?php echo htmlspecialchars($store['contactEmailAddress'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($store['password'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <button type="submit">更新</button>
    </form>
</body>
</html>
