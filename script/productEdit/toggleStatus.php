<?php
session_start();
$storeNumber = $_SESSION['store'] ?? null;

if (!$storeNumber) {
    die("店舗番号が設定されていません。");
}

// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productNumber = $_POST['productNumber'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$productNumber || !$action) {
        die("商品番号またはアクションが指定されていません。");
    }

    // ステータスの設定
    $status = ($action == 'show') ? 1 : 0;

    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
    
        // クエリの実行
        $sql = "UPDATE product SET pageDisplayStatus = :status WHERE productNumber = :productNumber AND storeNumber = :storeNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
        $stmt->bindParam(':storeNumber', $storeNumber['storeNumber'], PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $pdo->commit();
        } else {
            $pdo->rollBack();
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack(); 
    }
}
    

    // リダイレクト
    header('Location: productUpd.php');
    exit;
}
?>
