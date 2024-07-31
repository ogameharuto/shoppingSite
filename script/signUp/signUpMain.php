<?php
header('Content-Type:text/plain; charset=utf-8');

/* インポート */
require_once('../storeSQL.php');
require_once('../companyBeans.php');
require_once('../utilConnDB.php');

/* セッションの開始 */
session_start();

/* インスタンス生成 */
$storeSQL = new StoreSQL();
$storeBeans = new StoreBeans();
$utilConnDB = new UtilConnDB();

/* HTMLからデータを受け取る */
$storeBeans->setCompanyName(htmlspecialchars($_POST['companyName'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyPostalCode(htmlspecialchars($_POST['postalCode'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyAddress(htmlspecialchars($_POST['fullAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setCompanyRepresentative(htmlspecialchars($_POST['representativeName'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreName(htmlspecialchars($_POST['storeName'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setFurigana(htmlspecialchars($_POST['storeNameFurigana'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setTelephoneNumber(htmlspecialchars($_POST['phoneNumber'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setMailAddress(htmlspecialchars($_POST['mailAddres'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreDescription(htmlspecialchars($_POST['storeIntroduction'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreImageURL(htmlspecialchars($_POST['storeImageURL'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setStoreAdditionalInfo(htmlspecialchars($_POST['storeAdditionalInfo'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setOperationsManager(htmlspecialchars($_POST['operationsManager'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactAddress(htmlspecialchars($_POST['contactAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactPostalCode(htmlspecialchars($_POST['contactPostalCode'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactPhoneNumber(htmlspecialchars($_POST['contactPhoneNumber'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setContactEmailAddress(htmlspecialchars($_POST['contactEmailAddress'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setPassword(htmlspecialchars($_POST['pass'] ?? '', ENT_QUOTES, 'utf-8'));

/* DB接続 */
    $pdo = $utilConnDB->connect();


    /* SQL文実行 */
    $retCount = $storeSQL->insert($pdo, $storeBeans);
    if ($retCount == 1) {
        $pdo->commit();
        $storeBeans->clear();
        $_SESSION['message'] = "登録が成功しました。";
    } else {
        $pdo->rollback();
        $_SESSION['error'] = "登録に失敗しました。";
    }
    $utilConnDB->disconnect($pdo);


/* 次に実行するモジュール */
header('Location: signComplete.php');
exit;
?>
