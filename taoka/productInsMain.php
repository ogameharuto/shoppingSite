<?php
session_start();
$storeNumber = $_SESSION['store'];

/* インポート */
require_once('../script/utilConnDB.php');

/* インスタンス生成 */
$utilConnDB = new UtilConnDB();

/* HTMLからデータを受け取る */
$productName = htmlspecialchars($_POST['productName'], ENT_QUOTES, 'utf-8');
$price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8');
$category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'utf-8');
$stock = htmlspecialchars($_POST['stock'], ENT_QUOTES, 'utf-8');
$productDescription = htmlspecialchars($_POST['productDescription'], ENT_QUOTES, 'utf-8');
$releaseDate = htmlspecialchars($_POST['releaseDate'], ENT_QUOTES, 'utf-8');
$pageDisplayStatus = htmlspecialchars($_POST['pageDisplayStatus'], ENT_QUOTES, 'utf-8');

//DB接続
$pdo = $utilConnDB->connect();

$sql = "INSERT INTO product (
            productName, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus
        ) VALUES (
            :productName, :price, :categoryNumber, :stockQuantity, :productDescription, :dateAdded, :releaseDate, :storeNumber, :pageDisplayStatus
        )";
$params[':productName'] = $productName;
$params[':price'] = $price;
$params[':categoryNumber'] = $category;
$params[':stockQuantity'] = $stock;
$params[':productDescription'] = $productDescription;
$params[':dateAdded'] = date("Y-m-d");
$params[':releaseDate'] = $releaseDate;
$params[':storeNumber'] = $storeNumber['storeNumber'];
$params[':pageDisplayStatus'] = $pageDisplayStatus;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if($stmt == true){
    $utilConnDB->commit($pdo);
    $_SESSION['message'] = '登録が完了しました。';
}
else{
    $utilConnDB->rollback($pdo);
}

//DB切断
$utilConnDB->disconnect($pdo);

//次に実行するモジュール
header('Location: productManagerMenu.php')
?>