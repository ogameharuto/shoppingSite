<?php
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// POSTデータを受け取る
$customerName = $_POST['customerName'] ?? null;
$furigana = $_POST['furigana'] ?? null;
$address = $_POST['address'] ?? null;
$postCode = $_POST['postCode'] ?? null;
$dateOfBirth = $_POST['dateOfBirth'] ?? null;
$mailAddress = $_POST['mailAddress'] ?? null;
$telephoneNumber = $_POST['telephoneNumber'] ?? null;
$password = $_POST['password'] ?? null;

// 必須フィールドの検証
if (!$customerName || !$furigana || !$address || !$postCode || !$dateOfBirth || !$mailAddress || !$telephoneNumber || !$password) {
    throw new Exception('すべての必須フィールドを入力してください。');
}
try {
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }
    // SQLクエリの準備
    $sql = 'INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) 
            VALUES (:customerName, :furigana, :address, :postCode, :dateOfBirth, :mailAddress, :telephoneNumber, :password)';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':customerName' => $customerName,
        ':furigana' => $furigana,
        ':address' => $address,
        ':postCode' => $postCode,
        ':dateOfBirth' => $dateOfBirth,
        ':mailAddress' => $mailAddress,
        ':telephoneNumber' => $telephoneNumber,
        ':password' => $password
    ]);
    // コミット
    $pdo->commit();

    echo '登録が完了しました。';
    header('Location: http://localhost/shopp/script/login/clientLoginMenu.php');
} catch (PDOException $e) {
    echo 'データベースエラー: ' . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    echo 'エラー: ' . htmlspecialchars($e->getMessage());
}
?>
