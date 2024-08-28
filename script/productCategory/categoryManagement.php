<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$storeNumber = $_SESSION['store']['storeNumber'];

// カテゴリデータの取得
$query = "SELECT * FROM storecategory WHERE storeNumber = :storeNumber";
$result = $pdo->prepare($query);
$result->bindValue(':storeNumber', $storeNumber, PDO::PARAM_INT);
$result->execute();

try {
    $categories = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = $row;
    }
} catch (PDOException $e) {
    die("エラー: " . $e->getMessage());
} finally {
    $utilConnDB->disconnect($pdo);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ管理</title>
    <link rel="stylesheet" href="categoryManagement.css">
</head>
<body>
    <h1>カテゴリ管理</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>カテゴリ名</th>
                <th>親カテゴリID</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['storeCategoryNumber']); ?></td>
                    <td><?php echo htmlspecialchars($category['storeCategoryName']); ?></td>
                    <td><?php echo htmlspecialchars($category['parentStoreCategoryNumber']); ?></td>
                    <td>
                        <a href="categoryEditMenu.php?storeCategoryNumber=<?php 
                            echo urlencode($category['storeCategoryNumber']); ?>">編集</a>
                        <a href="categoryDelMain.php?storeCategoryNumber=<?php 
                            echo urlencode($category['storeCategoryNumber']); ?>" 
                            onclick="return confirm('本当に削除しますか？');">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="addcategory.php">カテゴリを追加</a>
</body>
</html>
