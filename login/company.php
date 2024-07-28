<?php
// データベース接続設定
$host = 'localhost';
$dbname = 'syain_db';
$username = 's20225002';
$password = '20040106';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータを受け取る
    $companyName = $_POST['companyName'];
    $companyPostalCode = $_POST['postalCode'];
    $companyAddress = $_POST['fullAddress'];
    $companyRepresentative = $_POST['representativeName'];
    $storeName = $_POST['storeName'];
    $furigana = $_POST['storeNameFurigana'];
    $telephoneNumber = $_POST['phoneNumber'];
    $mailAddress = $_POST['mailAddres'];
    $storeDescription = $_POST['storeIntroduction'];
    $storeImageURL = $_POST['storeImageURL'];
    $storeAdditionalInfo = $_POST['storeAdditionalInfo'];
    $operationsManager = $_POST['operationsManager'];
    $invoice_registration = "not_registered";
    $contactAddress = $_POST['contactAddress'];
    $contactPostalCode = $_POST['contactPostalCode'];
    $contactPhoneNumber = $_POST['contactPhoneNumber'];
    $contactEmailAddress = $_POST['contactEmailAddress'];
    $password = $_POST['pass'];
    // storeNumberの生成
    $storeNumber = '番号' . sprintf('%04d', getLastStoreNumber($pdo) + 1);

    // SQLクエリの準備
    $sql = "INSERT INTO stores (
                storeNumber, companyName, companyPostalCode, companyAddress, companyRepresentative, 
                storeName, furigana, telephoneNumber, mailAddress, storeDescription, 
                storeImageURL, storeAdditionalInfo, operationsManager, invoice_registration, 
                contactAddress, contactPostalCode, contactPhoneNumber, contactEmailAddress, password
            ) VALUES (
                :storeNumber, :companyName, :companyPostalCode, :companyAddress, :companyRepresentative, 
                :storeName, :furigana, :telephoneNumber, :mailAddress, :storeDescription, 
                :storeImageURL, :storeAdditionalInfo, :operationsManager, :invoice_registration, 
                :contactAddress, :contactPostalCode, :contactPhoneNumber, :contactEmailAddress, :password
            )";

    // データベースにデータを挿入
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':storeNumber' => $storeNumber,
        ':companyName' => $companyName,
        ':companyPostalCode' => $companyPostalCode,
        ':companyAddress' => $companyAddress,
        ':companyRepresentative' => $companyRepresentative,
        ':storeName' => $storeName,
        ':furigana' => $furigana,
        ':telephoneNumber' => $telephoneNumber,
        ':mailAddress' => $mailAddress,
        ':storeDescription' => $storeDescription,
        ':storeImageURL' => $storeImageURL,
        ':storeAdditionalInfo' => $storeAdditionalInfo,
        ':operationsManager' => $operationsManager,
        ':invoice_registration' => $invoice_registration,
        ':contactAddress' => $contactAddress,
        ':contactPostalCode' => $contactPostalCode,
        ':contactPhoneNumber' => $contactPhoneNumber,
        ':contactEmailAddress' => $contactEmailAddress,
        ':password' => $password
    ]);

    echo "データベースにデータが正常に登録されました。";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

// 最後のstoreNumberを取得する関数
function getLastStoreNumber($pdo) {
    $stmt = $pdo->query("SELECT storeNumber FROM stores ORDER BY storeNumber DESC LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && preg_match('/番号(\d+)/', $row['storeNumber'], $matches)) {
        return (int)$matches[1];
    } else {
        return 0; // データが存在しない場合は0を返す
    }
}
?>
