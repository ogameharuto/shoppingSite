<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if (isset($_GET['storeNumber'])) {
    $storeNumber = (int) $_GET['storeNumber'];
    
    // ストア情報を取得
    $sql = 'SELECT * FROM store WHERE storeNumber = :storeNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
    $stmt->execute();
    $store = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$store) {
        echo "ストア情報が見つかりませんでした。";
        exit;
    }

    // 店舗カテゴリを取得
    $sql = 'SELECT * FROM storeCategory WHERE storeNumber = :storeNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
    $stmt->execute();
    $storeCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // カテゴリを親子構造に整形
    $categoryTree = [];
    foreach ($storeCategories as $category) {
        if ($category['parentStoreCategoryNumber'] == 0) {
            // 親カテゴリ
            $categoryTree[$category['storeCategoryNumber']] = $category;
            $categoryTree[$category['storeCategoryNumber']]['children'] = [];
        } else {
            // 子カテゴリ
            $categoryTree[$category['parentStoreCategoryNumber']]['children'][] = $category;
        }
    }
} else {
    echo "ストア番号が指定されていません。";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/storeInformation.css">
    <link rel="stylesheet" type="text/css" href="../../css/header.css" />
    <title>ストア情報</title>
</head>
<body>
    <?php include "../header.php"; ?>
    <div class="container">
        <div class="sidebar">
            <h2>カテゴリ一覧</h2>
            <ul>
                <?php foreach ($categoryTree as $parentCategory): ?>
                    <li>
                        <a href="#" class="parent-link" data-category-id="<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($parentCategory['storeCategoryName'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <?php if (!empty($parentCategory['children'])): ?>
                            <ul class="child-categories">
                                <li>
                                    <a href="storeCategoryProductLsit.php?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>&showAll=true">
                                        すべての商品
                                    </a>
                                </li>
                                <?php foreach ($parentCategory['children'] as $childCategory): ?>
                                    <li>
                                        <a href="storeCategoryProductLsit.php?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($childCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= htmlspecialchars($childCategory['storeCategoryName'], ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="child-categories">
                                <li>
                                    <a href="storeCategoryProductLsit.php?storeNumber=<?= htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8'); ?>&storeCategoryNumber=<?= htmlspecialchars($parentCategory['storeCategoryNumber'], ENT_QUOTES, 'UTF-8'); ?>&showAll=true">
                                        すべての商品
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="main-content">
            <div class="section">
                <h2>会社概要</h2>
                <table>
                    <tr>
                        <th>会社名（商号）</th>
                        <td><?= htmlspecialchars($store['companyName'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td><?= htmlspecialchars($store['companyAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>代表者</th>
                        <td><?= htmlspecialchars($store['companyRepresentative'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>ストア名</th>
                        <td><?= htmlspecialchars($store['storeName'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>ストア名（フリガナ）</th>
                        <td><?= htmlspecialchars($store['furigana'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>ストア紹介</th>
                        <td><?= htmlspecialchars($store['storeDescription'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>備考</th>
                        <td><?= htmlspecialchars($store['storeAdditionalInfo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <h2>お問い合わせ情報</h2>
                <table>
                    <tr>
                        <th>運営責任者</th>
                        <td><?= htmlspecialchars($store['operationsManager'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td><?= htmlspecialchars($store['contactAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>お問い合わせ電話番号</th>
                        <td><?= htmlspecialchars($store['contactPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>お問い合わせメールアドレス</th>
                        <td><?= htmlspecialchars($store['contactEmailAddress'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr>
                        <th>ストア営業時間/時間</th>
                        <td><?= htmlspecialchars($store['storeAdditionalInfo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.parent-link').forEach(function(parentLink) {
            parentLink.addEventListener('click', function(e) {
                e.preventDefault();

                const childCategories = this.parentElement.querySelector('.child-categories');
                if (childCategories) {
                    const isDisplayed = childCategories.style.display === 'block';
                    document.querySelectorAll('.child-categories').forEach(function(ul) {
                        ul.style.display = 'none';
                    });
                    childCategories.style.display = isDisplayed ? 'none' : 'block';
                }
            });
        });
    </script>
</body>
</html>
