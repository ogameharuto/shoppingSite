<?php
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$data = json_decode(file_get_contents('php://input'), true);
$customerNumber = $data['customerNumber'];
$productNumber = $data['productNumber'];
$isActive = $data['isActive'];

try {
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    if ($isActive) {
        // すでにお気に入りに入っている場合は削除
        $deleteSql = "DELETE FROM favoriteProducts WHERE customerNumber = :customerNumber AND productNumber = :productNumber";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([
            ':customerNumber' => $customerNumber,
            ':productNumber' => $productNumber
        ]);
    } else {
        // お気に入りに入っていない場合は挿入
        $insertSql = "INSERT INTO favoriteProducts (customerNumber, productNumber, addeddate) 
                      VALUES (:customerNumber, :productNumber, :addeddate)";
        $insertStmt = $pdo->prepare($insertSql);

        // 現在の日時を取得
        $addeddate = date('Y-m-d H:i:s');

        // データを挿入
        $insertStmt->execute([
            ':customerNumber' => $customerNumber,
            ':productNumber' => $productNumber,
            ':addeddate' => $addeddate
        ]);
    }

    $pdo->commit(); // トランザクションのコミット

    // 成功メッセージを返す
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    $pdo->rollBack(); // エラー発生時にロールバック
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
