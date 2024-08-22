<?php
require_once('../utilConnDB.php');
$utilConnDB=New UtilConnDB();
$pdo=$utilConnDB->connect();
// カテゴリデータの取得
$query = "SELECT * FROM category";
$result = $pdo->query($query);

if (!$result) {
    die("クエリ実行に失敗しました: " . $mysqli->error);
}

$categories = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = $row;
}
?>
<form action="sakusei.php" method="POST">
    <label for="categoryName">カテゴリ名:</label>
    <input type="text" id="categoryName" name="categoryName" required>
    
    <label for="parentCategoryNumber">親カテゴリ (任意):</label>
    <select id="parentCategoryNumber" name="parentCategoryNumber">
        <option value="">-- 親カテゴリを選択 --</option>
        <!-- PHPを使って既存のカテゴリをここに挿入 -->
        <?php
        // Assume $categories is an array of existing categories
        foreach ($categories as $category) {
            echo "<option value='{$category['categoryNumber']}'>{$category['categoryName']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="カテゴリを追加">
</form>
