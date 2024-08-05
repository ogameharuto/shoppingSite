<?php
session_start();
header('Content-Type:text/plain; charset=utf-8');

require_once('../utilConnDB.php');
require_once('../storeSQL.php');
require_once('../customerBeans.php');

$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();
$storeBeans = new CustomerBeans();

$storeBeans->setMailAddress(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'utf-8'));
$storeBeans->setPassword(htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'utf-8'));

$pdo = $utilConnDB->connect();

/* SQL文実行 */
$customer = $storeSQL->LogSelect($pdo, $storeBeans);

/* パスワード確認 */
if ($customer) {
    $_SESSION['customer'] = $customer;
    /* DB切断 */
    $utilConnDB->disconnect($pdo);
    header('Location: ../clientToppage.php');
    exit;
} else {
    $_SESSION['error'] = "メールアドレスまたはパスワードが正しくありません。";
    /* DB切断 */
    $utilConnDB->disconnect($pdo);
    header('Location: clientLoginMenu.php');
    exit;
}
?>
