<?php
header('Content-Type:text/plain; charset=utf-8');

/* インポート */
require_once('../storeSQL.php'); 
require_once('../utilConnDB.php');

/* インスタンス生成 */
$cartDAO = new StoreSQL();
$utilConnDB = new UtilConnDB();

/* main */
/* DB接続 */
$pdo = $utilConnDB->connect();

/* 顧客番号の取得 */
session_start();
$customerNumber = 1;

/* SQL文実行
   カートテーブルを読み込み、ArrayListに登録して戻す 
*/
$cartList = array();
if ($customerNumber !== null) {
    $cartList = $cartDAO->selectCartItems($pdo, $customerNumber);
} else {
    // 顧客番号がセッションに保存されていない場合の処理
    $cartList = [];
}

/* DB切断 */
$pdo = $utilConnDB->disconnect($pdo);

/* データを渡す */
$_SESSION['cartList'] = $cartList;

/* 次に実行するモジュール */
header('Location: cartList.php');
exit;
?>
