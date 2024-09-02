<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB=New UtilConnDB();
$pdo=$utilConnDB->connect();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: ../account/storeLoginMenu.php");
    exit();
}

// カテゴリデータの取得
$query = "SELECT * FROM storecategory";
$result = $pdo->query($query);

if (!$result) {
    die("クエリ実行に失敗しました: " . $mysqli->error);
}

$categories = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = $row;
}
?>




<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ管理</title>
    <link rel="stylesheet" href="SPro19.css"> <!-- CSSファイルをリンク -->
</head>
<body>
    <h1>カテゴリ管理</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>カテゴリ名</th>
                <th>親カテゴリID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['storeCategoryNumber']); ?></td>
                    <td><?php echo htmlspecialchars($category['storeCategoryName']); ?></td>
                    <td><?php echo htmlspecialchars($category['parentStoreCategoryNumber']); ?></td>
                    <td>

                        <a href="CategoryEditMenu.php?storeCategoryNumber=<?php echo $category['storeCategoryNumber']; ?>">編集</a>

                        <a href="categoryDelMain.php?storeCategoryNumber=<?php echo $category['storeCategoryNumber']; ?>
                        " onclick="return confirm('本当に削除しますか？');">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="addcategory.php">カテゴリを追加</a>
</body>
</html>
