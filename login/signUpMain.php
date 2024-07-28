<?php
header('Content-Type:text/plain; charset=utf-8');

/* インポート */
require_once('siginSql.php');
require_once('signBeans.php');
require_once('utilConnDB.php');

/* インスタンス生成 */
$storeSQL = new StoreSQL();
$storeBeans = new StoreBeans();
$utilConnDB = new UtilConnDB();

/* HTMLからデータを受け取る */
$storeBeans->setCompanyName(htmlspecialchars($_POST['companyName'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyPostalCode(htmlspecialchars($_POST['companyPostalCode'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyAddress(htmlspecialchars($_POST['companyAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyRepresentative(htmlspecialchars($_POST['companyRepresentative'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreName(htmlspecialchars($_POST['storeName'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setFurigana(htmlspecialchars($_POST['furigana'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setTelephoneNumber(htmlspecialchars($_POST['telephoneNumber'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setMailAddress(htmlspecialchars($_POST['mailAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreDescription(htmlspecialchars($_POST['storeDescription'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreImageURL(htmlspecialchars($_POST['storeImageURL'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreAdditionalInfo(htmlspecialchars($_POST['storeAdditionalInfo'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setOperationsManager(htmlspecialchars($_POST['operationsManager'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setInvoiceRegistration('not_registered');
$storeBeans->setContactAddress(htmlspecialchars($_POST['contactAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactPostalCode(htmlspecialchars($_POST['contactPostalCode'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactPhoneNumber(htmlspecialchars($_POST['contactPhoneNumber'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactEmailAddress(htmlspecialchars($_POST['contactEmailAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setPassword(htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'utf-8'));

/* DB接続 */
$pdo = $utilConnDB->connect();

/* SQL文実行 */
$retCount = $storeSQL->insert($pdo, $storeBeans);
if ($retCount == 1) {
    $utilConnDB->commit($pdo);
    $storeBeans->clear(); // 登録成功時にデータをクリア
    $_SESSION['message'] = "登録が成功しました。";
} else {
    $utilConnDB->rollback($pdo);
    $_SESSION['error'] = "登録に失敗しました。";
}

/* DB切断 */
$utilConnDB->disconnect($pdo);

/* 次に実行するモジュール */
header('Location: signComplete.php');
exit;
?>
