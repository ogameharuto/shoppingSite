<?php
session_start();

// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // デバッグ出力 (実際の運用ではコメントアウトまたは削除することを推奨)
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // データの取得
    $methods = $_POST['method'] ?? [];
    $values = $_POST['value'] ?? [];
    $allowOverflow = $_POST['allow_overflow'] ?? [];
    $disallowOverflow = $_POST['disallow_overflow'] ?? [];

    try {
        // トランザクションが既に開始されている場合はスキップ
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        foreach ($methods as $productId => $method) {
            $value = $values[$productId] ?? 0;

            // 現在の在庫数を取得
            $sql = "SELECT stockQuantity FROM product WHERE productNumber = :productNumber";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':productNumber', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // 現在の在庫数が取得できない場合は0に設定
            $currentStockDb = $result ? $result['stockQuantity'] : 0;

            // 新しい在庫数を計算
            switch ($method) {
                case '足す':
                    $newStock = $currentStockDb + $value;
                    break;
                case '引く':
                    $newStock = $currentStockDb - $value;
                    break;
                case '値にする':
                    $newStock = $value;
                    break;
                default:
                    $newStock = $currentStockDb;
                    break;
            }

            // 在庫数の更新
            $sql = "UPDATE product SET stockQuantity = :newStock WHERE productNumber = :productNumber";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
            $stmt->bindParam(':productNumber', $productId, PDO::PARAM_INT);
            $stmt->execute();

            // SQLエラーの確認
            $errorInfo = $stmt->errorInfo();
            if ($errorInfo[0] != PDO::ERR_NONE) {
                throw new PDOException($errorInfo[2]);
            }
        }

        // トランザクションのコミット
        if ($pdo->inTransaction()) {
            $pdo->commit();
        }
        header('Location: productStructure.php');
        exit;

    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // エラー処理 (デバッグ用)
        echo "Error: " . $e->getMessage();
    }
}
?>
