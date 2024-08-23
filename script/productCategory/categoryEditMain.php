<?php
require_once('../../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // サニタイズと検証
    $storeCategoryNumber = isset($_POST['storeCategoryNumber']) ? intval($_POST['storeCategoryNumber']) : null;
    $storeCategoryName = isset($_POST['storeCategoryName']) ? trim($_POST['storeCategoryName']) : null;
    $parentStoreCategoryNumber = isset($_POST['parentStoreCategoryNumber']) ? (empty($_POST['parentStoreCategoryNumber']) ? null : intval($_POST['parentStoreCategoryNumber'])) : null;

    if ($storeCategoryNumber === null || empty($storeCategoryName)) {
        die("カテゴリ番号またはカテゴリ名が不足しています。");
    }

    // 親カテゴリが存在するか確認
    if ($parentStoreCategoryNumber !== null) {
        $query = "SELECT COUNT(*) FROM storecategory WHERE storeCategoryNumber = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$parentStoreCategoryNumber]);
        $exists = $stmt->fetchColumn();
        
        if (!$exists) {
            die("指定された親カテゴリが存在しません。");
        }
    }

    // 更新クエリの準備と実行
    $query = "UPDATE storecategory SET storeCategoryName = :storeCategoryName, parentStoreCategoryNumber = :parentStoreCategoryNumber WHERE storeCategoryNumber = :storeCategoryNumber";
    $stmt = $pdo->prepare($query);
    
    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $stmt->execute([
            ':storeCategoryName' => $storeCategoryName,
            ':parentStoreCategoryNumber' => $parentStoreCategoryNumber,
            ':storeCategoryNumber' => $storeCategoryNumber
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
