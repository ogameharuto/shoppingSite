<?php
session_start();
// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}
// カテゴリーデータを取得
$sql = "SELECT categoryNumber, categoryName, parentCategoryNumber FROM category";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリツリーを構築する関数
function buildTree(array $elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parentCategoryNumber'] == $parentId) {
            $children = buildTree($elements, $element['categoryNumber']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

// カテゴリツリーを生成
$categoryTree = buildTree($categories);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫管理</title>
    <link rel="stylesheet" href="productStructure.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="menu">
                <div class="menu-item">ページ編集</div>
                <div class="menu-item">商品管理</div>
                <div class="menu-item">在庫管理</div>
                <div class="menu-item">画像管理</div>
                <div class="menu-item">カテゴリ管理</div>
            </div>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="search-section">
                    <h3>商品検索</h3>
                    <form>
                        <input type="text" placeholder="商品コード">
                        <button type="submit">検索</button>
                    </form>
                </div>
                <div id="categories" class="sitemap">
                <li data-path="ストアトップ/">
                    <a href="#" onclick="showBreadcrumb('ストアトップ')">ストアトップ</a>
                    <ul>
                        <?php
                        // カテゴリツリーをHTMLで表示する関数
                        function renderTree($tree, $parentPath = 'ストアトップ')
                        {
                            foreach ($tree as $node) {
                                $currentPath = $parentPath . '/' . $node['categoryName'];
                                echo '<ul>';
                                echo '<li data-path="' . $currentPath . '">';
                                echo '<a href="#" onclick="showBreadcrumb(\'' . $currentPath . '\')">' . $node['categoryName'] . '</a>';
                                if (!empty($node['children'])) {
                                    renderTree($node['children'], $currentPath);
                                }
                                echo '</li>';
                                echo '</ul>';
                            }
                        }

                        // ツリーの表示
                        renderTree($categoryTree);
                        ?>
                    </ul>
            </div>
            </div>
            <div class="main-content">
                <div class="product-list-header">
                    <h3>商品一覧</h3>
                    <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
                </div>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>選択</th>
                                <th>商品コード</th>
                                <th>商品名</th>
                                <th>カテゴリ</th>
                                <th>在庫数</th>
                                <th>ステータス</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'fetchProducts.php'; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    <script>
function handleEditButtonClick() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    if (checkboxes.length === 0) {
        alert("編集する商品を選んでください.");
        return;
    }
    const selectedItems = [];
    checkboxes.forEach((checkbox) => {
        selectedItems.push(checkbox.value);
    });

    // POST リクエストを送信
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'editProductInventoryMain.php';

    selectedItems.forEach((item) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product[]';
        input.value = item;
        form.appendChild(input);
    });
    document.body.appendChild(form);
    form.submit();
}

    </script>
</body>
</html>
