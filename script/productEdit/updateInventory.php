<?php
session_start();

// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // POST データを取得
    $productNames = $_POST['product_name'] ?? [];
    $specialPrices = $_POST['special_price'] ?? [];
    $startDates = $_POST['start_date'] ?? [];
    $endDates = $_POST['end_date'] ?? [];

    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    try {
        foreach ($productNames as $productCode => $productName) {
            $specialPrice = $specialPrices[$productCode] ?? null;
            $startDate = $startDates[$productCode] ?? null;
            $endDate = $endDates[$productCode] ?? null;

            // 商品情報を更新するクエリ
            $sql = "UPDATE product 
                    SET productName = :productName, price = :specialPrice, dateAdded = :startDate, releaseDate = :endDate 
                    WHERE productNumber = :productCode";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':productName', $productName, PDO::PARAM_STR);
            $statement->bindParam(':specialPrice', $specialPrice, PDO::PARAM_INT);
            $statement->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $statement->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $statement->bindParam(':productCode', $productCode, PDO::PARAM_INT);
            $statement->execute();
        }

        // トランザクションをコミット
        $pdo->commit();
        header('Location: productUpd.php');
    } catch (PDOException $e) {
        // エラーが発生した場合はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "更新中にエラーが発生しました: " . $e->getMessage();
    }
}
?>
