<?php
session_start();

// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST データを取得
    $productNames = $_POST['productName'] ?? [];
    $specialPrices = $_POST['price'] ?? [];
    $startDates = $_POST['dateAdded'] ?? [];
    $endDates = $_POST['releaseDate'] ?? [];

    // デバッグ出力: POST データの確認
    echo "<h2>POST Data:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // データ検証（例: 特価は数値である必要があります）
    foreach ($specialPrices as $productNumber => $price) {
        if (!is_numeric($price)) {
            echo "特価は数値である必要があります。";
            exit;
        }
    }

    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    try {
        foreach ($productNames as $productNumber => $productName) {
            $price = $specialPrices[$productNumber] ?? null;
            $dateAdded = $startDates[$productNumber] ?? null;
            $releaseDate = $endDates[$productNumber] ?? null;

            // 商品情報を更新するクエリ
            $sql = "UPDATE product 
                    SET productName = :productName, price = :price, dateAdded = :dateAdded, releaseDate = :releaseDate 
                    WHERE productNumber = :productNumber";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':productName', $productName, PDO::PARAM_STR);
            $statement->bindParam(':price', $price, PDO::PARAM_STR); // 特価が浮動小数点数の場合
            $statement->bindParam(':dateAdded', $dateAdded, PDO::PARAM_STR);
            $statement->bindParam(':releaseDate', $releaseDate, PDO::PARAM_STR);
            $statement->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            $statement->execute();

            // SQLエラーの確認
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != PDO::ERR_NONE) {
                throw new PDOException($errorInfo[2]);
            }
        }

        // トランザクションをコミット
        $pdo->commit();

        // 成功後のリダイレクト
        header('Location: ../../taoka/productManagerMenu.php');
        exit;

    } catch (PDOException $e) {
        // エラーが発生した場合はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // エラーメッセージの表示
        echo "更新中にエラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?>
