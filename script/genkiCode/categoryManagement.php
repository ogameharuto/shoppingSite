<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリデータの取得
$query = "SELECT * FROM category";
try {
    $result = $pdo->query($query);

    if (!$result) {
        throw new PDOException("クエリ実行に失敗しました: " . implode(", ", $pdo->errorInfo()));
    }

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
    <link rel="stylesheet" href="SPro19.css">
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
                    <td><?php echo htmlspecialchars($category['categoryNumber']); ?></td>
                    <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
                    <td><?php echo htmlspecialchars($category['parentCategoryNumber']); ?></td>
                    <td>
                        <a href="categoryEditMenu.php?categoryNumber=<?php echo urlencode($category['categoryNumber']); ?>">編集</a>
                        <a href="categoryDel.php?categoryNumber=<?php echo urlencode($category['categoryNumber']); ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="SPro20.php">カテゴリを追加</a>
</body>
</html>
