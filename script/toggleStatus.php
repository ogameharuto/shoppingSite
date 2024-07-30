<?php
session_start();
$storeNumber = $_SESSION['store'];

// データベース接続設定
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productNumber = $_POST['productNumber'];
    $action = $_POST['action'];

    // ステータスの設定
    $status = ($action == 'show') ? 1 : 0;

    // クエリの実行
    $sql = "UPDATE product SET pageDisplayStatus = :status WHERE productNumber = :productNumber AND storeNumber = :storeNumber";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':status', $status, PDO::PARAM_INT);
    $statement->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
    $statement->bindParam(':storeNumber', $storeNumber['storeNumber'], PDO::PARAM_INT);

    // クエリの実行結果を確認
    if ($statement->execute()) {
        echo "ステータスが変更されました。";
    } else {
        echo "ステータス変更に失敗しました。";
    }

    // リダイレクト
    header('Location: productStructure.php');
    exit;
}

?>
