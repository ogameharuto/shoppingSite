<?php
require_once('../../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリ番号が指定されているか確認
if (!isset($_GET['storeCategoryNumber'])) {
    die("カテゴリ番号が指定されていません。");
}

$storeCategoryNumber = intval($_GET['storeCategoryNumber']);

// カテゴリ情報を取得
$query = "SELECT * FROM storecategory WHERE storeCategoryNumber = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$storeCategoryNumber]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("カテゴリが見つかりません。");
}

// すべてのカテゴリを取得して親カテゴリの選択肢を生成
$query = "SELECT * FROM storecategory WHERE storeCategoryNumber != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$storeCategoryNumber]);
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
    <form action="categoryEditMain.php" method="POST">
        <input type="hidden" name="storeCategoryNumber" value="<?php echo htmlspecialchars($storeCategoryNumber); ?>">
        <label for="storeCategoryName">カテゴリ名:</label>
        <input type="text" id="storeCategoryName" name="storeCategoryName" value="<?php echo htmlspecialchars($category['storeCategoryName']); ?>" required>
        <label for="parentstoreCategoryNumber">親カテゴリ (任意):</label>
        <select id="parentstoreCategoryNumber" name="parentstoreCategoryNumber">
            <option value="">-- 親カテゴリを選択 --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['storeCategoryNumber']); ?>"
                    <?php echo $cat['storeCategoryNumber'] == $category['parentStoreCategoryNumber'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['storeCategoryName']); ?>
                </option>
            <?php endforeach; ?>
            <!-- 親カテゴリなしの選択肢 -->
            <option value="" <?php echo $category['parentStoreCategoryNumber'] === null ? 'selected' : ''; ?>>親カテゴリなし</option>
        </select>
        <input type="submit" value="保存">
    </form>
</body>
</html>
