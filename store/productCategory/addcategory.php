<?php
require_once('../../utilConnDB.php');
session_start();
$storeNumber = $_SESSION['store'];
try {
    $utilConnDB = new UtilConnDB();
    $pdo = $utilConnDB->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $storeCategoryName = $_POST['storeCategoryName'];
        $parentStoreCategoryNumber = $_POST['parentStoreCategoryNumber'] ?? null;

        // 親カテゴリIDが空の場合、nullとして扱う
        $parentStoreCategoryNumber = empty($parentStoreCategoryNumber) ? null : $parentStoreCategoryNumber;

        try {
            if (!$pdo->inTransaction()) {
                $pdo->beginTransaction();
            }

            // カテゴリをDBに追加
            $query = "INSERT INTO storecategory (storeCategoryName, parentStoreCategoryNumber, storeNumber) VALUES (:storeCategoryName, :parentStoreCategoryNumber, :storeNumber)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':storeCategoryName', $storeCategoryName);
            $stmt->bindParam(':parentStoreCategoryNumber', $parentStoreCategoryNumber);
            $stmt->bindParam(':storeNumber', $storeNumber['storeNumber']);

            if ($stmt->execute()) {
                // 成功時にコミット
                $pdo->commit();
                // 成功時にcategoryManagement.phpにリダイレクト
                header("Location: categoryManagement.php?success=1");
                exit;
            } else {
                // SQLエラーをログに記録
                $errorInfo = $stmt->errorInfo();
                error_log("SQLエラー: " . $errorInfo[2]);
                throw new Exception("カテゴリの追加に失敗しました: " . $errorInfo[2]);
            }
        } catch (Exception $e) {
            // エラー発生時にはロールバック
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e; // 再スローして外側のキャッチで処理する
        }
    }

    try {
        // カテゴリデータの取得
        $sql = "SELECT * FROM storecategory WHERE storeNumber = :storeNumber";
        $stmt = $pdo->prepare($sql);
    
        // クエリの実行
        $stmt->execute([':storeNumber' => $storeNumber['storeNumber']]);
    
        // 結果の取得
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // 結果が空の場合の処理
        if (empty($categories)) {
            throw new Exception("クエリ実行に失敗しました: " . $pdo->errorInfo()[2]);
        }
    
    
    } catch (Exception $e) {
        $message = "エラーが発生しました: " . $e->getMessage();
        error_log($message);
        echo $message;
    }
    

} catch (Exception $e) {
    $message = "エラーが発生しました: " . $e->getMessage();
    error_log($message); // エラーログに記録
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ作成</title>
    <link rel="stylesheet" href="categoryManagement.css"> <!-- CSSファイルをリンク -->
</head>
<body>
    <h1>カテゴリ作成</h1>

    <!-- 実行結果の表示 -->
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="addcategory.php" method="POST">
        <label for="storeCategoryName">カテゴリ名:</label>
        <input type="text" id="storeCategoryName" name="storeCategoryName" required>
        
        <label for="parentStoreCategoryNumber">親カテゴリ (任意):</label>
        <select id="parentStoreCategoryNumber" name="parentStoreCategoryNumber">
            <option value="">-- 親カテゴリを選択 --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['storeCategoryNumber']); ?>">
                    <?php echo htmlspecialchars($category['storeCategoryName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="カテゴリを追加">
    </form>
</body>
</html>
