<?php
session_start();

// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: ../account/storeLoginMenu.php");
    exit();
}

// 商品一覧ページから送信された選択された商品のIDを取得
$products = $_SESSION['products'] ?? [];
$storeNumber = $_SESSION['store']['storeNumber'];

// カテゴリ情報を取得
$sql = "SELECT categoryNumber, categoryName FROM category";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$shoppCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリ情報を取得
$sql = "SELECT storeCategoryNumber, storeCategoryName FROM storecategory WHERE storeNumber = :storeNumber";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
$stmt->execute();
$storeCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script>
        function confirmUpdate() {
            return confirm("商品を更新してもよろしいですか？");
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>商品情報編集</h1>
            <p>商品の情報を編集します。変更内容を確認してください。</p>
        </div>
        <div class="content">
            <form action="updateInventory.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmUpdate();">
                <table class="edit-table">
                    <thead>
                        <tr>
                            <th>商品コード</th>
                            <th>現在の商品画像</th>
                            <th>編集する商品画像</th>
                            <th>商品名</th>
                            <th>特価</th>
                            <th>ストアカテゴリ</th>
                            <th>ショップカテゴリ</th>
                            <th>販売開始日</th>
                            <th>販売終了日</th>
                            <th>表示ステータス</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['productNumber']); ?></td>
                            <td>
                                <?php if (!empty($product['imageHash'])): ?>
                                    <img src="../../uploads/<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100">
                                <?php else: ?>
                                    画像なし
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="file" name="productImage[<?php echo htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>]">
                            </td>
                            <td>
                                <input type="text" name="productName[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['productName']); ?>">
                            </td>
                            <td>
                                <input type="text" name="price[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>">
                            </td>
                            <td>
                                <select name="storeCategoryNumber[<?php echo htmlspecialchars($product['productNumber']); ?>]">
                                    <?php foreach ($storeCategories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['storeCategoryNumber']); ?>"
                                            <?php if ($product['storeCategoryNumber'] == $category['storeCategoryNumber']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($category['storeCategoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="categoryNumber[<?php echo htmlspecialchars($product['productNumber']); ?>]">
                                    <?php foreach ($shoppCategories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['categoryNumber']); ?>"
                                            <?php if ($product['categoryNumber'] == $category['categoryNumber']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($category['categoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="dateAdded[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['dateAdded']); ?>">
                            </td>
                            <td>
                                <input type="text" name="releaseDate[<?php echo htmlspecialchars($product['productNumber']); ?>]" value="<?php echo htmlspecialchars($product['releaseDate']); ?>">
                            </td>
                            <td>
                                <select name="pageDisplayStatus[<?php echo htmlspecialchars($product['productNumber']); ?>]">
                                    <option value="1" <?php if ($product['pageDisplayStatus'] == 1) echo 'selected'; ?>>公開</option>
                                    <option value="0" <?php if ($product['pageDisplayStatus'] == 0) echo 'selected'; ?>>非公開</option>
                                </select>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">確認</button>
                <button type="button" onclick="window.history.back();">キャンセル</button>
            </form>
        </div>
    </div>
</body>
</html>

