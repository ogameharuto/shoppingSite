<?php
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリ番号が指定されているか確認
if (!isset($_GET['categoryNumber'])) {
    die("カテゴリ番号が指定されていません。");
}

$categoryNumber = intval($_GET['categoryNumber']);

// カテゴリ情報を取得
$query = "SELECT * FROM category WHERE categoryNumber = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$categoryNumber]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("カテゴリが見つかりません。");
}

// すべてのカテゴリを取得して親カテゴリの選択肢を生成
$query = "SELECT * FROM category WHERE categoryNumber != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$categoryNumber]);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ編集</title>
</head>
<body>
    <h1>カテゴリ編集</h1>
    <form action="categoryEditMein.php" method="POST">
        <input type="hidden" name="categoryNumber" value="<?php echo htmlspecialchars($categoryNumber); ?>">
        <label for="categoryName">カテゴリ名:</label>
        <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['categoryName']); ?>" required>
        <label for="parentCategoryNumber">親カテゴリ (任意):</label>
        <select id="parentCategoryNumber" name="parentCategoryNumber">
            <option value="">-- 親カテゴリを選択 --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['categoryNumber']); ?>"
                    <?php echo $cat['categoryNumber'] == $category['parentCategoryNumber'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['categoryName']); ?>
                </option>
            <?php endforeach; ?>
            <!-- 親カテゴリなしの選択肢 -->
            <option value="" <?php echo $category['parentCategoryNumber'] === null ? 'selected' : ''; ?>>親カテゴリなし</option>
        </select>
        <input type="submit" value="保存">
    </form>
</body>
</html>
