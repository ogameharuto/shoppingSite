<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // サニタイズと検証
    $categoryNumber = isset($_POST['categoryNumber']) ? intval($_POST['categoryNumber']) : null;
    $categoryName = isset($_POST['categoryName']) ? trim($_POST['categoryName']) : null;
    $parentCategoryNumber = isset($_POST['parentCategoryNumber']) ? (empty($_POST['parentCategoryNumber']) ? null : intval($_POST['parentCategoryNumber'])) : null;

    if ($categoryNumber === null || empty($categoryName)) {
        die("カテゴリ番号またはカテゴリ名が不足しています。");
    }

    // 親カテゴリが存在するか確認
    if ($parentCategoryNumber !== null) {
        $query = "SELECT COUNT(*) FROM category WHERE categoryNumber = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$parentCategoryNumber]);
        $exists = $stmt->fetchColumn();
        
        if (!$exists) {
            die("指定された親カテゴリが存在しません。");
        }
    }

    // 更新クエリの準備と実行
    $query = "UPDATE category SET categoryName = :categoryName, parentCategoryNumber = :parentCategoryNumber WHERE categoryNumber = :categoryNumber";
    $stmt = $pdo->prepare($query);
    
    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $stmt->execute([
            ':categoryName' => $categoryName,
            ':parentCategoryNumber' => $parentCategoryNumber,
            ':categoryNumber' => $categoryNumber
        ]);

        // コミット
        $pdo->commit();

        // 成功時にリダイレクト
        header('Location: categoryManagement.php');
        exit();
    } catch (PDOException $e) {
        // ロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("更新中にエラーが発生しました: " . $e->getMessage());
    }
}

$utilConnDB->disconnect($pdo);
?>
