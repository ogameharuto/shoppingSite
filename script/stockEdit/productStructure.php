<?php
session_start();
// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}

// ストア番号を取得
$storeNumber = $_SESSION['store']['storeNumber'];

$current_page = basename($_SERVER['PHP_SELF']);
// 検索条件の取得
$searchTarget = $_GET['searchTarget'] ?? '';
$searchText = $_GET['searchText'] ?? '';
$publicationStatus = $_GET['publicationStatus'] ?? '';

// 商品データと画像データを取得
$sql = "
    SELECT 
        p.productNumber, 
        p.productName, 
        p.price, 
        p.stockQuantity, 
        p.productDescription, 
        p.dateAdded, 
        p.releaseDate, 
        p.storeNumber, 
        p.pageDisplayStatus, 
        i.imageNumber,
        i.imageHash, 
        i.imageName,
        sc.storeCategoryNumber, 
        sc.storeCategoryName
    FROM product p
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    LEFT JOIN storecategory sc ON p.categoryNumber = sc.storeCategoryNumber
    WHERE p.storeNumber = :storeNumber
";

$params = [':storeNumber' => $storeNumber];

// 検索条件の追加
if ($searchTarget && $searchText) {
    switch ($searchTarget) {
        case "商品コード":
            $sql .= " AND p.productNumber = :searchText";
            $params[':searchText'] = $searchText;
            break;
        case "商品名":
            $sql .= " AND p.productName LIKE :searchText";
            $params[':searchText'] = "%" . $searchText . "%";
            break;
    }
}

if ($publicationStatus) {
    switch ($publicationStatus) {
        case "公開中":
            $sql .= " AND p.pageDisplayStatus = 1";
            break;
        case "非公開":
            $sql .= " AND p.pageDisplayStatus = 0";
            break;
    }
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// カテゴリーデータを取得
$sql = "SELECT * FROM storecategory";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


// カテゴリツリーを構築する関数
function buildTree(array $elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parentStoreCategoryNumber'] == $parentId) {
            $children = buildTree($elements, $element['storeCategoryNumber']);
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
            <div class="navbar">
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">ページ編集</a>
                <a href="http://localhost/shopp/taoka/productManagerMenu.php" class="nav-item <?php echo ($current_page == 'productManagerMenu.php') ? 'active' : ''; ?>">商品管理</a>
                <a href="http://localhost/shopp/script/stockEdit/productStructure.php" class="nav-item <?php echo ($current_page == 'productStructure.php') ? 'active' : ''; ?>">在庫管理</a>
                <a href="http://localhost/shopp/script/imageIns/imageInsMenu.php" class="nav-item <?php echo ($current_page == 'imageInsMenu.php') ? 'active' : ''; ?>">画像管理</a>
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">カテゴリ管理</a>
            </div>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="search-section">
                    <form id="searchForm" method="GET">
                        <h3>商品検索</h3>
                        <div class="flex">
                            <label>検索対象</label>
                            <select name="searchTarget">
                                <option value="商品コード" <?php if ($searchTarget == "商品コード") echo 'selected'; ?>>商品コード</option>
                                <option value="商品名" <?php if ($searchTarget == "商品名") echo 'selected'; ?>>商品名</option>
                            </select>
                        </div>
                        <div class="flex">
                            <label>検索文字</label>
                            <input type="text" name="searchText" value="<?php echo htmlspecialchars($searchText, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="flex">
                            <label>公開状態</label>
                            <select name="publicationStatus">
                                <option value="">全て</option>
                                <option value="公開中" <?php if ($publicationStatus == "公開中") echo 'selected'; ?>>公開中</option>
                                <option value="非公開" <?php if ($publicationStatus == "非公開") echo 'selected'; ?>>非公開</option>
                            </select>
                        </div>
                        <button type="submit" id="searchButton">検索</button>
                    </form>
                </div>
                <div id="categories" class="sitemap">
                    <ul>
                        <li data-path="ストアトップ/">
                            <a href="#" onclick="showBreadcrumb('ストアトップ')">ストアトップ</a>
                            <?php if (!empty($categoryTree)): ?>
                            <ul>
                                <?php
                                function renderTree($tree, $parentPath = 'ストアトップ')
                                {
                                    foreach ($tree as $node) {
                                        $currentPath = $parentPath . '/' . $node['storeCategoryName'];
                                        echo '<li data-path="' . $currentPath . '">';
                                        echo '<a href="#" onclick="showBreadcrumb(\'' . $currentPath . '\')">' . $node['storeCategoryName'] . '</a>';
                                        if (!empty($node['children'])) {
                                            echo '<ul>';
                                            renderTree($node['children'], $currentPath);
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                }
                                // ツリーの表示
                                renderTree($categoryTree);
                                ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div id="breadcrumb"></div>
                <div class="product-list-header">
                    <h3>商品一覧</h3>
                    <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
                </div>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>選択</th>
                            <th>商品コード</th>
                            <th>画像</th>
                            <th>商品名</th>
                            <th>カテゴリ</th>
                            <th>在庫数</th>
                            <th>ステータス</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row): ?>
                            <tr>
                                <td><input type="checkbox" name="products[]" value="<?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                                <td><?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (!empty($row['imageHash'])): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($row['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($row['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100">
                                    <?php else: ?>
                                        画像なし
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['storeCategoryName'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?php echo htmlspecialchars($row['stockQuantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if ($row['pageDisplayStatus'] == 1): ?>
                                        <span>公開中</span>
                                    <?php else: ?>
                                        <span>非公開</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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

        function showBreadcrumb(path) {
            document.getElementById('breadcrumb').innerText = path;
            showCategoryProducts(path.split('/').pop());
        }

        function showCategoryProducts(categoryName) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "fetchCategoryProducts.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector('.product-table tbody').innerHTML = xhr.responseText;
                }
            };
            xhr.send("categoryName=" + encodeURIComponent(categoryName));
        }
    </script>
</body>
</html>
